<?php

class OptionsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $optionModel=new Model_Options();
        
        $optionForm = new Form_Options();
           if ($this->getRequest()->isPost()) {
                if ($optionForm->isValid($_POST)) {
                    $optionModel->setOption(
                                        $optionForm->getValue('title'),
                                        $optionForm->getValue('meta_description'),
                                        $optionForm->getValue('meta_keywords'),
                                        $optionForm->getValue('email')
                                         );
                }
           }
        $optionForm->populate($optionModel->getOptions()); 
        $optionForm->setAction('/options/');
        $this->view->form=$optionForm;
        
    }


}

