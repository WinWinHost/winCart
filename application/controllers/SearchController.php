<?php

class SearchController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

public function indexAction() 
{ 
    if($this->_request->isPost()) { 
        $keywords = $this->_request->getParam('query'); 
        $query = Zend_Search_Lucene_Search_QueryParser::parse($keywords); 
        $index = Zend_Search_Lucene::open(APPLICATION_PATH . '/indexes'); 
        $hits = $index->find($query); 
        $this->view->results = $hits; 
        $this->view->keywords = $keywords; 
    }else{ 
        $this->view->results = null; 
    } 
} 
 public function buildAction() 
{ 
    // create the index 
    $index = Zend_Search_Lucene::create(APPLICATION_PATH . '/indexes'); 
     
    // fetch all of the current pages 
    $mdlPage = new Model_Page(); 
    $currentPages = $mdlPage->fetchAll(); 
    if($currentPages->count() > 0) { 
         // create a new search document for each page 
        foreach ($currentPages as $p) { 
            $page = new CMS_Content_Item_Page($p->id); 
            $doc = new Zend_Search_Lucene_Document(); 
            // you use an unindexed field for the id because you want the id 
            // to be included in the search results but not searchable 
            $doc->addField(Zend_Search_Lucene_Field::unIndexed('id',  
                $page->id)); 
            // you use text fields here because you want the content to be searchable 
            // and to be returned in search results  
            $doc->addField(Zend_Search_Lucene_Field::text('name',  
                $page->name)); 
           $doc->addField(Zend_Search_Lucene_Field::text('slug',  
           $page->slug)); 

            $doc->addField(Zend_Search_Lucene_Field::text('description',  
                $page->description)); 
            $doc->addField(Zend_Search_Lucene_Field::text('content',  
                $page->content)); 
            // add the document to the index 
            $index->addDocument($doc); 
        } 
    } 
    
    $productModel=new Model_Products();
    $products=$productModel->fetchAll();
    
    if($products->count()>0){
        $doc = new Zend_Search_Lucene_Document();
        foreach ($products as $item){
            
            $doc->addField(Zend_Search_Lucene_Field::unIndexed('id',  
                $item->id));
             $doc->addField(Zend_Search_Lucene_Field::text('name',  
                $item->name));
             $doc->addField(Zend_Search_Lucene_Field::text('slug',  
                $item->slug));
              $doc->addField(Zend_Search_Lucene_Field::text('description',  
                $item->meta_description));
              $doc->addField(Zend_Search_Lucene_Field::text('content',  
                $item->content));
                    $index->addDocument($doc); 
        }
        
     
    }
    
    // optimize the index 
    $index->optimize(); 
    // pass the view data for reporting 
    $this->view->indexSize = $index->numDocs(); 
} 

}



