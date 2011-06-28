<?php 
class CMS_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract 
{ 



	public function preDispatch(Zend_Controller_Request_Abstract $request) 
	{
	// set up acl 
$acl = new Zend_Acl(); 
// add the roles 
$acl->addRole(new Zend_Acl_Role('guest')); 
$acl->addRole(new Zend_Acl_Role('user'), 'guest'); 
$acl->addRole(new Zend_Acl_Role('administrator'), 'user'); 
//$acl->allow('guest', 'search', array('index', 'search')); 
 
// add the resources 
$acl->add(new Zend_Acl_Resource('index')); 
$acl->add(new Zend_Acl_Resource('error')); 
$acl->add(new Zend_Acl_Resource('page')); 
$acl->add(new Zend_Acl_Resource('pageadmin')); 
$acl->add(new Zend_Acl_Resource('menu')); 
$acl->add(new Zend_Acl_Resource('menuitem')); 
$acl->add(new Zend_Acl_Resource('user')); 
$acl->add(new Zend_Acl_Resource('search')); 
$acl->add(new Zend_Acl_Resource('feed')); 
$acl->add(new Zend_Acl_Resource('products')); 
$acl->add(new Zend_Acl_Resource('productsedit')); 
$acl->add(new Zend_Acl_Resource('cart')); 
$acl->add(new Zend_Acl_Resource('checkout')); 
$acl->add(new Zend_Acl_Resource('ordersadmin'));  
$acl->add(new Zend_Acl_Resource('options')); 
$acl->add(new Zend_Acl_Resource('install')); 
 // set up the access rules 
$acl->allow(null, array('index', 'error','products')); 


 
// a guest can only read content and login 
$acl->allow('guest', 'page', array('index', 'open')); 
$acl->allow('guest', 'menu', array('render')); 
$acl->allow('guest', 'user', array('login','create')); 
$acl->allow('guest', 'feed'); 
$acl->allow('guest', 'install'); 
$acl->allow('guest', 'cart',array('index','delete','add','update')); 


// cms users can also work with content 
$acl->allow('user', 'page', array('list', 'create', 'edit', 'delete')); 
$acl->allow('user', 'user', array('login','create','logout','update','password','orders','orderdetails')); 
$acl->allow('user', 'cart', array('details','index','transaction','delete')); 
 
// administrators can do anything 
$acl->allow('administrator', null); 
 
	// fetch the current user 
$auth = Zend_Auth::getInstance(); 
if($auth->hasIdentity()) { 
    $identity = $auth->getIdentity(); 
    $role = strtolower($identity->role); 
}else{ 
    $role = 'guest'; 
} 
 
$controller = $request->controller; 
$action = $request->action; 
 
if (!$acl->isAllowed($role, $controller, $action)) {
    if ($role == 'guest') { 
        $request->setControllerName('user'); 
        $request->setActionName('login'); 
    } else { 
       $request->setControllerName('error'); 
       $request->setActionName('noauth'); 
   } 
} 
 
	}	 

}

?>