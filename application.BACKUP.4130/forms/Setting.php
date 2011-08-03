<?php

class Form_Setting extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        
        $dbname = $this->createElement('text', 'dbname');
        $dbname->setLabel('Your Database Name');
        $dbname->setRequired(TRUE);
        $this->addElement($dbname);
        
        $username = $this->createElement('text', 'username');
        $username->setLabel('User Name');
        $username->setRequired(TRUE);
        $this->addElement($username);
        
        $password = $this->createElement('password', 'password');
        $password->setLabel('Password');
        $password->setRequired(TRUE);
        $this->addElement($password);
        
        $host = $this->createElement('text', 'host');
        $host->setLabel('Database Host');
        $host->setRequired(TRUE);
        $this->addElement($host);
        
        
                
        
        $submit = $this->addElement('submit', 'submit', array('label' => 'Submit')); 
        
    }
}
?>
