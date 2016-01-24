<?php

namespace KarolNet\IPressoApiBundle\Contact;

interface IPressoContactInterface extends \ArrayAccess
{
    /** @return string */
    public function getLname();

    /** @return string */
    public function getName();

    /** @return string */
    public function getEmail();

    /** @return string */
    public function getMobile();
}