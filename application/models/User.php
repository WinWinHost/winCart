<?php 
require_once 'Zend/Db/Table/Abstract.php'; 
class Model_User extends Zend_Db_Table_Abstract { 
    /** 
     * The default table name 
     */ 
    protected $_name = 'users'; 
	
	public function createUser($username, $password, $firstName, $lastName, $role,$address,$state,$zip,$city,$country) 
{ 
    try {
    // create a new row 
    $rowUser = $this->createRow(); 
    if($rowUser) { 
        // update the row values 
        $rowUser->username = $username; 
        $rowUser->password = md5($password); 
        $rowUser->first_name = $firstName; 
        $rowUser->last_name = $lastName; 
        $rowUser->role = $role; 
        $rowUser->address = $address;
        $rowUser->state = $state;
        $rowUser->zip = $zip;
        $rowUser->city = $city;
        $rowUser->country = $country;
        $rowUser->save(); 
        //return the new user 
        return $rowUser; 
    }
    } 	   
    catch (Zend_Db_Exception $e)
	   {
	       echo $e->getMessage();
	   } 
}
	
	public static function getUsers() 
{ 
    $userModel = new self(); 
    $select = $userModel->select(); 
    $select->order(array('last_name', 'first_name')); 
    return $userModel->fetchAll($select); 
} 


public function updateUser($id, $username, $firstName, $lastName, $role,$address,$state,$zip,$city,$country) 
{ 
    try{
    $rowUser = $this->find($id)->current(); 
 
    if($rowUser) { 
        
        // update the row values 
        $rowUser->username = $username; 
        $rowUser->first_name = $firstName; 
        $rowUser->last_name = $lastName; 
        $rowUser->role = $role; 
        $rowUser->address = $address;
        $rowUser->state = $state;
        $rowUser->zip = $zip;
        $rowUser->city = $city;
        $rowUser->country = $country;

        $rowUser->save(); 
        
        //return the updated user 
        
        return $rowUser; 
        }
    }catch (Zend_Db_Exception $e)
	   {
	       echo $e->getMessage();
	   }
}
	
	public function updatePassword($id, $password) 
{ 
    // fetch the user's row 
    $rowUser = $this->find($id)->current(); 
 
    if($rowUser) { 
        //update the password 
        $rowUser->password = md5($password); 
        $rowUser->save(); 
    }else{ 
        throw new Zend_Exception("Password update failed.  User not found!"); 
    } 
} 
	
	public function deleteUser($id) 
{ 
    // fetch the user's row 
    $rowUser = $this->find($id)->current(); 
    if($rowUser) { 
        $rowUser->delete(); 
    }else{ 
        throw new Zend_Exception("Could not delete user.  User not found!");
    } 
} 

	
} 

?>