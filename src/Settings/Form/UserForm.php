<?php

namespace Settings\Form
use Zend\Form\Form;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class UserForm extends Form
{
    public function __construct($objectManager = null)
    {
    }
}