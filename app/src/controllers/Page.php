<?php

namespace {

use SilverStripe\Security\Security;

    use SilverStripe\View\ArrayData;
    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\View\Requirements;
    use SilverStripe\Forms\Form;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\TextField;
    use SilverStripe\Forms\EmailField;
    use SilverStripe\Forms\TextareaField;
    use SilverStripe\Forms\FormAction;
    use SilverStripe\Forms\RequiredFields;
    use SilverStripe\Control\Email\Email;
    use SilverStripe\Forms\CompositeField;

    class PageController extends ContentController
    {
        private static $allowed_actions = [];

        protected function init()
        {
            parent::init();

            $ThemeDir =  "app/assets/";
            // You can include any CSS or JS required by your project here.
            // css
            // Requirements::css('https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css');
            Requirements::css('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css');
            Requirements::css($ThemeDir . 'css/style.css');
            Requirements::css($ThemeDir . 'css/bootswatch.css');
            Requirements::css($ThemeDir . 'DataTables/datatables.min.css');
            // chart
            Requirements::css($ThemeDir . 'chart/styles/style.css');
            Requirements::css($ThemeDir . 'chart/styles/an-skill-bar.css');
            Requirements::css('https://www.jqueryscript.net/css/jquerysctipttop.css');

            // js
            Requirements::javascript('https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js');
            Requirements::javascript('https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js');
            Requirements::javascript($ThemeDir . 'DataTables/datatables.min.js');
            // chart
            Requirements::javascript($ThemeDir . 'chart/scripts/an-skill-bar.js');
            Requirements::javascript('https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js');
        }

        public function setSessionMessage($message, $type = 'success')
        {
            $session = $this->getRequest()->getSession();
            $session->set("Page.message", $message);
            $session->set("Page.messageType", $type);
        }

        public function SessionMessage()
        {

            $session = $this->getRequest()->getSession();

            $Message = $session->get('Page.message');
            $Type = $session->get('Page.messageType');

            $session->clear('Page.message');
            $session->clear('Page.messageType');

            if ($Message) {
                return new ArrayData(compact('Message', 'Type'));
            }

            return false;
        }

        public function isUserECOfficer()
        {
            $member = Security::getCurrentUser();

            return $member->inGroup('ec-officer');
        }

        public function isUserAdmin()
        {
            $member = Security::getCurrentUser();

            return $member->inGroup('administrators');
        }

        public function isUserPollingOfficer()
        {
            $member = Security::getCurrentUser();

            return $member->inGroup('polling-officer');
        }
    }
}
