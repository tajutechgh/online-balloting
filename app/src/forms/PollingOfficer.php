<?php

use SilverStripe\Forms\Form;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Security\Member;
use SilverStripe\Control\Director;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\LabelField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Security\Security;
use SilverStripe\View\Requirements;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Control\Email\Email;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\ConfirmedPasswordField;
use UncleCheese\Dropzone\FileAttachmentField;

class PollingOfficerForm extends Form
{
    public function __construct($controller, $name, $pollingOfficerDetails = null)
    {
        $fields = new FieldList(
            CompositeField::create(
                CompositeField::create(

                    $fields = new FieldList(
                        CompositeField::create(
                            CompositeField::create(
                                CompositeField::create(
                                    HiddenField::create('ID'),
                                    CompositeField::create(
                                        DropdownField::create('Prefix', 'Title *', array(
                                            'Mr' => 'Mr',
                                            'Mrs' => 'Mrs',
                                            'Miss' => 'Miss'
                                        ))->setEmptyString('Select title')->addExtraClass('po'),
                                        TextField::create('FirstName', "First Name *")->addExtraClass('po'),
                                        TextField::create('Surname', "Surname *")->addExtraClass('po'),
                                    )->addExtraClass('col-md-6'),
                                    CompositeField::create(
                                        TextField::create('PhoneNumber', "Phone Number *")->addExtraClass('po'),
                                        TextField::create('ResidentialAddress', "Residential Address *")->addExtraClass('po'),
                                        TextField::create('GPSAddress', "GPS Address *")->addExtraClass('po'),
                                        HiddenField::create('MemberType', "Member Type", "Polling Officer")->addExtraClass('po'),
                                    )->addExtraClass('col-md-6'),
                                )->addExtraClass('row')
                            )->addExtraClass('col-md-12'),

                            CompositeField::create(
                                $upload = FileAttachmentField::create('Photo', "Upload the photo *")->addExtraClass('po')
                            )->addExtraClass('col-md-12'),
            
                            CompositeField::create(
                                EmailField::create("Email", "Email Address *")->addExtraClass('po'),
                                ConfirmedPasswordField::create("Password", "Password *")->setCanBeEmpty(true)->addExtraClass('po')
                            )->addExtraClass('col-md-12'),
                        )->addExtraClass('row'),
                    )
                
                )->addExtraClass('col-md-8'),

                CompositeField::create(
                    $actions = FieldList::create(
                        FormAction::create('doRegisterAndStay', 'Submit And Remain On This Page')->setUseButtonTag(true)->addExtraClass('btn btn-success'),
                        FormAction::create('doRegisterAndGoBack', 'Submit And Go Back')->setUseButtonTag(true)->addExtraClass('btn btn-success'),
                    )
                )->addExtraClass('col-md-4')
            )->addExtraClass('row')
        );

        $upload->setFolderName("polling-officer-images");
        $upload->imagesOnly();
        $upload->setView('grid');
        $upload->setMaxFilesize(10);
        $upload->setMultiple(false);

        $validator = new RequiredFields('FirstName', 'Surname', 'PhoneNumber', 'Email', 'GPSAddress', 'Title', 'ResidentialAddress');

        $this->setAttribute("data-persist", "garlic");

        parent::__construct($controller, $name, $fields, $actions, $validator);

        if ($pollingOfficerDetails) {
            $this->loadDataFrom($pollingOfficerDetails);
        }
    }

    public function doRegisterAndStay(array $data, Form $form)
    {
        if (isset($data['ID']) && !empty($data['ID'])) {

            $member = Member::get()->byID($data['ID']);

		} else {

            if (!empty($data['Email'])) {

                $member = Member::get()->filter("Email", $data['Email'])->first();
    
                if ($member) {

                    $form->sessionMessage("Sorry, that email address is already in use.", 'error');

                    return $this->controller->redirectBack();
                }
            }

			$member = new Member();
		}
        
        $form->saveInto($member);
        $member->write();
        $member->addToGroupByCode("Polling Officer");

        $this->controller->setSessionMessage("Polling officer added successfully.");

        return $this->controller->redirectBack();
    }

    public function doRegisterAndGoBack(array $data, Form $form)
    {
        if (isset($data['ID']) && !empty($data['ID'])) {

            $member = Member::get()->byID($data['ID']);

		} else {

            if (!empty($data['Email'])) {

                $member = Member::get()->filter("Email", $data['Email'])->first();
    
                if ($member) {

                    $form->sessionMessage("Sorry, that email address is already in use.", 'error');

                    return $this->controller->redirectBack();
                }
            }

			$member = new Member();
		}

        $form->saveInto($member);
        $member->write();
        $member->addToGroupByCode("Polling Officer");

        $this->controller->setSessionMessage("Polling officer added successfully.");

        return $this->controller->redirect('/dashboard/polling-officer');
    }
}
