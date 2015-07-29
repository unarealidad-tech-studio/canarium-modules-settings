<?php

namespace Settings\Option;
use Zend\Stdlib\AbstractOptions;

class WidgetOption extends AbstractOptions
{
    protected $inactiveWidgets = array();

    public function __construct($options = null)
    {
        parent::__construct($options);
    }

    public function setInactiveWidgets(array $inactiveWidgets)
    {
        $this->inactiveWidgets = $inactiveWidgets;
        return $this;
    }

    public function getInactiveWidgets()
    {
        return $this->inactiveWidgets;
    }
}
