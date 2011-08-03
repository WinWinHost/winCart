<?php 
require_once 'Zend/Db/Table/Abstract.php'; 
class Model_Menu extends Zend_Db_Table_Abstract { 
      protected $_name = 'menus'; 
      protected $_dependentTables = array('Model_MenuItem'); 
      protected $_referenceMap    = array( 
        'Menu' => array( 
            'columns'           => array('parent_id'), 
            'refTableClass'     => 'Model_Menu', 
            'refColumns'        => array('id'), 
            'onDelete'          => self::CASCADE, 
            'onUpdate'          => self::RESTRICT 
        ) 
    ); 
	
	public function createMenu($name,$access) 
	{ 
	    try {
		    $position=$this->getLastPosition()+1;
	    
	        $row = $this->createRow(); 
		    $row->name = $name; 
		    $row->position=$position;
	    	$row->access_level = $access; 
		
		    return $row->save(); 
	    }  
	    catch (Zend_Db_Exception $e)
	       {
	           echo $e->getMessage();
	       }
	} 
	
	public function getMenus() 
	{ 
		$select = $this->select(); 
		
		$select->order('position ASC'); 
		$menus = $this->fetchAll($select); 
		if($menus->count() > 0) { 
			return $menus; 
		}else{ 
			return null; 
		} 
	}
	

	public function updateMenu ($id, $name,$access) 
	{ 
	    try {
		    $currentMenu = $this->find($id)->current(); 
		    
		    if ($currentMenu) { 
			    	$currentMenu->name = $name; 
				    $currentMenu->access_level=$access;
				    return $currentMenu->save(); 
		 }
	    }  
	    catch (Zend_Db_Exception $e)
	       {
	           echo $e->getMessage();
	       }
	}
	
	public function getLastPosition(){
	    $select=$this->select();
	    $select->order('position Desc');
	    $row=$this->fetchRow($select);
	    return $row->position;
	}
	
	public function move($id,$direction){
	    
	  try {   
	    $menu=$this->find($id)->current();
	    $position=NULL;
	    if($direction=='up' && $menu->position==0){
	        return true;
	    }
	    elseif($direction=='up' ){

	        $position=$menu->position-1;
	        $positionMoved=$menu->position;
	        
	    }elseif($direction=='down'){
	        
	        $position=$menu->position+1;
	        $positionMoved=$menu->position;
	    }
	    
	    $select=$this->select();
	    $select->where('position = ?',$position);
	    
	    $menuMoved=$this->fetchRow($select);
	    if($menuMoved){
	        //$menuMoved=$menusMoved->current();
	        $menuMoved->position=$positionMoved;
	        $menuMoved->save();
	    }
	    $menu->position=$position;
	    $menu->save();
	    
	    return true;
	        }
    	catch (Zend_Db_Exception $e)
	   {
	       echo $e->getMessage();
	   }
        
	}
	 
	
	public function deleteMenu($menuId) 
	{ 
		$row = $this->find($menuId)->current(); 
		if($row) { 
			return $row->delete(); 
		}else{ 
			throw new Zend_Exception("Error loading menu"); 
		} 
	} 
} 
?> 