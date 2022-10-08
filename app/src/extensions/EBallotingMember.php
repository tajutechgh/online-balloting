<?php

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\DropdownField;
use SilverStripe\AssetAdmin\Forms\UploadField;

class EBallotingMemberExtension extends DataExtension {
	private static $db = [
		'Prefix' => 'Enum("Mr, Mrs, Miss","Mr")',
		'PhoneNumber' => 'Varchar',
		'ResidentialAddress' => 'Varchar',
		'GPSAddress' => 'Varchar',
		'MemberType' => 'Varchar',
		'Deleted' => 'Boolean',
	];

	private static $has_many = [
		'VerificationCodes' => VerificationCode::class,
	];

	private static $has_one = [
		'Photo' => Image::class,
	];

	private static $owns = [
	  'Photo',
	];
}
