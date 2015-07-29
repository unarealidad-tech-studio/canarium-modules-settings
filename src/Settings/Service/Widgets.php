<?php

namespace Settings\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Widgets implements ServiceLocatorAwareInterface
{

    public function getWidgets()
    {
        $sc = new \Zend\Code\Scanner\DirectoryScanner();
        $sc->addDirectory(__DIR__.'/../../../../../');
        $widgets = array();

        foreach ($sc->getClasses(true) as $classScanner) {
            $classname = $classScanner->getName();
            if (class_exists($classname)) {
                $reflection = new \ReflectionClass($classname);
                if ($reflection->implementsInterface('Settings\Widget\CanariumWidgetInterface')) {
                    $widgets[] = new $classname($this->getServiceLocator());
                }
            }
        }
        return $widgets;
    }

    public function saveConfigs($active_widgets)
    {
        $config_script = '<?php '.PHP_EOL;
        $config_script.= '  return array('.PHP_EOL;
        $config_script.= '      \'widgets\' => array('.PHP_EOL;
        $config_script.= '          \'inactive_widgets\' => array('.PHP_EOL;
        $widgets = $this->getWidgets();
        foreach ($widgets as $widget) {
            if (!in_array(get_class($widget), $active_widgets)) {
                $config_script.= '              \''.get_class($widget).'\', '.PHP_EOL;
            }
        }

        $config_script.= '          )'.PHP_EOL;
        $config_script.= '      )'.PHP_EOL;
        $config_script.= '  );'.PHP_EOL;
        
        $fp = fopen($this->getConfigFile(), 'w');
        fwrite($fp, $config_script);
        fclose($fp);
    }

    public function getConfigFile()
    {
        global $instance_name;
        return getcwd().'/instances/'.$instance_name.'/config/autoload/widgets.local.php';
    }

    /**
     * Retrieve service manager instance
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * Set service manager instance
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return User
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

}
