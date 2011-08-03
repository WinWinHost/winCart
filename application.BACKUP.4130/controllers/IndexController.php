<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */

    }

    public function indexAction()
    {

        $form = new Form_Setting();
        
        $this->view->form = $form;
        
        $checkModel = new Model_Products();
        $checkModel->fetchAll();
        foreach ($checkModel as $data):
            $data['name'];
        endforeach;
        die();
        
      //  return $this->_redirect("index/updateinfo");
        
      //  return $this->_redirect('products');


/*        $mdlPagepageModel = new Model_Page();
        $recentPages = $mdlPagepageModel->getRecentPages(3);
        $this->view->articles=$recentPages;

        $productModel=New Model_Products();
        $select=$productModel->select();
        $select->order('insert_date');
        $select->limit(3);
        $product=$productModel->fetchAll($select);
        $this->view->product=$product;*/
    }


    public function updateinfoAction($id)
    {
        // return $this->_redirect($this->getRequest()->getParams());
        //die();return $this->_redirect('products');
        
        
    }


}

