<?php
namespace Settings\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\Form\Form;

class SettingsForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('user-settings-form');

        $this->add(array(
            'name' => 'user_creation_limit',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
            )
        ));

        $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Save',
                 'class' => 'btn btn-lg btn-success btn-block',
             ),
        ));
    }
}