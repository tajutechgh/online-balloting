<?php 

use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Security\Authenticator;
use SilverStripe\Security\IdentityStore;

class AuthController extends PageController 
{
    private static $allowed_actions = [
        "login",
        "logout",
    ];

    public function Link($action = null)
    {
        return  "/auth/$action";
    }

    public function index(HTTPRequest $request) 
    {
        return $this->Customise([
            'Title' => 'Login Your Account',
        ])->renderWith(["Login", "Page"]);
    }

    public function login(HTTPRequest $request)
    {
        $email = $request->postVar('Email');

        $password = $request->postVar('Password');
       
        $member = Member::get()->filter(['Email' => $email])->first();

        if(!$member){

            $this->setSessionMessage("Sorry, the email address is invalid.", 'error');

            return $this->redirectBack();

        }else{

            $result = ValidationResult::create();

            $authenticators = Security::singleton()->getApplicableAuthenticators(Authenticator::CHECK_PASSWORD);

            foreach ($authenticators as $authenticator) {

                $authenticator->checkPassword($member, $password, $result);

                if (!$result->isValid()){  

                    $this->setSessionMessage("Sorry, the password is invalid.", 'error');

                    return $this->redirectBack();

                    break;
                }
            }
        }

        if ($result->isValid()) {

            $identityStore = Injector::inst()->get(IdentityStore::class);

            $identityStore->logIn($member, $request->postVar('remember-me') ? true : false, $request);
        }

        return $this->redirect('/dashboard');
    }

    public function logout(HTTPRequest $request)
    {
        Injector::inst()->get(IdentityStore::class)->logOut($request);

        return $this->redirect('/auth');
    }
}