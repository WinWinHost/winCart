<?php

class OrdersadminController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        	    
	     $orderModel=New Model_Orders(); //object to the order tables
	     $select=$orderModel->select();
	     $select->order('insert_date DESC');
	     $orders=$orderModel->fetchAll($select);
	     
	     
	     $this->view->orders=$orders;
    }

    public function deleteAction()
    {
        $orderModel = New Model_Orders();
                		$id = $this->_request->getParam('id'); 
                		$orderModel->deleteOrder($id); 
                		return $this->_forward('index');
    }
    
    public function detailsAction(){
        
        $id = $this->_request->getParam('id'); 
        $orderModel = New Model_Orders();
        $order=$orderModel->find($id)->current();
        $this->view->order=$order; 
        
    }
    
    public function setstatusAction(){
        
        $id = $this->_request->getParam('id'); 
        $status = $this->_request->getParam('status');
        $orderModel = New Model_Orders();
        $result=$orderModel->setStatusOrder($id,$status);
        if($result) $this->_forward('index');
        
    }

}

