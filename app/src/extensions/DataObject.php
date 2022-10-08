<?php

use SilverStripe\ORM\DataExtension;

class GICDataObjectExtension extends DataExtension
{

    /**
     *
     * Encode DataObject ID for URL usage
     *
     **/
    public function EncodedID()
    {
        return Crypto::encode($this->owner->ID);
    }
}
