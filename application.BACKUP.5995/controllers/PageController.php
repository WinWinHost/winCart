<?php
class PageController extends Zend_Controller_Action
{
    public function indexAction ()
    {
        $mdlPagepageModel = new Model_Page();
        $recentPages = $mdlPagepageModel->getRecentPages();
        if (is_array($recentPages)) {
            // the 3 most recent items are the featured items
            for ($i = 1; $i <= 4; $i ++) {
                if (count($recentPages) > 0) {
                    $featuredItems[] = array_shift($recentPages);
                }
            }
            $this->view->featuredItems = $featuredItems;
            if (count($recentPages) > 0) {
                $this->view->recentPages = $recentPages;
            } else {
                $this->view->recentPages = NULL;
            }
        }
    }
    
    public function openAction ()
    {
        $slug = $this->_request->getParam('slug');
        $mdlPage = new Model_Page();
        $row = null;
        
        $select=$mdlPage->select();
        $select->where('slug=?',$slug);
        
        $row=$mdlPage->fetchRow($select);
        $id=$row->id;
        // first confirm the page exists
        $bootstrap = $this->getInvokeArg('bootstrap');
        $cache = $bootstrap->getResource('cache');
        $cacheKey = 'content_page_' . $id;
        $page = $cache->load($cacheKey);
        if (! $page) {
            if ($row instanceof Zend_Db_Table_Row) {
                $page = new CMS_Content_Item_Page($row);
            } else {
                $page = new CMS_Content_Item_Page($id);
            }
            // add a cache tag to this menu so you can update the cached menu
            // when you update the page
            $tags[] = 'page_' . $page->id;
            $cache->save($page, $cacheKey, $tags);
        }
        
        $this->_helper->layout()->keywords=$page->meta_keywords;
        $this->_helper->layout()->description=$page->meta_description;
        $this->_helper->layout()->title=$page->name;
        $this->view->page = $page;
    }
    

}
?>