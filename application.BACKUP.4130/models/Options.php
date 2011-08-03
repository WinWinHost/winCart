<?php
class Model_Options extends Zend_Db_Table_Abstract {
    
    protected $_name = 'options'; 
    
    public function getOptions(){
        $row=$this->fetchRow()->toArray();
         return $row;
    }
    
    public function setOption($title,$description,$keywords,$email){
        try {
            $row=$this->find(1)->current();
     
            $row->title=$title;
            $row->meta_description=$description;
            $row->meta_keywords=$keywords;
            $row->email=$email;
            $row->save();
        }
    	catch (Zend_Db_Exception $e)
	   {
	       echo $e->getMessage();
	   }
    }
    
}

?>