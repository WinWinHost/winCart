<?php

class Form_Options extends Zend_Form 
{ 
    public function init() 
    { 

		
		// create new element 
        $title = $this->createElement('text', 'title'); 
        // element options 
        $title->setLabel('WebSite Title: '); 
        $title->setRequired(TRUE); 
        $title->setAttrib('size',40); 
        // add the element to the form 
        $this->addElement($title);  
        
        		// create new element 
        $email = $this->createElement('text', 'email'); 
        // element options 
        $email->setLabel('Contact Email: '); 
        $email->setRequired(TRUE); 
        $email->setAttrib('size',40); 
        // add the element to the form 
        $this->addElement($email);  
        
                    // create new element 
        $keywords = $this->createElement('text', 'meta_keywords'); 
        // element options 
        $keywords->setLabel('Meta Keywords: '); 
        $keywords->setRequired(TRUE); 
        // add the element to the form 
        $this->addElement($keywords); 
        
                // create new element 
        $description = $this->createElement('textarea', 'meta_description'); 
        // element options 
        $description->setLabel('Meta Description'); 
        $description->setRequired(TRUE); 
        $description->setAttrib('cols',50); 
        $description->setAttrib('rows',5); 
        // add the element to the form 
        $this->addElement($description); 
        
        $submit = $this->addElement('submit', 'submit', array('label' => 'Set')); 
    }

}


?>