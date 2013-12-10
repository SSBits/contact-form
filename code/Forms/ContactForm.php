<?php

/**
* 
*  Generic Extensible Contact Form
* 
*  Full Tutorial on SSbits.com
* 
*  @package contactform
* 
*/
class ContactForm extends Form 
{
	static $email_subject = "Website - General enquiry";
	static $email_template = "ContactEmail";
	
	protected $ajax_submit = true;
	
    function __construct($controller, $name) 
	{
		// Create the fields
	    $fields = $this->getFormFields();
	 	
	    // Create action
	    $actions = $this->getActions();
		
		// Set the Validator
		$validator = $this->getValidator();
		
        parent::__construct($controller, $name, $fields, $actions, $validator);
		
		//Include any Javascript
		if($this->hasMethod("getJS"))
		{
			$this->getJS();
		}
    }

	function getFormFields()
	{
		// Create the fields
	    $fields = new FieldList(
		    new TextField('Name', '* Name'),
			new EmailField('Email', '* Email'),
			new TextareaField('Comments','* Comments')
		);
		
		return $fields;		
	}

	function getActions()
	{
	    // Create action
	    $actions = new FieldList(
	    	new FormAction('SubmitForm', 'Send')
	    );
		
		return $actions;		
	}

	function getValidator()
	{
	    // Create validator
	    $validator = new RequiredFields('Name', 'Email', 'Comments');
		
		return $validator;		
	}
   
   	function getJS()
	{
		//Add your custom Javascript here
		if($this->ajax_submit)
		{
			//Construct the ID of the form
			$formName = $this->Name . "_" . get_class($this);			
			
			//For Ajax
			Requirements::javascript("framework/thirdparty/jquery/jquery.js");
			Requirements::javascript("framework/thirdparty/jquery-form/jquery.form.js");
			Requirements::customScript('
				
				//Support Form AJAX Submit
			    var options = {
			        success: showResponse // post-submit callback
			    }; 

				function showResponse()
				{
					jQuery("#' . $formName . '").fadeOut(function()
					{
						jQuery("#contactResponse").fadeIn();
					});
				}
				
			    jQuery("#' . $formName . '").ajaxForm(options); 	
			');					
		}
	}
	
	/**
	 * Submit function - to run on form submission
	 */	
	function SubmitForm($data, $form) {
		
		$to = $this->getToAddress();
		$from = $this->getFromAddress();

		//Create Email
	 	$email = new Email(
	 		$to, //From
	 		$from, //To
	 		$this->stat('email_subject') //Subject
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
		  	//return to submitted message
		  	if(Director::is_ajax())
			{
				return true;
			}
			else
			{
				return $this->success();
			}
		}
	}
	
	/**
	 * Get the "to" address for the email
	 */	
   	function getToAddress()
	{
		//Get the current contact page and return its value
	  	$controller = $this->controller;
		return $controller->SendFormsTo;
	}
	
	/**
	 * Get the "from" address for the email
	 */
   	function getFromAddress()
	{
		//Get the current contact page and return its value
	  	$controller = $this->controller;	
		return $controller->SendFormsFrom;		
	}
	
	/**
	 * Function to run on successfull submission
	 */
   	function Success()
	{
	  	//Get the contact page so we can redirect to it
	  	$currentPage = $this->controller;	
				
		//Redirect to the success page
		return $currentPage->redirect($currentPage->Link( "?success=1"));
	}
}