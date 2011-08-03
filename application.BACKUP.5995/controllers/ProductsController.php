<?php

class ProductsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	  
        // fetch the product paginator adapter 
                 $products = new Model_Products(); 
                 $adapter = $products->fetchPaginatorAdapter($filter, $sort); 
                 $paginator = new Zend_Paginator($adapter); 
                 
                                        
                 // show 10 products per page 
                 $paginator->setItemCountPerPage(6); 
                                        			
                 // get the page number that is passed in the request. 
                 //if none is set then default to page 1. 
                 $page = $this->_request->getParam('page', 1); 
                 $paginator->setCurrentPageNumber($page); 
                                        			
                 // pass the paginator to the view to render 
                 $this->view->paginator = $paginator;
                 
                 $productCat = new Model_Category();
                 $cateView = $productCat->fetchAll();
                 $this->view->cateView = $cateView;
                 
                 return $cateView;
                

    }

    public function detailsAction()
    {
        $productModel = new Model_Products();
        $categoryModel=new Model_Category();
        
        $slug = $this->_request->getParam('slug');
       // $cat = $this->_request->getParam('cat');  
       
        $cat = $categoryModel->getCat($slug);
        $product = $productModel->getProd($slug);  
        if($cat){
            $products = $productModel->getProdCat($cat->id); 
              $this->view->cat = $cat;
             
            $this->view->products = $products;                   
             $this->_helper->layout()->keywords=$cat->meta_keywords;
            $this->_helper->layout()->description=$cat->meta_description;
             $this->_helper->layout()->title=$cat->name;
            return true;
            
        }elseif($product){
            $this->view->product = $product;
            $this->_helper->layout()->keywords=$product->meta_keywords;
            $this->_helper->layout()->description=$product->meta_description;
             $this->_helper->layout()->title=$product->name;
            return true;
        }else{
            $this->view->no="Sorry,no item(s)";
        }
       
      
        
    }

    public function catsearchAction()
    {
        $id = $this->_request->getParam('id');
    	$productCate = new Model_Products();
       
        $where = 'cat = '.$id ;
        $finalProduct = $productCate->fetchAll($where);
        $id=$this->_getParam('page',1);
    	$paginator = Zend_Paginator::factory($finalProduct);
        $paginator->setItemCountPerPage(4);
        $paginator->setCurrentPageNumber($id);
                 
    	$this->view->FilteredCate = $paginator; 			//this is sending filtered products to the view..
        $categories = $this->indexAction();
        $this->view->cateView = $categories;
        
        
        
    }

    public function addtocartAction()
    {
        $id = $this->_request->getParam('id');
        $productInCart = new Model_Products();
        
        $where = 'id = '. $id;
        $productFinal = $productInCart->fetchAll($where);
        
        $this->view->finalProduct = $productFinal;
        
        
    }

    public function updatecartAction()
    {
        $price = $this->_request->getParam('price');
        
        $totalPrice = $price  * $_POST['updateCart'];
        
        return $totalPrice;
        
        
    
        
    }


}













