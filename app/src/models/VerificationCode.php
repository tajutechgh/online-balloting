<?php

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Security\Member;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Versioned\Versioned;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\GridField\GridFieldViewButton;

class VerificationCode extends DataObject
{
  private static $db = [
    'Code' => 'Varchar',
    'Verified' => 'Boolean',
  ];

  private static $has_many = [
    'Votes' => Vote::class,
  ];

  private static $has_one = [
    'PollingOfficer' => Member::class,
  ];

  private static $owns = [];

  private static $extensions = [];

  private static $summary_fields = [
    'Code' => 'Code',
  ];

  public function getCMSFields()
  {
    $fields = parent::getCMSFields();

    $fields = FieldList::create(
      TextField::create('Code','Code'),
    );

    return $fields;
  }

  public function canView($member = true, $context = [])
  {
    return true;
  }

  public function canCreate($member = true, $context = [])
  {
    return false;
  }

  public function canEdit($member = true, $context = [])
  {
    return false;
  }

  public function canDelete($member = true, $context = [])
  {
    return false;
  }
}