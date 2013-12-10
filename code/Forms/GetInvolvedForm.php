<?php

class GetInvolvedForm extends ContactForm
{
	static $email_subject = "Website - Get Involved Submission";
	static $email_template = "GetInvolvedEmail";
	
	function getFormFields()
	{
		// Create the fields
	    $fields = new FieldList(
		    new TextField('Name', '* Name'),
			new EmailField('Email', '* Email'),
			new TextField('Telephone', '* Telephone'),
			new CheckboxField('ReadyToParty', '* I am ready to party!')
		);
		
		return $fields;
	}	

	function getValidator()
	{
	    // Create validator
	    $validator = new RequiredFields('Name', 'Email', 'Telephone', 'ReadyToParty');
		
		return $validator;		
	}
		
	function onAfterSubmission($data, $form)
	{
		//Create the new submission object and populate it
		$getInvolvedSubmission = new GetInvolvedSubmission();
		$form->saveInto($getInvolvedSubmission);		
		$getInvolvedSubmission->GetInvolvedPageID = $this->controller->ID;
		
		return $getInvolvedSubmission->write();
	}
}
