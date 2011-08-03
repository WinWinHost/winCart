<?php 
class Form_Category extends Zend_Form 
{ 
    public function init() 
    { 
        
        $this->setAttrib('id', 'catForm'); 
        
	    // create new element 
        $id = $this->createElement('hidden', 'id'); 
		// element options 
        $id->setDecorators(array('ViewHelper')); 
        // add the element to the form 
        $this->addElement($id); 
		
		// create new element 
        $name = $this->createElement('text', 'name'); 
        // element options 
        $name->setLabel('Category Name: '); 
        $name->setRequired(TRUE); 
        $name->setAttrib('size',40); 
        // add the element to the form 
        $this->addElement($name); 
        
        // create new element 
        $name = $this->createElement('text', 'slug'); 
        // element options 
        $name->setLabel('Slug: '); 
        $name->setRequired(TRUE); 
        $name->setAttrib('size',40); 
        // add the element to the form 
        $this->addElement($name); 
        
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
        
   
		$submit = $this->addElement('submit', 'submit', array('label' => 'Submit')); 
	
	}
}
?>