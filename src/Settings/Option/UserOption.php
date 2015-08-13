<?php

namespace Settings\Option;
use Zend\Stdlib\AbstractOptions;

class UserOption extends AbstractOptions
{
    protected $user_creation_limit = 0;

    public function setUserCreationLimit($limit)
    {
        $this->user_creation_limit = $limit;
        return $this;
    }

    public function getUserCreationLimit()
    {
        return $this->user_creation_limit;
    }
}
