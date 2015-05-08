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

    public function indexAction()
	{
		$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$users = $objectManager->getRepository('CanariumCore\Entity\User')->findAll();

		$view = new ViewModel();
		$view->users = $users;
		return $view;
    }

}
