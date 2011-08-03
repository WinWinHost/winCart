<?php 
class Form_PageForm extends Zend_Form 
{ 
    public function init() 
    { 
        $this->setAttrib('enctype', 'multipart/form-data'); 
        $this->setAttrib('id','pageForm');
        
        // create new element 
        $id = $this->createElement('hidden', 'id'); 
        // element options 
        $id->setDecorators(array('ViewHelper')); 
        // add the element to the form 
        $this->addElement($id); 
 
        // create new element 
        $name = $this->createElement('text', 'name'); 
        // element options 
        $name->setLabel('Page Name: '); 
        $name->setRequired(TRUE); 
        $name->setAttrib('size',40); 
        // add the element to the form 
        $this->addElement($name); 
 
        // create new element 
        $slug = $this->createElement('text', 'slug'); 
        // element options 
        $slug->setLabel('Page slug: '); 
        $slug->setRequired(TRUE); 
        $slug->setAttrib('size',40); 
        // add the element to the form 
        $this->addElement($slug); 
        
        // create new element 
        $meta_keywords = $this->createElement('text', 'meta_keywords'); 
        // element options 
        $meta_keywords->setLabel('Meta Keywods: '); 
        $meta_keywords->setRequired(TRUE); 
        $meta_keywords->setAttrib('size',40); 
        // add the element to the form 
        $this->addElement($meta_keywords); 
        
        // create new element 
        $meta_description = $this->createElement('textarea', 'meta_description'); 
        // element options 
        $meta_description->setLabel('Meta Description: '); 
        $meta_description->setRequired(TRUE); 
        $meta_description->setAttrib('cols',40); 
        $meta_description->setAttrib('rows',4); 
        // add the element to the form 
        $this->addElement($meta_description); 
        
        // create new element 
        $image = $this->createElement('file', 'image'); 
        // element options 
        $image->setLabel('Image: '); 
        $image->setRequired(FALSE); 
        // DON’T FORGET TO CREATE THIS FOLDER 
        $image->setDestination(APPLICATION_PATH . '/../public/images/upload'); 
        // ensure only 1 file 
        $image->addValidator('Count', false, 1); 
        // limit to 100K 
        $image->addValidator('Size', false, 102400); 
        // only JPEG, PNG, and GIFs 
        $image->addValidator('Extension', false, 'jpg,png,gif'); 
        // add the element to the form 
        $this->addElement($image); 
 
        // create new element 
        $description = $this->createElement('textarea', 'description'); 
        // element options 
        $description->setLabel('Description: '); 
        $description->setRequired(TRUE); 
        $description->setAttrib('cols',40); 
        $description->setAttrib('rows',4); 
        // add the element to the form 
        $this->addElement($description); 
 
        // create new element 
        $content = $this->createElement('textarea', 'content'); 
        // element options 
        $content->setLabel('Content'); 
        $content->setRequired(TRUE); 
        $content->setAttrib('cols',50); 
        $content->setAttrib('rows',12); 
        // add the element to the form 
        $this->addElement($content); 
 
        $submit = $this->addElement('submit', 'submit', array('label' => 'Submit')); 
    } 
} 
?>