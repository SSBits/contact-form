<?php
/**
* 
*  Generic Contact Page
* 
*  Full Tutorial on SSbits.com
* 
*  @package contactform
* 
*/

class ContactPage extends Page
{
	private static $description = 'A page with a simple configurable Contact Form';	
	
	private static $db = array(
		'SendEmailsFrom' => 'Varchar(255)',
		'SendFormSubmissionsTo' => 'Varchar(255)',
		'OnSubmissionContent' => 'HTMLText'
	);
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->addFieldToTab('Root.OnSubmission', new TextField('SendEmailsFrom', "Send emails from this address e.g. 'noreply@mysite.com'"));			
		$fields->addFieldToTab('Root.OnSubmission', new TextField('SendFormSubmissionsTo', "Send form submissions to these addresses (comma separated)"));			
		$fields->addFieldToTab('Root.OnSubmission', new HTMLEditorField('OnSubmissionContent', "Content to show after successfull submission"));			

		return $fields;
	}	
}

class ContactPage_Controller extends Page_Controller
{
	//Required to allow the form action to complete
	private static $allowed_actions = array(
		'Form'		
	);
	
	//Returns our custom ContactForm
	public function Form() {
	    return new ContactForm($this, 'Form');
	}

	//Allows us to test if the form has been submitted successfully
	public function Success(){
		return $this->request->getVar('success');
	}
}