<?php 

class Application_Plugin_View extends Zend_Controller_Plugin_Abstract

{
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $frontController = Zend_Controller_Front::getInstance();
        $view = $frontController->getParam('bootstrap')->getResource('view'); 

        $view->doctype('XHTML1_STRICT');
            
        $baseUrl = $request->getBaseUrl();
        if (defined('RUNNING_FROM_ROOT')) {
            $baseUrl .= '/public'; 
            $frontController->setBaseUrl($baseUrl); 
        }
        $view->headLink()->appendStylesheet($baseUrl . '/skins/blues/css/layout.css');
        $view->headLink()->appendStylesheet($baseUrl . 'skins/blues/css/product.css');
      
    }    
}

?>