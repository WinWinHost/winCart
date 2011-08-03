<?php

/*
 * File for the cart controller. Cart,checkout and order saving are resolved here
 *  
 *  @author Alex Maiereanu(alexmaie@gmail.com)
 *  @version: Beta
 *  
 *  @package Cart
 * 
 */

/*
 * Cart controller class
 * 
 * @package Cart
 * @subpackage classes
 */

class CartController extends Zend_Controller_Action
{

    /**
     *  object to access the cart table
     * 
     * @access protected
     * @var object
     */
	protected $cartModel; 
	
	
	/**
     *   object to access logged user information
     * 
     * @access protected
     * @var object
     */
		
	protected $identity;   
	
	protected $optionsModel;
	
	/**
	 * zend controller initialization function, sets class vars $cartModek abd $identity
 	*/
	
    public function init()
    {
        /* Initialize action controller here */
        
		$phpsessid=$_COOKIE["PHPSESSID"]; // get session id
		$this->cartModel = new Model_Cart();  // initialize cart model
		$this->cartModel->phpsessid=$phpsessid; // set phpsessid in class variable phpsessid
		
		$auth = Zend_Auth::getInstance(); // get auth instance
	     
		if($auth->hasIdentity())   $this->identity = $auth->getIdentity(); //if there is somebody logged,get 
                 $this->optionsModel=new Model_Options();
    }

  
    
    /**
	 * action for index page
 	*/
    public function indexAction()
    {
       $count=$this->cartModel->countCart();  // get items in cart
	   $this->view->cart = $this->cartModel->getCart(); // get object with cart items and set the view variable for it
    }

    /**
	 * action for adding an item to the cart
 	*/
    public function addAction()
    {
        $prodID = $this->_request->getParam('prodID'); //get product id
		
        $row=$this->cartModel->inCart($prodID);
        
        if(!$row->cartID) 
        {
              $this->cartModel->addToCart($prodID);
        } 
     
		$this->_redirect('products'); 
		
    }
	
    
    /**
	 * update quantity of an item in the cart
 	*/
	public function updateAction()
    {
         $cartID = $this->_request->getParam('cartID'); //get cart id
		$quantity= $this->_request->getParam('quantity'); //get new quantity
		$prodID= $this->_request->getParam('prodID'); //get new quantity
		
		$productModel=New Model_Products(); //object to the product model
		$stock=$productModel->getStock($prodID); //get stock
		 
		//verification if stock for product is enough
		
		if($quantity>$stock){
		    echo 'low stock';
		}else{
		//set new quantity
		    $this->cartModel->updateCart(
		    	$cartID,
		    	$quantity
	    	);
		
		}
		//because this is an ajax called function,we don't need the layout
	    $this->_helper->layout->disableLayout();
    	$this->getHelper('viewRenderer')->setNoRender();
    }

    /**
	 * action ,count items in cart
 	*/
	public function countAction()
	{
	  $count=$this->cartModel->countCart(); //get count 
	   $this->view->count=$count; //set view variable
	}
	
	/*delete an item in the cart
	 * 
	 */
	public function deleteAction(){
		
		$cartID = $this->_request->getParam('cartID'); //get product id
		$this->cartModel->deleteProdCart($cartID);     //delete item in the cart
		$this->_redirect('cart'); //redirect to the cart
	}
	
	/*checkout verification,display the cart and a form to check if order,billing and shipping information is alright
	 * 
	 */
	public function detailsAction(){
	    
	     $this->view->cart = $this->cartModel->getCart();
	    $this->view->identity=$this->identity;
	}
	
	/* sage payment transaction and order saving
	 * 
	 */
	public function transactionAction(){
	    
            
	     if ($this->_request->isPost()) { 
	         
	        /*
	         * Get subtotal ( total of price items) and shipping cost to calculate total of order
	         * 
	         */
                
        $subtotal=$this->_request->getPost('subtotal');
            $shipping=$this->_request->getPost('shipping');
            $total=$this->_request->getPost('total');

	       	 $mid			= "703828283461";  //sage merchant id
	        $mkey			= "R7A7A6H7N7J6";  //sage merchant key
	
	         $eftsecure_url = "https://www.sagepayments.net/cgi-bin/eftbankcard.dll?transaction"; //sage api url
	
	         $data = "m_id=" . 			$mid; 
	         $data .= "&m_key=" . 		$mkey; 
	         $data .= "&T_amt=" . 		$total;     //transaction total
	         $data .= "&C_name=" . 		urlencode($this->_request->getPost('cardFirstName')); // first name on cart
	         $data .= "&C_address=" . 	urlencode($this->_request->getPost('cardLastName'));  //last name on card
	         $data .= "&C_state=" .         urlencode($this->_request->getPost('bState'));    //state
	         $data .= "&C_city=" . 		urlencode($this->_request->getPost('bCity'));		   //city
	         $data .= "&C_cardnumber=" .    urlencode($this->_request->getPost('cc'));			   //card number
	         $data .= "&C_exp=" . 		urlencode($this->_request->getPost('mm').$this->_request->getPost('yy')); // expiration date month+year
	         $data .= "&C_zip=" . 		urlencode($this->_request->getPost('bZip'));  //zip
	         $data .= "&C_email=" . 	urlencode("alexmaie@gmail.com"); //card holder email, in this application we use this to verify if tranzaction was good
	         $data .= "&T_code=02"; // transaction type indicator,02=AuthOnly
	        
	         //curl initialisation and execution
	         $ch = curl_init(); 
                 curl_setopt($ch, CURLOPT_URL, $eftsecure_url);
	         curl_setopt($ch, CURLOPT_POST, 1); 
	         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	         $res = curl_exec($ch);  //anwser of api
	         curl_close($ch); 
	 
	        // $res[1]='A';
	         
	         /*
	          * If the transaction has been accepted, we can insert the order and order details
	          */
	         
	         if( strtoupper($res[1]) == 'A'){
       
	             //$bCountry="RO";
	             
	             /*
	              * initialization user information for the database
	              * if shipping checkbox is not set  then set then shipping variables the same with the billing variables
	              */
	             
	             $userID=$this->identity->id;
	             $bfName=$this->_request->getPost('bfName');
	             $blName=$this->_request->getPost('blName');
	             $bAddress=$this->_request->getPost('bAddress');
	             $bState=$this->_request->getPost('bState');
	             $bCountry=$this->_request->getPost('bCountry');
	             $bCity=$this->_request->getPost('bCity');
	             $bZip=$this->_request->getPost('bZip');

	             $shippingCheck=$this->_request->getPost('shippingCheck');
	             if(isset($shipping)){
	                 $sfName=$this->_request->getPost('sfName');
	                 $slName=$this->_request->getPost('slName');
	                 $sAddress=$this->_request->getPost('sAddress');
	                 $sState=$this->_request->getPost('sState');
	                 $sCountry=$this->_request->getPost('sCountry');
	                 $sCity=$this->_request->getPost('sCity');
	                 $sZip=$this->_request->getPost('sZip');
	             }else{
	                 $sfName=$bfName;
	                 $slName=$blName;
	                 $sAddress=$bAddress;
	                 $sState=$bState;
	                 $sCountry=$bCountry;
	                 $sCity=$bCity;
	                 $sZip=$bZip;
	             }
	             
                     
                     
                 $cc=(int)$this->_request->getPost('cc');
                 
                 $orderModel=New Model_Orders(); //object to the order tables
                 $orderDetailsModel=New Model_OrdersDetails(); //object to the order details table
                 $productModel=New Model_Products(); //object to the product model
                 $pdf=New CMS_Pdf();
                 
                 //create a new order and return the order id
	            $orderID=$orderModel->createOrder($userID,$bfName,$blName,$bAddress,$bState,$bCountry,$bCity,$bZip,
                                $sfName,$slName,$sAddress,$sState,$sCountry,$sCity,$sZip,
                                $subtotal,$shipping,$total,$cc
                                ) ;
                 
	           
                                
                                
                 if($orderID)
	             {
	                $cart = $this->cartModel->getCart(); //get cart items
                
                     foreach ($cart as $item){
                       $orderDetailsModel->createOrderDetails($orderID,$item->prodID,$item->quantity);
                       $productModel->setStock($item->prodID,$item->quantity);
                     }
                     
                   $pdfDoc=$pdf->create($orderModel->getOrder($orderID));
	               
	                $this->view->pdf=$pdfDoc;
	                $this->view->order=$orderModel->getOrder($orderID);
	           
	               $this->cartModel->dumbCart();
	             }else {
	                 echo 'Error,could not save order ,contact us at '.$this->optionsModel->email;
	             }
             

               
	         }else{
	              $this->view->error="Transaction unsuccesful! <br />Please review your card information or contact us at contact@newacnesolution.com ";
	             //$this->view->error=$res;
	         }
	         
	     }
	    
	}
	



}



