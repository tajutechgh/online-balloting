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

class Candidate extends DataObject
{
  private static $db = [
    'Title' => 'Enum("Mr, Mrs, Miss","Mr")',
    'Name' => 'Varchar',
    'Deleted' => 'Boolean',
  ];

  private static $has_many = [
    'Votes' => Vote::class,
  ];

  private static $has_one = [
    'Photo' => Image::class,
    'Position' => Position::class,
  ];

  private static $owns = [
    'Photo',
  ];

  private static $extensions = [];

  private static $summary_fields = [
    'GridThumbnail' => 'Image',
    'Title' => 'Title',
    'Name' => 'Name',
  ];

  public function getGridThumbnail()
  {
    if ($this->Photo()->exists()) {
      return $this->Photo()->Fill(100,100);
    }

    return "(no image)";
  }

  public function getCMSFields()
  {
    $fields = parent::getCMSFields();

    $fields = FieldList::create(
      DropdownField::create('Gender', 'Gender', array(
        'Mr' => 'Mr',
        'Mrs' => 'Mrs',
        'Miss' => 'Miss'
      ))->setEmptyString('Select title'),
      TextField::create('Name','Name'),
      $uploader = UploadField::create('Photo', 'Image'),
    );

    $uploader->getValidator()->setAllowedExtensions(array(
      'png', 'jpeg', 'jpg', 'gif'
    ));

    $uploader->setFolderName('candidate-images');

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