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
use Zend\View\Model\JsonModel;

use Doctrine\ORM\Tools\Pagination\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator as ZendPaginator;

class AdminController extends AbstractActionController
{

	public function indexAction()
	{
	}

	public function widgetsAction()
	{
		$service = $this->getServiceLocator()->get('settings_widgets_service');
		$widgets = $service->getWidgets();

		$options = $this->getServiceLocator()->get('canariumsettings_widget_options');
		$inactiveWidgets = $options->getInactiveWidgets();

		if ($this->getRequest()->isPost()) {
			$post = $this->getRequest()->getPost();
			if (!is_writable($service->getConfigFile())) {
				return new JsonModel(array(
					'error' => 'Config file is not writable.'
				));
			}
			$service->saveConfigs($post['widget']);
			return new JsonModel(array(
				'success' => 1
			));
		}

		return array(
			'widgets' => $widgets,
			'inactiveWidgets' => $inactiveWidgets,
		);
	}
}
