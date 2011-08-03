<?php 
class Form_MenuItem extends Zend_Form 
{ 
    public function init() 
    { 
        $this->setMethod('post'); 
        $this->setAttrib('id','menuitemForm');
        // create new element 
        $id = $this->createElement('hidden', 'id'); 
        // element options 
        $id->setDecorators(array('ViewHelper')); 
        // add the element to the form 
        $this->addElement($id); 
 
        // create new element 
        $menuId = $this->createElement('hidden', 'menu_id'); 
        // element options 
        $menuId->setDecorators(array('ViewHelper')); 
        // add the element to the form 
        $this->addElement($menuId); 
		
		// create new element 
		$label = $this->createElement('text', 'label'); 
		// element options 
		$label->setLabel('Label: '); 
		$label->setRequired(TRUE); 
		$label->addFilter('StripTags'); 
		$label->setAttrib('size',40); 
		// add the element to the form 
		$this->addElement($label);         
		
				
		// create new element 
        $page_type= $this->createElement('select', 'link_type'); 
        // element options 
        $page_type->setLabel('Select link type: '); 
        $page_type->setRequired(true); 
		
        $page_type->addMultiOption("link", "Link"); 
        $page_type->addMultiOption("category", "Category");
        $page_type->addMultiOption("page", "Page");
        
        $this->addElement($page_type); 
        // create new element 
        $page_cat= $this->createElement('select', 'page_cat'); 
        // element options 
        $page_cat->setLabel('Select category: '); 
        $page_cat->setRequired(true); 
        // populate this with the pages 
        $catModel = new Model_Category(); 
        $categories = $catModel->fetchAll(null, 'name'); 
        $page_cat->addMultiOption(0, 'None'); 
        if($categories->count() > 0) { 
            foreach ($categories as $cat) { 
                $page_cat->addMultiOption($cat->id, $cat->name); 
            } 
        } 
        // add the element to the form 
        $this->addElement($page_cat); 
		
		// create new element 
        $pageId = $this->createElement('select', 'page_id'); 
        // element options 
        $pageId->setLabel('Select a page to link to: '); 
        $pageId->setRequired(true); 
 
        // populate this with the pages 
        $mdlPage = new Model_Page(); 
        $pages = $mdlPage->fetchAll(null, 'name'); 
        $pageId->addMultiOption(0, 'None'); 
        if($pages->count() > 0) { 
            foreach ($pages as $page) { 
                $pageId->addMultiOption($page->id, $page->name); 
            } 
        } 
        // add the element to the form 
        $this->addElement($pageId); 
 
        // create new element 
        $link = $this->createElement('text', 'link'); 
        // element options 
        $link->setLabel('or specify a link: '); 
        $link->setRequired(false); 
        $link->setAttrib('size',50); 
        // add the element to the form 
        $this->addElement($link); 
 
        $submit = $this->addElement('submit', 'submit', array('label' => 'Submit')); 
    } 
} 
?> 