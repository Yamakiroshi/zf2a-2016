<?php
namespace Market\Controller;

use Market\Form;
use Market\Model;
use Zend\Session;
use Zend\Validator\File;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\File\Transfer\Adapter\Http as FileTransfer;

class DeleteController extends AbstractActionController implements Model\ListingsTableAwareInterface
{

    use \Market\Model\ListingsTableAwareTrait;

    protected $listingsTable;
    protected $deleteForm;
    protected $deleteFormFilter;

    public function indexAction()
    {
        // get listings ID param
        $id = (int) $this->params()->fromRoute('id');
        // pull info from table
        $item = $this->listingsTable->getListingById($id);
        // if no results go home
        if (!$item) {
            $this->flashMessenger()->addMessage('Unable to delete this item');
            return $this->redirect()->toRoute('home');
        }
        // otherwise prepare form
        $this->deleteForm->prepareElements($id);
        // render view
        return new ViewModel(array('item'         => $item,
                                   'deleteForm' => $this->deleteForm,
                                   'id'            => $id));
    }

    public function deleteConfirmAction()
    {
        $deleted = FALSE;
        // retrieve $_POST data
        $data = $this->params()->fromPost();
        // check to see if submit button pressed
        if (isset($data['submit'])) {
            // prepare filters
            $this->deleteFormFilter->prepareFilters();
            $this->deleteFormFilter->setData($data);
            // validate data against the filter
            if ($this->deleteFormFilter->isValid($data)) {
                // get valid data
                $validData = $this->deleteFormFilter->getValues();
                // pull info from table
                $item = $this->listingsTable->getListingById($validData['id']);
                // check delete code
                if ($item && ($validData['delCode'] == $item->delete_code)) {
                    // delete item
                    if ($this->listingsTable->delete(array('listings_id' => $validData['id']))) {
                        // set flag
                        $deleted = TRUE;
                    }
                }
            }
        }
        // messages
        if ($deleted) {
            $this->flashMessenger()->addMessage('Item Successfully Deleted');
            /**
             * Task: The deletion of the cache is not part of the core logic. 
             * Move it to a better place on successful deletion.
             */
            // clear cache
            $em = $this->getEventManager();
            $em->trigger($this->getServiceLocator()->get('cache-event-clear'), $this);
            /*
            if($this->serviceLocator->has('cache')) {
                $cache = $this->serviceLocator->get('cache');
                $cache->cleanByTags(array('CAT_' . $item->category));
            }
            */
        } else {
            $this->flashMessenger()->addMessage('Sorry! Unable to Delete Item.');
        }
        return $this->redirect()->toRoute('home');
    }

    // called by DeleteControllerFactory
    public function setDeleteForm(Form\DeleteForm $form)
    {
        $this->deleteForm = $form;
    }

    // called by DeleteControllerFactory
    public function setDeleteFormFilter(Form\DeleteFormFilter $filter)
    {
        $this->deleteFormFilter = $filter;
    }

}
