<?php
/**
 * Orders
 * 
 * @author Alex
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';
class Model_Orders extends Zend_Db_Table_Abstract
{
    /**
     * The default table name 
     */
    protected $_name = 'orders';
    
    protected $_dependentTables = array('Model_OrdersDetails'); 
    
   	protected $_referenceMap    = array( 
					'orders' => array( 
					'columns'           => array('orderID'),
					'refTableClass'     => 'Model_OrdersDetails', 
					'refColumns'        => array('id'), 
					'onDelete'          => self::CASCADE, 
					'onUpdate'          => self::RESTRICT 
				) 
			); 	
    
    
    
    public function createOrder($userID,$bfName,$blName,$bAddress,$bState,$bCountry,$bCity,$bZip,
                                $sfName,$slName,$sAddress,$sState,$sCountry,$sCity,$sZip,
                                $subtotal,$shipping,$total,$cc
                                ) 
	{ 
	    try {
		    $row = $this->createRow(); 
		
	    	$row->userID=$userID;
	    	$row->bfName= $bfName; 
	    	$row->blName= $blName; 
	    	$row->bAddress= $bAddress ;
		    $row->bState= $bState; 
		    $row->bCountry= $bCountry; 
	    	$row->bCity= $bCity; 
	    	$row->bZip= $bZip; 
		    $row->sfName= $sfName; 
		    $row->slName= $slName; 
		    $row->sAddress= $sAddress; 
		    $row->sState= $sState; 
		    $row->sCountry= $sCountry; 
		    $row->sCity= $sCity; 
		    $row->sZip= $sZip; 
		    $row->subtotal= $subtotal; 
		    $row->shipping= $shipping; 
		    $row->total= $total; 
		    $row->cc= $cc; 
		    $row->status= "new"; 
		
		    $dateObject = new Zend_Date($date); 
		    $row->insert_date = $dateObject->get(Zend_Date::TIMESTAMP); 

		    return $row->save(); 
	    }
	       catch (Zend_Db_Exception $e)
	       {
	           echo $e->getMessage();
	       }
	}

	public function getOrder($orderID)
	{
	    return $order = $this->find($orderID)->current(); 
	}
	
	public function deleteOrder($id){
	    
	    $row=$this->find($id)->current();
	    try{
	        $row->delete();
	    } catch (Zend_Db_Exception $e)
	   {
	       echo $e->getMessage();
	   }
	}
	
	public function setStatusOrder($id,$status){
	    
	    $row=$this->find($id)->current();
	    try{
	        $row->status=$status;
	        $row->save();
	        return true;
	    } catch (Zend_Db_Exception $e)
	   {
	       echo $e->getMessage();
	   }
	}
}

class Model_OrdersDetails extends Zend_Db_Table_Abstract
{
    /**
     * The default table name 
     */
    protected $_name = 'orderDetails';
    
    protected $_dependentTables = array('Model_Orders'); 
    
   	protected $_referenceMap    = array( 
					'orders' => array( 
					'columns'           => array('orderID'),
					'refTableClass'     => 'Model_Orders', 
					'refColumns'        => array('id'), 
					'onDelete'          => self::CASCADE, 
					'onUpdate'          => self::RESTRICT 
				) 
			); 	
    
    
    public function createOrderDetails($orderID,$productID,$quantity) 
	{ 
	    try {
	        $row = $this->createRow(); 
		
	    	$row->orderID=$orderID;
	    	$row->prodID=$productID;
	    	$row->quantity=$quantity;
		
		    return $row->save(); 
		
		   }
	   catch (Zend_Db_Exception $e)
	   {
	       echo $e->getMessage();
	   }
	} 
	
	public function getOrderDetails($orderID)
	{
	   		$select = $this->select(); 
				$select->where("orderID = ?", $orderID); 
				
		return $rows = $this->fetchAll($select);  
	}
}
