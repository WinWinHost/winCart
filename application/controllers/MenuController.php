<?php

class MenuController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $mdlMenu = new Model_Menu(); 
                		$this->view->menus = $mdlMenu->getMenus();
    }

    public function createAction()
    {
        $frmMenu = new Form_Menu(); 
                		if($this->getRequest()->isPost()) { 
                			if($frmMenu->isValid($_POST)) { 
                				$menuName = $frmMenu->getValue('name'); 
                				$access = $this->_request->getParam('access_level');
                				$mdlMenu = new Model_Menu(); 
                				$result = $mdlMenu->createMenu($menuName,$access); 
                				if($result) { 
                                // redirect to the index action 
                					$this->_redirect('/menu/index'); 
                				} 
                			} 
                		}
                		        // create new element 
        $access_level = $frmMenu->createElement('select', 'access_level'); 
        // element options 
        $access_level->setLabel('Access level: '); 
        $access_level->setRequired(TRUE); 
        $access_level->setOrder(2);
        $access_level->addMultiOption('admin','Admin');
        $access_level->addMultiOption('user','User');
        $access_level->addMultiOption('public','Public');
        
        // strip all tags from the menu name for security purposes 
        $access_level->addFilter('StripTags'); 
        // add the element to the form 
        $frmMenu->addElement($access_level); 
         
                		$frmMenu->setAction('/menu/create'); 
                		$this->view->form = $frmMenu;
    }

    public function editAction()
    {
        $id = $this->_request->getParam('id'); 
        		$mdlMenu = new Model_Menu(); 
        		$frmMenu = new Form_Menu(); 
        		// if this is a postback, then process the form if valid 
        		if($this->getRequest()->isPost()) { 
        			if($frmMenu->isValid($_POST)) { 
        				$menuName = $frmMenu->getValue('name'); 
        				$access = $this->_request->getParam('access_level');
        				$result = $mdlMenu->updateMenu($id, $menuName,$access); 
        				if($result) { 
        					// redirect to the index action 
        					return $this->_forward('index'); 
        				} 
        			} 
        		}else{ 
        			// fetch the current menu from the db 
        			$currentMenu = $mdlMenu->find($id)->current(); 
        			// populate the form 
        			$frmMenu->getElement('id')->setValue($currentMenu->id); 
        			$frmMenu->getElement('name')->setValue($currentMenu->name); 
        		}
                		        // create new element 
                		        
                $access_level = $frmMenu->createElement('select', 'access_level'); 
                // element options 
                $access_level->setLabel('Access level: '); 
                $access_level->setRequired(TRUE); 
                $access_level->setOrder(2);
                $access_level->addMultiOption('admin','Admin');
                $access_level->addMultiOption('user','User');
                $access_level->addMultiOption('public','Public');
               
                $row=$mdlMenu->find($id)->current();
                
                $access_level->setValue($row->access_level);
                
                // strip all tags from the menu name for security purposes 
                $access_level->addFilter('StripTags'); 
                // add the element to the form 
                $frmMenu->addElement($access_level); 
        		
        		$frmMenu->setAction('/menu/edit'); 
        		// pass the form to the view to render 
        		$this->view->form = $frmMenu;
    }

    public function deleteAction()
    {
        $id = $this->_request->getParam('id'); 
        		$mdlMenu = new Model_Menu(); 
        		$mdlMenu->deleteMenu($id); 
        		$this->_forward('index');
    }

public function renderAction() 
{ 
    $menu = $this->_request->getParam ( 'menu' ); 
    $menuModel=new Model_Menu();
    $mdlMenuItems = new Model_MenuItem ( ); 
    
    $currentMenu = $menuModel->find($menu)->current(); 
    $menuItems = $mdlMenuItems->getItemsByMenu ( $menu ); 
 
    if(count($menuItems) > 0) { 
        foreach ($menuItems as $item) { 
            $label = $item->label; 
            if($item->link_type=='link') { 
                $uri = $item->link; 
            }elseif($item->link_type=='page'){ 
                // update this to form more search-engine-friendly URLs
                $page = new CMS_Content_Item_Page($item->page_id); 
                $uri = '/page/open/title/' . $page->name; 
            }elseif($item->link_type=='category'){
                $catModel = new Model_Category(); 
                $cat = $catModel->find($item->page_cat_id )->current();  
                $uri =  '/products/'.$cat->slug; 
            } 
            $itemArray[] = array( 
                'label'        => $label, 
                'uri'        => $uri 
            ); 
        } 
        $this->view->title=$currentMenu->name;
        $container = new Zend_Navigation($itemArray); 
        $this->view->navigation()->setContainer($container); 
    } 
} 
 
	public function moveAction(){
	     $id = $this->_request->getParam ( 'id' ); 
         $direction = $this->_request->getParam ( 'direction' );   
         $menuModel=new Model_Menu();
         $result=$menuModel->move($id,$direction);
         
         if($result){
             $this->_forward ( 'index' );
         }
         
	}			


}







