<?php

/**
* 
*  Generic Contact Form
* 
*  Full Tutorial on SSbits.com
* 
*  @package contactform
* 
*/

class ContactForm extends Form 
{
    function __construct($controller, $name) 
	{
		// Create the fields
	    $fields = new FieldList(
		    new TextField('Name', '* Name'),
			new EmailField('Email', '* Email'),
			new TextareaField('Comments','* Comments')
		);
	 	
	    // Create action
	    $actions = new FieldList(
	    	new FormAction('SubmitForm', 'Send')
	    );
		
		// Set the Validator
		$validator = new RequiredFields('Name', 'Email', 'Comments');

		//Include any Javascript
		$this->getJS();

        parent::__construct($controller, $name, $fields, $actions, $validator);
    }
   
   	function getJS()
	{
		//Add your custom Javascript here
		Requirements::customScript('
			jQuery(document).ready(function(){

			});
		');	
	}

	function SubmitForm($data, $form) {
      
	  	//Get the current contact page so we can access its field values
	  	$contactPage = $this->controller;

		//Create Email
	 	$email = new Email(
	 		$contactPage->SendFormsFrom, //From
	 		$contactPage->SendFormsTo, //To
	 		"Website Contact Submission" //Subject
		);
		
		//Set the reply-to to the sender so receiver can hit 'reply'
		$email->replyTo($data['Email']);

		//set template
		$email->setTemplate($this->stat('email_template'));
		//populate template
		$email->populateTemplate($data);

		//send mail
		if($email->send())
		{
			//Redirect to the success page
			return $contactPage->redirect($contactPage->Link( "?success=1"));
		}
	}
}