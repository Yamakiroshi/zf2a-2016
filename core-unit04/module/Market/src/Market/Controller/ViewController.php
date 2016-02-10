<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Market\Model\ListingsTable;
use Market\Model\ListingsTableAwareInterface;

class ViewController extends AbstractActionController implements ListingsTableAwareInterface
{
    use \Market\Model\ListingsTableAwareTrait;

	protected $listingsTable;
	protected $categories;

	public function indexAction()
    {
    	// get category param
    	$categoryParam = $this->params()->fromRoute('cat');
    	// get short listing for this category
    	$categoryParam = ($categoryParam) ? $categoryParam : $this->categories[array_rand($this->categories)];
    	
    	/**
        * Task: The caching is not part of the core logic.
        *         Create a page caching solution that caches the complete HTML when 
        *         this page is requested /market/view[/:category]
        */
        $cache = $this->serviceLocator->get('cache');
        $cacheKey  = 'CAT_' . $categoryParam;
    	$shortList = $cache->getItem($cacheKey);
    	if(!$shortList) {
    	    $resultSet = $this->listingsTable->getListingsByCategory($categoryParam);
    	    $shortList = $resultSet->toArray();
    	    $cache->setItem($cacheKey, $shortList);
    	}
    
        return new ViewModel(array('shortList' 		=> $shortList,
        						   'categoryParam' 	=> $categoryParam));
    }

    public function itemAction()
    {
    	// get listings ID param
    	$id = (int) $this->params()->fromRoute('id');
    	$item = $this->listingsTable->getListingById($id);
        return new ViewModel(array('categories' => $this->categories,
        						   'item' => $item));
    }

    // called by ViewControllerFactory
    public function setCategories($categories)
    {
    	$this->categories = $categories;
    }
}
