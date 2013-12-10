<?php

class GetInvolvedSubmission extends DataObject
{
	private static $db = array(
		'Name' => 'Varchar(255)',
		'Email' => 'Varchar(255)',
		'Telephone' => 'Varchar(255)'
	);
	
	private static $has_one = array(
		'GetInvolvedPage' => 'GetInvolvedPage'
	);
	
	private static $summary_fields = array(
		'Name' => 'Name',
		'Email' => 'Email',
		'Telephone' => 'Telephone',
		'Created.Nice' => 'Date'
	);
}
