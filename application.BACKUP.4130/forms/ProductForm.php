<?php 
class Form_ProductForm extends Zend_Form 
{ 
    public function init() 
    { 
        $this->setAttrib('enctype', 'multipart/form-data'); 
        $this->setAttrib('id', 'productForm'); 
 
        // create new element 
        $id = $this->createElement('hidden', 'id'); 
        // element options 
        $id->setDecorators(array('ViewHelper')); 
        // add the element to the form 
        $this->addElement($id); 
 
        // create new element 
        $name = $this->createElement('text', 'name'); 
        // element options 
        $name->setLabel('Product Name: '); 
        $name->setRequired(TRUE); 
        $name->setAttrib('size',40); 
        // add the element to the form 
        $this->addElement($name); 
        
        // create new element 
        $name = $this->createElement('text', 'slug'); 
        // element options 
        $name->setLabel('Product Slug: '); 
        $name->setRequired(TRUE); 
        $name->setAttrib('size',40); 
        // add the element to the form 
        $this->addElement($name); 
 
        // create new element 
        $price = $this->createElement('text', 'price'); 
        // element options 
        $price->setLabel('Product Price: '); 
        $price->setRequired(TRUE); 
        $price->setAttrib('size',5); 
		
		// add the element to the form 
        $this->addElement($price); 
		
		// create new element 
        $cost = $this->createElement('text', 'cost'); 
        // element options 
        $cost->setLabel('Product Cost: '); 
        $cost->setRequired(TRUE); 
        $cost->setAttrib('size',5); 
		
		// add the element to the form 
        $this->addElement($cost); 
		
				// create new element 
        $stock = $this->createElement('text', 'stock'); 
        // element options 
        $stock->setLabel('Product Stock: '); 
        $stock->setRequired(TRUE); 
        $stock->setAttrib('size',5); 
		
		// add the element to the form 
        $this->addElement($stock); 
 
        // create new element 
        $image = $this->createElement('file', 'image'); 
        // element options 
        $image->setLabel('Thump: '); 
        $image->setRequired(False); 
        // DON’T FORGET TO CREATE THIS FOLDER 
        $image->setDestination( getcwd() . '/images/products'); 
        // ensure only 1 file 
        $image->addValidator('Count', false, 1); 
        // limit to 100K 
        $image->addValidator('Size', false, 102400); 
        // only JPEG, PNG, and GIFs 
        $image->addValidator('Extension', false, 'jpg,png,gif'); 
        // add the element to the form 
        $this->addElement($image); 
 
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
        
                // create new element 
        $description = $this->createElement('textarea', 'content'); 
        // element options 
        $description->setLabel('Content'); 
        $description->setRequired(TRUE); 
        $description->setAttrib('cols',75); 
        $description->setAttrib('rows',10); 
        // add the element to the form 
        $this->addElement($description); 
 
        $submit = $this->addElement('submit', 'submit', array('label' => 'Submit')); 
    } 
} 
?>