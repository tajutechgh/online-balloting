<?php

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Versioned\Versioned;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\GridField\GridFieldViewButton;
use SilverStripe\Forms\HTMLEditor\HtmlEditorField;

class Position extends DataObject
{
  private static $db = [
    'Title' => 'Varchar',
    'Deleted' => 'Boolean',
  ];

  private static $has_many = [
    'Candidates' => Candidate::class,
    'Votes' => Vote::class,
  ];

  private static $owns = [];

  private static $extensions = [];

  private static $summary_fields = [
    'Title' => 'Title',
  ];

  public function getCMSFields()
  {
    $fields = parent::getCMSFields();

    $fields = FieldList::create(
      TextField::create('Title','Title'),
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