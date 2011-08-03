<?php

class ProductseditController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

 public function createAction()
    {
        $image="";
                              $productForm = new Form_ProductForm();
                                if ($this->getRequest()->isPost()) {
                                    if ($productForm->isValid($_POST)) {
                                        // create a new page item
                                        $productModel = new Model_Products();
                        				 if ($productForm->image->isUploaded()) {
                                            $productForm->image->receive();
                                            $image = basename($productForm->image->getFileName());
                                        }
                                        $result = $productModel->createProduct( 
                                                                $productForm->getValue('name'), 
                                                                $productForm->getValue('slug'),
                                                                $productForm->getValue('price'), 
                                                                $productForm->getValue('cost'), 
                                                                $productForm->getValue('stock'), 
                                                                $image, 
                                                                $this->_request->getPost('category'),
                                                                $productForm->getValue('content'),
                                                                $productForm->getValue('meta_keywords'), 
                                                                $productForm->getValue('meta_description') 
                                                                
                                                				            ); 
                        													
                        				if($result) { 
                                              $this->_forward('list'); 
                                        } 
                                    }
                                }
                                   $category= $productForm->createElement("select","category");
                                    $category->setLabel("Category:"); 
                                    
                                    $categoryModel=new Model_Category();
                                    $select = $categoryModel->select();
                                    $select->order('name');
                                    $cat = $categoryModel->fetchAll($select);
                					
                                   foreach ($cat  as $value) 
                                   {            
                                          $category->addMultiOption($value->id, $value->name);           
                                   }
                                    $category->setOrder(5);
                                    $productForm->addElement($category);
                                    $productForm->setAction('/productsedit/create');
                					$this->view->form = $productForm;
    }

    public function updateAction()
    {
        $image="";
                              $productForm = new Form_ProductForm();
                                if ($this->getRequest()->isPost()) {
                                    if ($productForm->isValid($_POST)) {
                                        // create a new page item
                                        $productModel = new Model_Products();
                        				 if ($productForm->image->isUploaded()) {
                                            $productForm->image->receive();
                                            $image = basename($productForm->image->getFileName());
                                        }else{
                                            $image= basename($this->_request->getPost('imagepath'));
                                        }
                                        $result = $productModel->updateProduct( 
                												$productForm->getValue('id'),
                                                                $productForm->getValue('name'), 
                                                                $productForm->getValue('slug'),
                                                                $productForm->getValue('price'), 
                                                                $productForm->getValue('cost'), 
                                                                $productForm->getValue('stock'), 
                                                                $image, 
                                                                $this->_request->getPost('category'),
                                                                $productForm->getValue('content'),
                                                                $productForm->getValue('meta_keywords'), 
                                                                $productForm->getValue('meta_description') 
                                                				            ); 
                        													
                        				if($result) { 
                                              $this->_forward('list'); 
                                        } 
                                    }
                                }
                                
                                $id = $this->_request->getParam('id'); 
                                    
                                    $productModel=new Model_Products();
                					$product = $productModel->find($id)->current(); 
                					$productForm->populate($product->toArray()); 
                					
        							$category= $productForm->createElement("select","category");
                                    $category->setLabel("Category:"); 
                                    
                                    $categoryModel=new Model_Category();
                                    $select = $categoryModel->select();
                                    $select->order('name');
                                    $cat = $categoryModel->fetchAll($select);
                					
                                   foreach ($cat  as $value) 
                                   {            
                                          $category->addMultiOption($value->id, $value->name);           
                                   }
                                    $category->setOrder(5);
                                    $category->setValue($product->cat);
                                    $productForm->addElement($category);                               
                                  

                					$imagePreview = $productForm->createElement('image', 'image_preview');
        							// element options
        							$imagePreview->setLabel('Preview Image: ');
        							
        							// add the element to the form
        							$imagePreview->setOrder(6);
        							$imagePreview->setImage("/images/products/".$product->thump);
        							
        							$productForm->addElement($imagePreview);      							
        							

                					$imagepath = $productForm->createElement('hidden', 'imagepath');
        							// element options
        							        							
        							// add the element to the form
        							$imagepath->setOrder(7);
        							$imagepath->setValue($product->thump);
        							
        							$productForm->addElement($imagepath);
        							
                				$productForm->setAction('/productsedit/update');				
                				$this->view->form = $productForm;
    }

    public function deleteAction()
    {
        $productModel = new Model_Products();
                		$id = $this->_request->getParam('id'); 
                		$productModel->deleteProduct($id); 
                		return $this->_forward('list');
    }

    public function listAction()
    {
        $productModel = new Model_Products();
                // fetch all of the current pages
                $select = $productModel->select();
                $select->order('name');
                $products = $productModel->fetchAll($select);
                if ($products->count() > 0) {
                    $this->view->products = $products;
                } else {
                    $this->view->products = null;
				}
    }

    public function addcatAction()
    {
        $categoryForm=new Form_Category();
        
        if ($this->getRequest()->isPost()) {
            if ($categoryForm->isValid($_POST)) {
                $categoryModel=new Model_Category();
          
                $result=$categoryModel->createCat($categoryForm->getValue('name'),
                                                  $categoryForm->getValue('slug'),
                                                  $categoryForm->getValue('meta_description'),
                                                  $categoryForm->getValue('meta_keywords')
                                                  );
                											
                if($result) { 
                    $this->_forward('listcat'); 
                 } 
            }
        }else {
        
		
		$categoryForm->setAction('/productsedit/addcat');
        $this->view->form = $categoryForm;
        }
    }
    
    public function listcatAction(){
        
               // fetch the product paginator adapter 
                 $categoryModel=new Model_Category();
                  // fetch all of the current pages
                $select = $categoryModel->select();
                $select->order('name');
                $cat = $categoryModel->fetchAll($select);
                if ($cat->count() > 0) {
                    $this->view->products = $cat;
                } else {
                    $this->view->products = null;
				}
        
    }
    
     public function updatecatAction(){
         
        
        $categoryForm=new Form_Category();
        
        if ($this->getRequest()->isPost()) {
            if ($categoryForm->isValid($_POST)) {
                
                $categoryModel=new Model_Category();
                $result=$categoryModel->updateCat(
                                    $categoryForm->getValue('id'),
                                    $categoryForm->getValue('name'),
                                    $categoryForm->getValue('slug'),
                                    $categoryForm->getValue('meta_description'),
                                    $categoryForm->getValue('meta_keywords')
                        );
                											
                if($result) { 
                    $this->_forward('listcat'); 
                 } 
            }
        }else {
        
		$id = $this->_request->getParam('id'); 
        $categoryModel=new Model_Category();
        $categoryModel = $categoryModel->find($id)->current(); 
        $categoryForm->populate($categoryModel->toArray()); 
            
		$categoryForm->setAction('/productsedit/updatecat');
        $this->view->form = $categoryForm;
        
     }

    }

    
   public function deletecatAction()
    {
        $categoryModel = new Model_Category();
        $id = $this->_request->getParam('id'); 
        $categoryModel->deleteCat($id); 
        return $this->_forward('listcat');
    }

}

