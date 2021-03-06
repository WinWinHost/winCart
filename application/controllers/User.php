<?php 
class Form_User extends Zend_Form 
{ 
    public function init() 
    { 
	

		
        $this->setMethod('post'); 
        $this->setAttrib('id','uForm');
 
        // create new element 
        $id = $this->createElement('hidden', 'id'); 
		
        // element options 
        $id->setDecorators(array('ViewHelper'));
		 
        // add the element to the form 
        $this->addElement($id); 
 
        //create the form elements 
        $username = $this->createElement('text','username'); 
        $username->setLabel('Username: '); 
        $username->setRequired('true'); 
        $username->addFilter('StripTags'); 
        $username->addErrorMessage('The username is required!'); 
		$username->class = "username";
		
        $this->addElement($username); 
		
		 $password = $this->createElement('password', 'password'); 
        $password->setLabel('Password: '); 
        $password->setRequired('true'); 
        $this->addElement($password); 
		$password->class = "password";
 
        $firstName = $this->createElement('text','first_name'); 
        $firstName->setLabel('First Name: '); 
        $firstName->setRequired('true'); 
        $firstName->addFilter('StripTags'); 
        $this->addElement($firstName);
		$firstName->class = "username";
 
        $lastName = $this->createElement('text','last_name'); 
        $lastName->setLabel('Last Name: '); 
        $lastName->setRequired('true'); 
        $lastName->addFilter('StripTags'); 
        $this->addElement($lastName); 
		$lastName->class = "username";
        
        $address = $this->createElement('text','address'); 
        $address->setLabel('Last Name: '); 
        $address->setRequired('true'); 
        $address->addFilter('StripTags'); 
        $this->addElement($address); 
		$address->class = "username";
        
        $address = $this->createElement('text','address'); 
        $address->setLabel('Address: '); 
        $address->setRequired('true'); 
        $address->addFilter('StripTags'); 
        $this->addElement($address); 
		$address->class = "username";

        $state = $this->createElement('text','state'); 
        $state->setLabel('State/Provice: '); 
        $state->setRequired('true'); 
        $state->addFilter('StripTags'); 
        $this->addElement($state); 
		$state->class = "username";
        
        $zip = $this->createElement('text','zip'); 
        $zip->setLabel('Zip: '); 
        $zip->setRequired('true'); 
        $zip->addFilter('StripTags'); 
        $this->addElement($zip); 
		$zip->class = "username";
        
        $city = $this->createElement('text','city'); 
        $city->setLabel('City: '); 
        $city->setRequired('true'); 
        $city->addFilter('StripTags'); 
        $this->addElement($city); 
		$city->class = "username";
 
/*        $role = $this->createElement('select', 'role');
		        $role->setLabel("Select a role:"); 
        $role->addMultiOption('User', 'user'); 
        $role->addMultiOption('Administrator', 'administrator'); 
        $this->addElement($role); */
 
         $role = $this->createElement('hidden', 'role');    
         $role->setValue("user");
		 $role->class = "buttons";
		 
         $this->addElement($role);
         $this->addElement('submit', 'submit', array('label' => 'Submit')); 

      
    } 
} 
?> 