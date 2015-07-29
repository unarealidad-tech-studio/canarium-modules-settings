<?php
namespace Settings\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;

class RenderWidgets extends AbstractHelper
{
	protected $serviceLocator;

	public function __construct(\Zend\ServiceManager\ServiceManager $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
	}

    public function __invoke()
    {
        $service = $this->getServiceLocator()->get('settings_widgets_service');
        $widgetObjects = $service->getWidgets();

        $options = $this->getServiceLocator()->get('canariumsettings_widget_options');
        $inactiveWidgets = $options->getInactiveWidgets();

        foreach ($widgetObjects as $widgetObject) {
            if (!in_array(get_class($widgetObject), $inactiveWidgets)) {
                $widgets[get_class($widgetObject)] = $this->getView()->render( $widgetObject->getView() );
            }
        }

    	$view = new ViewModel(array(
            'widgets' => $widgets,
        ));

        $view->setTemplate('settings/admin/widget/render');
        echo  $this->getView()->render($view);
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}