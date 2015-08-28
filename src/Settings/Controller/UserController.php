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
    protected $userService;

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
        $form = $this->getUserForm();
        $this->getUserService()->setRegisterForm($form);
        $currentUser = $this->zfcUserAuthentication()->getIdentity();

        $service = $this->getUserService();

        // get the highest role
        $currentUserRole = $this->getServiceLocator()
                                ->get('canariumcore_user_service')
                                ->getHighestRole($currentUser);

        if ($this->getRequest()->getQuery('error')) {
            $this->flashMessenger()->addErrorMessage($this->getRequest()->getQuery('error'));
            return $this->redirect()->toRoute('admin/settings-user', array('action'=>'create'));
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $user = $service->register((array) $data);

            // delete any existing roles added from  register.post event
            // add new roles selected
            if ($user) {
                $defaultRoles = $user->getRoles(false);
                $user->removeRole($defaultRoles);
                $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

                foreach ($data['role'] as $roleId) {
                    $role = $objectManager->getRepository('CanariumCore\Entity\Role')->find($roleId);
                    $user->addRole($role);
                }

                $objectManager->flush();
                return $this->redirect()->toRoute('admin/settings-user');
            }
        }

        return array(
            'form'        => $form,
            'currentUserRole' => $currentUserRole,
        );
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
        $userId         = $this->params()->fromRoute('id', 0);
        $objectManager  = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $user           = $objectManager->getRepository('CanariumCore\Entity\User')->find($userId);
        $service        = $this->getServiceLocator()->get('canariumcore_user_service');
        $form           = $this->getUserForm();
        $currentUser    = $this->zfcUserAuthentication()->getIdentity();

        // get the highest role
        $currentUserRole = $this->getServiceLocator()
                                ->get('canariumcore_user_service')
                                ->getHighestRole($currentUser);

        if (!$user) {
            return $this->redirect()->toRoute('admin/settings-user', array('action'=>'index'));
        }

        if ($this->getRequest()->isPost()) {
            $data    = $this->getRequest()->getPost();
            if ($service->updateUser($user, (array) $data)) {
                $this->flashMessenger()->addSuccessMessage('User has been updated successfully');
                return $this->redirect()->toRoute('admin/settings-user', array('action'=>'edit', 'id' => $userId));
            }
        } else {
            $form->bind($user);
        }

        $userRoles = array();

        foreach ($user->getRoles() as $role) {
            $userRoles[] = $role;
        }

        $form->get('role')->setValue($userRoles);

        return array(
            'form' => $form,
            'user' => $user,
            'currentUserRole' => $currentUserRole,
        );
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

    public function getUserService()
    {
        if (!$this->userService)
            $this->userService = $this->getServiceLocator()->get('zfcuser_user_service');
        return $this->userService;
    }

    public function getUserForm()
    {
        if (!$this->userForm) {
            $this->userForm = $this->getServiceLocator()->get('canariumcore_user_form');
        }
        return $this->userForm;
    }

}
