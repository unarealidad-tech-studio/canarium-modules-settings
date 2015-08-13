<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Settings\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Doctrine\ORM\Tools\Pagination\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator as ZendPaginator;

class UserController extends AbstractActionController
{
    protected $userForm;

    public function indexAction()
	{
		$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$users = $objectManager->getRepository('CanariumCore\Entity\User')->findAll();

		$view = new ViewModel();
		$view->users = $users;
		return $view;
    }

    public function createAction()
    {
        return array();
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $em = $this->serviceLocator->get('Doctrine\ORM\EntityManager');;
        $user = $em->getRepository('CanariumCore\Entity\User')->find($id);

        if (!$user) {
            return $this->redirect()->toRoute('admin/settings-user');
        }

        if ($this->getRequest()->isPost()) {
            $service = $this->getServiceLocator()->get('canariumcore_user_service');
            $service->removeUser($user);
            return $this->redirect()->toRoute('admin/settings-user');
        }

        return array(
            'user' => $user
        );
    }

    public function editAction()
    {
        return array();
    }

    public function settingsAction()
    {
        $form = new \Settings\Form\SettingsForm();
        $data = $this->getServiceLocator()->get('canariumsettings_user_options')->toArray();
        $form->setData($data);

        $service = $this->getServiceLocator()->get('settings_settings_service');

        if ($this->getRequest()->isPost()) {
            $this->flashMessenger()->addSuccessMessage('Configurations has been updated');
            $service->writeUserConfiguration($this->getRequest()->getPost());
            return $this->redirect()->toRoute('admin/settings-user', array('action'=>'settings'));
        }

        return array(
            'form' => $form,
        );
    }
}
