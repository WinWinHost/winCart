<?php

class UserController extends Zend_Controller_Action
{
    public $countries;
    public $locale;
    public $auth;
    public $user;
    
    public function init()
    {
        /* Initialize action controller here */
        
         $this->locale = new Zend_Locale('en_US');
        
        $this->countries = ($this->locale->getTranslationList('Territory', 'en', 2));
        asort( $this->countries, SORT_LOCALE_STRING);

        $this->auth = Zend_Auth::getInstance(); 
        if($this->auth->hasIdentity()) { 
            $this->user=$this->auth->getIdentity();
        }
    }

    public function indexAction()
    {                                         
      $this->view->identity = $this->user   ; 
    }
    
    public function createAction()
    {
        $userForm = new Form_User(); 
       
         if ($this->_request->isPost()) { 
               if ($userForm->isValid($_POST)) { 

                   $userModel = new Model_User();
                 
                   $userModel->createUser( 
                   $userForm->getValue('username'), 
                   $userForm->getValue('password'), 
                   $userForm->getValue('first_name'), 
                   $userForm->getValue('last_name'), 
                   $userForm->getValue('role'), 
                   $userForm->getValue('address'), 
                   $userForm->getValue('state'), 
                   $userForm->getValue('zip'), 
                   $userForm->getValue('city'),
                   $this->_request->getPost('country')
                   ); 
                   
                   return $this->_redirect('index');       
                } 

         }     
         
         $userForm->setAction('/user/create'); 
         
         $country=$userForm->createElement("select","country");
		 $country->class = "username";
         $country->setLabel("Country:"); 
         foreach ($this->countries as $key => $value) 
         {            
              $country->addMultiOption($key, $value);           
         }
         $country->setValue("US");
         $country->setOrder(5);
         $userForm->addElement($country);
         
        
         
         $this->view->form = $userForm;
    }

    public function listAction()
    {
        $currentUsers = Model_User::getUsers(); 
                                    if ($currentUsers->count() > 0) { 
                                        $this->view->users = $currentUsers; 
                                    } else { 
                                        $this->view->users = null;
    }
}
    public function updateAction()
    {      
        $userForm = new Form_User(); 
                            $userForm->setAction('/user/update'); 
                            $userForm->removeElement('password'); 
                            $userModel = new Model_User(); 
                            if ($this->_request->isPost()) { 
                        	        if ($userForm->isValid($_POST)) { 
                                    $userModel->updateUser( 
                                        $userForm->getValue('id'), 
                                        $userForm->getValue('username'), 
                                        $userForm->getValue('first_name'), 
                                        $userForm->getValue('last_name'), 
                                        $userForm->getValue('role'),
                                        $userForm->getValue('address'), 
                                        $userForm->getValue('state'), 
                                        $userForm->getValue('zip'), 
                                        $userForm->getValue('city'),
                                        $this->_request->getPost('country') 
                                    ); 
                                    return $this->_forward('list');         } 
                            } 
                                
                            if($this->_request->getParam('id') )
                              $id = $this->_request->getParam('id');
                            else $id= $this->user->id;
                            if($this->user->role=='administrator'||$this->user->id==$id){

                                $currentUser = $userModel->find($id)->current(); 

                                $userForm->populate($currentUser->toArray()); 
                              
                                    
                                 $country=$userForm->createElement("select","country");

                                 $country->setLabel("Country:"); 
         
                                 foreach ($this->countries as $key => $value) 

                                 {            

                                     $country->addMultiOption($key, $value);           

                                 }

                                 $country->setValue($currentUser->country);
                                 $country->setOrder(5);
                                 $userForm->addElement($country);
         

                                
                                $this->view->form = $userForm;
                             }else{
                                 $this->view->error=true;
                             }
    }

    public function passwordAction()
    {
        $passwordForm = new Form_User(); 
                    $passwordForm->setAction('/user/password'); 
                    $passwordForm->removeElement('first_name'); 
                    $passwordForm->removeElement('last_name'); 
                    $passwordForm->removeElement('username'); 
                    $passwordForm->removeElement('role'); 
                    $passwordForm->removeElement('address'); 
                    $passwordForm->removeElement('state'); 
                    $passwordForm->removeElement('city'); 
                    $passwordForm->removeElement('zip'); 
                    $userModel = new Model_User(); 
                    if ($this->_request->isPost()) { 
                        if ($passwordForm->isValid($_POST)) { 
                            $userModel->updatePassword( 
                                $passwordForm->getValue('id'), 
                                $passwordForm->getValue('password') 
                            ); 
                            return $this->_forward('list'); 
                        } 
                    }
                    
                    
                             if($this->_request->getParam('id') )
                              $id = $this->_request->getParam('id');
                            else $id= $this->user->id;

                        if($this->user->role=='administrator'||$this->user->id==$id){

                            $currentUser = $userModel->find($id)->current(); 
                            $passwordForm->populate($currentUser->toArray());                          
                            $this->view->form = $passwordForm;                             
                        }else{
                            $this->view->error=true;
                        }
                	
                    
                   
    }

    public function deleteAction()
    {
        $id = $this->_request->getParam('id'); 
                    $userModel = new Model_User(); 
                    $userModel->deleteUser($id); 
                    return $this->_forward('list');
    }

    public function loginAction()
    {
        $userForm = new Form_User(); 
        $userForm->setAction('/user/login'); 
        $userForm->removeElement('first_name'); 
        $userForm->removeElement('last_name'); 
        $userForm->removeElement('role'); 
        $userForm->removeElement('address'); 
        $userForm->removeElement('state'); 
        $userForm->removeElement('zip'); 
        $userForm->removeElement('city');            
        
        $submit = $userForm->addElement('submit', 'submit', array('label' => 'Submit')); 

        if ($this->_request->isPost() && $userForm->isValid($_POST)) { 

            $data = $userForm->getValues(); 

            //set up the auth adapter 
            // get the default db adapter 

            $db = Zend_Db_Table::getDefaultAdapter(); 

            //create the auth adapter 
            $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users', 
            'username', 'password'); 

            //set the username and password 
            $authAdapter->setIdentity($data['username']); 

            $authAdapter->setCredential(md5($data['password'])); 

            //authenticate 
            $result = $authAdapter->authenticate(); 

            if ($result->isValid()) { 

                // store the username, first and last names of the user 
               

                $storage = $this->auth->getStorage(); 
                $storage->write($authAdapter->getResultRowObject( 

                array('id','username' , 'first_name' , 'last_name', 'role','address','state' ,'city','zip','country'))); 

                return $this->_forward('index');        } else { 

                    $this->view->loginMessage = "Sorry, your username or 

                    password was incorrect"; 
                
                } 

        } 

        $this->view->form = $userForm;
    }

    public function logoutAction () 
    { 
        $authAdapter = Zend_Auth::getInstance(); 
        $authAdapter->clearIdentity(); 
    } 
 
   public function ordersAction(){
       
       $orderModel=New Model_Orders(); //object to the order tables
       $select=$orderModel->select();
        $select->order('insert_date DESC');
       $select->where('userID=?',$this->user->id);
       $orders=$orderModel->fetchAll($select);
       
       
       $this->view->orders=$orders;
   }
   
    public function orderdetailsAction(){
        
        $id = $this->_request->getParam('id'); 
        $orderModel = New Model_Orders();
        $order=$orderModel->find($id)->current();
        $this->view->order=$order; 
        
    }

}


?>










