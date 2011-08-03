<?php
class Form_AddToCart extends Zend_Form 
{ 
    public function init() 
    {

	    // create new element 
        $id = $this->createElement('hidden', 'id'); 
        // element options 
        $id->setDecorators(array('ViewHelper')); 
        // add the element to the form 
        $this->addElement($id); 
	
	    $submit = $this->addElement('submit', 'submit', array('label' => 'Submit')); 
	}
}
?>	