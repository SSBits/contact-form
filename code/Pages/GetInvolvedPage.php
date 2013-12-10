<?php

class GetInvolvedPage extends ContactPage
{
	private static $has_many = array(
		'GetInvolvedSubmissions' => 'GetInvolvedSubmission'
	);
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		//Content blocks
		$gridConfig = GridFieldConfig_RecordEditor::create();
		$gridConfig->removeComponentsByType('GridFieldAddNewButton');
		$gridField = new GridField(
			'GetInvolvedSubmissions', 
			'Submissions', 
			$this->GetInvolvedSubmissions(), 
			$gridConfig
		);
		$fields->addFieldToTab('Root.Submissions', $gridField);

		return $fields;
	}
}

class GetInvolvedPage_Controller extends ContactPage_Controller
{
	//Required to allow the form action to complete
	private static $allowed_actions = array(
		'Form'		
	);
		
	//Returns our custom ContactForm
	public function Form() {
	    return new GetInvolvedForm($this, 'Form');
	}
}