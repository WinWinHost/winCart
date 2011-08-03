<?php 
class Model_Cart extends Zend_Db_Table_Abstract 
{ 
    protected $_name = 'cart'; 
	public $phpsessid;
	
	public function getCart(){
		
    	$cart =  $this->fetchAll("phpsessid='".$this->phpsessid."'");

        if($cart->count() > 0) { 
			return $cart; 
		}else{ 
			return null; 
		} 
	}
	
	public function addToCart($product){
	  
	  try {
	        $row = $this->createRow();  
	  
	       $row->phpsessid=$this->phpsessid;
	      $row->prodID=$product;
	      $row->quantity=1;
	      $row->insert_date=time();
	 
	         $row->save(); 
	  	   }
	   catch (Zend_Db_Exception $e)
	   {
	       echo $e->getMessage();
	   }
	}
	
	public function updateCart($cartID,$quantity){
	  
	 try {
	      $row = $this->find($cartID)->current(); 
	  
	      if($row) { 	
		
		    if($quantity<=0)  
		    	$row->delete();
	    	else{
		    	$row->quantity=$quantity;
		    	$row->save(); 
	    	}
	      }
	 }
	   catch (Zend_Db_Exception $e)
	   {
	       echo $e->getMessage();
	   }
	}
	
	public function deleteProdCart($id) 
	{ 
	     try {
        // find the row that matches the id 
            $row = $this->find($id)->current(); 
            if($row) { 
                $row->delete(); 
                return true; 
            }  
	     }
	   catch (Zend_Db_Exception $e)
	   {
	       echo $e->getMessage();
	   }
	
     }

	public function countCart() 
	{   
	  	$rows = $this->fetchAll("phpsessid='".$this->phpsessid."'");
		
		if(count($rows)>0) { 
			return count($rows);	
		}else{
		  return 0;
		 }
	}
	
	public function dumbCart() 
	{
	  $this->delete("phpsessid='".$this->phpsessid."'");
	}
 	
	public function inCart($prodID){
	    
		$select = $this->select(); 
				$select->where("prodID = ?", $prodID); 
				$select->where("phpsessid = ?", $this->phpsessid); 
		$row = $this->fetchRow($select); 
	    

	   // Zend_dumb::dump($rows);
		if(count($row)>0) { 
			return $row;	
		}else{
		  return false;
		}
	    
	}

	
}
?>