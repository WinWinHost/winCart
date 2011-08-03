<?php


 
class Model_Products extends Zend_Db_Table_Abstract { 
    /** 
     * The default table name 
     */ 
    protected $_name = 'products'; 
   
	
	public function fetchPaginatorAdapter($filters = array(), $sortField = null) 
	{ 
		$select = $this->select(); 
		// add any filters which are set 	
		if(count($filters) > 0) { 
			foreach ($filters as $field => $filter) { 
				$select->where($field . ' = ?', $filter); 
			} 
		} 
		$select->where('stock >0');
		// add the sort field is it is set 
		if(null != $sortField) { 
			$select->order($sortField); 
		} 
    
		// create a new instance of the paginator adapter and return it 
		$adapter = new Zend_Paginator_Adapter_DbTableSelect($select); 
		return $adapter; 
	} 
	
	public function createProduct($name,$slug,$price,$cost,$stock,$image,$cat,$content,$meta_keywords,$meta_description){
	
	 // create a new row in the bugs table 
	   try {
	    $row = $this->createRow(); 
		
		    // set the row data 
		    $row->cat = $cat;
		    $row->name = $name; 
		    $row->slug = $slug;
		    $row->price = $price; 
		    $dateObject = new Zend_Date($date); 
		    $row->insert_date = $dateObject->get(Zend_Date::TIMESTAMP); 
		    $row->cost = $cost; 
		    $row->stock = $stock;
		    $row->thump = $image; 
		    $row->content = $content; 				
		    $row->meta_keywords = $meta_keywords; 
		    $row->meta_description = $meta_description; 
            
	    	// save the new row 
		    $row->save(); 
	   
	         $id = $this->_db->lastInsertId(); 
		    return true; 
	   }
	   catch (Zend_Db_Exception $e)
	   {
	       echo $e->getMessage();
	   }
	}
	
	public function updateProduct($id,$name,$slug,$price,$cost,$stock,$image,$cat,$content,$meta_keywords,$meta_description){
		// find the row that matches the id 
		$row = $this->find($id)->current(); 
 
		try { 
		
		    // set the row data 
		    $row->cat = $cat;
		    $row->name = $name; 
		    $row->slug = $slug;
		    $row->price = $price; 
		    $dateObject = new Zend_Date($date); 
		    $row->insert_date = $dateObject->get(Zend_Date::TIMESTAMP); 
		    $row->cost = $cost; 
		    $row->stock = $stock;
		    $row->thump = $image; 
		    $row->content = $content; 				
		    $row->meta_keywords = $meta_keywords; 
		    $row->meta_description = $meta_description; 
 
		// save the new row 
		$row->save(); 
 
		return true; 
		}   
		catch (Zend_Db_Exception $e)
	       {
	           echo $e->getMessage();
	       }
	}
	
	public function deleteProduct($id) 
	{ 
		// find the row that matches the id 
		$row = $this->find($id)->current(); 
		try { 
			$row->delete(); 
			return true; 
		} 
	   catch (Zend_Db_Exception $e)
	   {
	       echo $e->getMessage();
	   }
    } 
    
    public function getProd($slug){
        try { 
            $select = $this->select(); 
            $select->where( 'slug= ?', $slug);
            $row = $this->fetchRow($select); 
        
    	    if(count($row)>0) { 
		    	return $row;	
	    	}else{
		      return false;
	    	}
        } 
	   catch (Zend_Db_Exception $e)
	   {
	       echo $e->getMessage();
	   }
         
    }
    public function getProdCat($cat){
        try { 
            $select = $this->select(); 
            $select->where( 'cat= ?', $cat);
            $rows = $this->fetchall($select); 
            return $rows;
        }
    	catch (Zend_Db_Exception $e)
	   {
	       echo $e->getMessage();
	   }
    }
    
    public function setStock($id,$stock){
        
       try { 
            $row=$this->find($id)->current();
            $row->stock=$row->stock - $stock;
            $row->save(); 
            return true;
        }
    	catch (Zend_Db_Exception $e)
	   {
	       echo $e->getMessage();
	   }
        
    }
    
    public function getStock($id){
        
       try { 
            $row=$this->find($id)->current();
           
            
            return $row->stock;
        }
    	catch (Zend_Db_Exception $e)
	   {
	       echo $e->getMessage();
	   }
        
    }
    
    
}
 
 ?>