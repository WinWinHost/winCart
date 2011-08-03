<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

protected function _initView() 
{ 
	   
    
    // Initialize view of BootStrap file 
    $view = new Zend_View(); 
    $view->doctype('XHTML1_STRICT'); 
   
    
 
    // Add it to the ViewRenderer 
    $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper( 
        'ViewRenderer' 
    ); 
    $viewRenderer->setView($view); 
 
   $front  = Zend_Controller_Front::getInstance();
    $router = $front->getRouter();
    $router->addRoute('products',
      new Zend_Controller_Router_Route('products/:slug', array(
        'controller' => 'products',
        'action'     => 'details'
      ))
    );
       $router->addRoute('page',
      new Zend_Controller_Router_Route('page/:slug', array(
        'controller' => 'page',
        'action'     => 'open'
      ))
    );
    
    return $view; 
   
} 

protected function _initAutoload() 
{ 
    // Add autoloader empty namespace 
    $autoLoader = Zend_Loader_Autoloader::getInstance(); 
    $autoLoader->registerNamespace('CMS_'); 
    $resourceLoader = new Zend_Loader_Autoloader_Resource(array( 
        'basePath'      => APPLICATION_PATH, 
        'namespace'     => '', 
        'resourceTypes' => array( 
            'form' => array( 
                'path'      => 'forms/', 
                'namespace' => 'Form_', 
            ), 
            'model' => array( 
                'path'      => 'models/', 
                'namespace' => 'Model_' 
            ), 
        ), 
    )); 
    // Return it so that it can be stored by the bootstrap 
    return $autoLoader; 
} 





    
    



}

