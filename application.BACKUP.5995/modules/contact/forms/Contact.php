<?phpclass Contact_Form_Contact extends Zend_Form {     public function init()     {         // create new element         $name = $this->createElement('text', 'name');         // element options         $name->setLabel('Enter your name:');         $name->setRequired(TRUE);         $name->setAttrib('size',40);         // add the element to the form         $this->addElement($name);          // create new element         $email = $this->createElement('text', 'email');         // element options         $email->setLabel('Enter your email address:');         $email->setRequired(TRUE);         $email->setAttrib('size',40);         $email->addValidator('EmailAddress');         $email->addErrorMessage('Invalid email address!');        // add the element to the form         $this->addElement($email);          // create new element         $subject = $this->createElement('text', 'subject');        // element options         $subject->setLabel('Subject: ');         $subject->setRequired(TRUE);         $subject->setAttrib('size',60);         // add the element to the form 				        $this->addElement($subject);          // create new element         $message = $this->createElement('textarea', 'message');         // element options         $message->setLabel('Message:');         $message->setRequired(TRUE);         $message->setAttrib('cols',50);         $message->setAttrib('rows',12);         // add the element to the form         $this->addElement($message);          $submit = $this->addElement('submit', 'submit',             array('label' => 'Send Message'));     } }  