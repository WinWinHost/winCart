<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Saves instance of default database.
     * @var Zend_Db 
     */
    private $_db;
    
    
    /**
     *  Inits default db adapter 
     */
    protected function _initDb()
    {      
        if ( $this->_db === null ) {
            $file = APPLICATION_PATH . '/configs/database.php';
            if(file_exists($file) && filesize($file) > 100) {
                $database = require_once($file);
                $this->_db = Zend_Db::factory($database['database']['adapter'], 
                                              $database['database']['params']);
                Zend_Db_Table::setDefaultAdapter($this->_db);
            } else {
                //Go to install script url
                header('Location: /install');
            }
        }
    }

    protected function _initView()
    {

        // Initialize view of BootStrap file
        $view = new Zend_View();
        $view->doctype('XHTML1_STRICT');

        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);

        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        $router->addRoute('products', new Zend_Controller_Router_Route('products/:slug', array('controller' => 'products', 'action' => 'details')));
        $router->addRoute('page', new Zend_Controller_Router_Route('page/:slug', array('controller' => 'page', 'action' => 'open')));

        return $view;
    }

    protected function _initAutoload() {
        // Add autoloader empty namespace
        $autoLoader = Zend_Loader_Autoloader::getInstance();
        $autoLoader->registerNamespace('CMS_');
        $resourceLoader = new Zend_Loader_Autoloader_Resource(array('basePath' => APPLICATION_PATH, 'namespace' => '', 'resourceTypes' => array('form' => array('path' => 'forms/', 'namespace' => 'Form_',), 'model' => array('path' => 'models/', 'namespace' => 'Model_'),),));
        // Return it so that it can be stored by the bootstrap
        return $autoLoader;
    }

}