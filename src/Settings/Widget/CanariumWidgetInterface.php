<?php 

namespace Settings\Widget;

interface CanariumWidgetInterface
{
	public function __construct(\Zend\ServiceManager\ServiceManager $serviceLocator);
	public function getView();
}