<?php


 
class Model_Category extends Zend_Db_Table_Abstract { 
    /** 
     * The default table name 
     */ 
    protected $_name = 'product_cat'; 
	

	
	public function createCat($name,$slug,$meta_keywords,$meta_description){
	
	    try {
	 // create a new row in the bugs table 
	    $row = $this->createRow(); 
		
		    // set the row data 
		$row->name = $name; 
		$row->slug = $slug;
		$row->meta_keywords = $meta_keywords;
		$row->meta_description = $meta_description;
		
		$dateObject = new Zend_Date(); 
		$row->insert_date = $dateObject->get(Zend_Date::TIMESTAMP); 

 
		// save the new row 
		$row->save(); 
		return true;
		}
	    catch (Zend_Db_Exception $e)
	    {
	        echo $e->getMessage();
	    }
	}
	
	public function updateCat($id,$name,$slug,$meta_keywords,$meta_description){
		// find the row that matches the id 
		$row = $this->find($id)->current(); 
 
		try {
	     // create a new row in the bugs table 
	    
		
		    // set the row data 
				$row->name = $name; 
		$row->slug = $slug;
		$row->meta_keywords = $meta_keywords;
		$row->meta_description = $meta_description;
        $dateObject = new Zend_Date(); 
		$row->insert_date = $dateObject->get(Zend_Date::TIMESTAMP); 
 
			// save the new row 
		$row->save(); 
		return true;
		}
	   catch (Zend_Db_Exception $e)
	    {
	        echo $e->getMessage();
	    }
	}
	
	public function deleteCat($id) 
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
	
	public function getCat($slug) {
	    
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
}

 
 ?>