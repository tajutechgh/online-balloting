<?php
/**
 *
 * Crypto
 *
 */

class Crypto
{
    const VW_KEY = "@tajutechgh"; // this should never be changed
    const HASH_ALGO = 'ripemd160';
    const METHOD = 'aes-256-cbc';

    public static function safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

    public static function safe_b64decode($string)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public static function encode($value)
    {
        if (!$value) {
            return false;
        }
        $user_id = "20";
        return self::encrypt($value, self::VW_KEY . "_" . $user_id, true);
    }

    public static function decode($value)
    {
        if (!$value) {
            return false;
        }
        $user_id = "20";
        return self::decrypt($value, self::VW_KEY . "_" . $user_id, true);
    }

    /**
     * Encrypts then MACs a message
     *
     * @param string $message - plaintext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encode - set to TRUE to return a base64-encoded string
     * @return string (raw binary)
     */
    public static function encrypt($message, $key, $encode = false)
    {
        list($encKey, $authKey) = self::splitKeys($key);

        // Pass to UnsafeCrypto::encrypt
        $ciphertext = self::unsafeEncrypt($message, $encKey);

        // Calculate a MAC of the IV and ciphertext
        $mac = hash_hmac(self::HASH_ALGO, $ciphertext, $authKey, true);

        if ($encode) {
            return self::safe_b64encode($mac . $ciphertext);
        }
        // Prepend MAC to the ciphertext and return to caller
        return $mac . $ciphertext;
    }

    /**
     * Decrypts a message (after verifying integrity)
     *
     * @param string $message - ciphertext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encoded - are we expecting an encoded string?
     * @return string (raw binary)
     */
    public static function decrypt($message, $key, $encoded = false)
    {
        list($encKey, $authKey) = self::splitKeys($key);
        if ($encoded) {
            $message = self::safe_b64decode($message, true);
            if ($message === false) {
                throw new Exception('Encryption failure');
            }
        }

        // Hash Size -- in case HASH_ALGO is changed
        $hs = mb_strlen(hash(self::HASH_ALGO, '', true), '8bit');
        $mac = mb_substr($message, 0, $hs, '8bit');

        $ciphertext = mb_substr($message, $hs, null, '8bit');

        $calculated = hash_hmac(
            self::HASH_ALGO,
            $ciphertext,
            $authKey,
            true
        );

        if (!self::hashEquals($mac, $calculated)) {
            throw new Exception('Encryption failure');
        }

        // Pass to UnsafeCrypto::decrypt
        $plaintext = self::unsafeDecrypt($ciphertext, $encKey);

        return $plaintext;
    }

    /**
     * Splits a key into two separate keys; one for encryption
     * and the other for authenticaiton
     *
     * @param string $masterKey (raw binary)
     * @return array (two raw binary strings)
     */
    protected static function splitKeys($masterKey)
    {
        // You really want to implement HKDF here instead!
        return [
            hash_hmac(self::HASH_ALGO, 'ENCRYPTION', $masterKey, true),
            hash_hmac(self::HASH_ALGO, 'AUTHENTICATION', $masterKey, true),
        ];
    }

    /**
     * Compare two strings without leaking timing information
     *
     * @param string $a
     * @param string $b
     * @return boolean
     */
    protected static function hashEquals($a, $b)
    {
        if (function_exists('hash_equals')) {
            return hash_equals($a, $b);
        }
        $nonce = openssl_random_pseudo_bytes(32);
        return hash_hmac(self::HASH_ALGO, $a, $nonce) === hash_hmac(self::HASH_ALGO, $b, $nonce);
    }

    /**
     * Encrypts (but does not authenticate) a message
     *
     * @param string $message - plaintext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encode - set to TRUE to return a base64-encoded
     * @return string (raw binary)
     */
    public static function unsafeEncrypt($message, $key, $encode = false)
    {
        $ivSize = openssl_cipher_iv_length(self::METHOD);
        $iv = openssl_random_pseudo_bytes($ivSize);

        $ciphertext = openssl_encrypt(
            $message,
            self::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        // Now let's pack the IV and the ciphertext together
        // Naively, we can just concatenate
        if ($encode) {
            return self::safe_b64encode($iv . $ciphertext);
        }
        return $iv . $ciphertext;
    }

    /**
     * Decrypts (but does not verify) a message
     *
     * @param string $message - ciphertext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encoded - are we expecting an encoded string?
     * @return string
     */
    public static function unsafeDecrypt($message, $key, $encoded = false)
    {
        if ($encoded) {
            $message = self::safe_b64decode($message, true);
            if ($message === false) {
                throw new Exception('Encryption failure');
            }
        }

        $ivSize = openssl_cipher_iv_length(self::METHOD);
        $iv = mb_substr($message, 0, $ivSize, '8bit');
        $ciphertext = mb_substr($message, $ivSize, null, '8bit');

        $plaintext = openssl_decrypt(
            $ciphertext,
            self::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        return $plaintext;
    }
}
