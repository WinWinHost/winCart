<?php 
class Contact_IndexController extends Zend_Controller_Action 
{ 
public function indexAction() 
{ 
    $frmContact = new Contact_Form_Contact(); 
    if($this->_request->isPost() && $frmContact->isValid($_POST)) { 
        //send the message 
    } 
    $frmContact->setAction('/contact'); 
    $frmContact->setMethod('post'); 
    $this->view->form = $frmContact; 
} 
} 
 