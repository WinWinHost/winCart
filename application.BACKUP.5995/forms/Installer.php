<?php
class Form_Installer extends Zend_Form 
{ 
    public function init() 
    { 
        
        
        $title=$this->createElement('text','title');
        $title->setLabel('Site Title: '); 
        $title->setRequired(TRUE); 
        $title->setAttrib('size',50); 
        
        $this->addElement($title);
        

        
        $keywords=$this->createElement('text','meta_keywords');
        $keywords->setLabel('Site Meta Keywords: '); 
        $keywords->setRequired(TRUE); 
        $keywords->setAttrib('size',100); 
        
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
        
        
 
        
        $admin=$this->createElement('text','admin_user');
        $admin->setLabel('Admin User: '); 
        $admin->setRequired(TRUE); 
        $admin->setAttrib('size',50); 
  
        $this->addElement($admin);
        
        $admin_pass=$this->createElement('password','admin_pass');
        $admin_pass->setLabel('Admin password: '); 
        $admin_pass->setRequired(TRUE); 
        $admin_pass->setAttrib('size',50); 
        
        $this->addElement($admin_pass);
        
        $email=$this->createElement('text','email');
        $email->setLabel('Admin email: '); 
        $email->setRequired(TRUE); 
        $email->setAttrib('size',50); 
        
        
        $this->addElement($email);
        
        $submit = $this->addElement('submit', 'submit', array('label' => 'Submit')); 
        
    }
}