<?php 

use SilverStripe\Control\HTTPRequest;

class HomePageController extends PageController 
{
    private static $allowed_actions = [
        'verify_code',
    ]; 

    public function verify_code(HTTPRequest $request)
    {
        $session = $request->getSession();

        $code = $request->postVar('VerificationCode');

        $vCode = VerificationCode::get()->filter(['Code' => $code])->first();

        if($vCode){

            $vCode->Verified = 1;

            $vCode->write();

            $session->set('verification.code', serialize($vCode));

            return $this->redirect('/position');
        }else{

            $this->setSessionMessage("Code entered is not valid, please kindly contact the polling officer who attended to you.", 'good');

            return $this->redirectBack();
        }
    }
}