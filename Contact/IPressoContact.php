<?php

namespace KarolNet\IPressoApiBundle\Contact;

class IPressoContact implements IPressoContactInterface
{
    public $type;

    /** @var  string */
    public $lname;

    /** @var  string */
    public $name;

    /** @var  string */
    public $email;

    /** @var  string */
    public $mobile;

    /** @var  string */
    public $phone;

    /** @var  string */
    public $company;

    /** @var  string */
    public $city;

    /** @var  string */
    public $postalCode;

    /** @var  string */
    public $street;

    /** @var  string */
    public $buildingNumber;

    /** @var  string */
    public $flatNumber;

    /** @var  string */
    public $country;

    /** @var  array */
    public $category;

    /** @var  array */
    public $tag;

    /** @var  array */
    public $agreement;

    public function __construct($lname, $name, $email, $mobile)
    {
        $this->lname = $lname;
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
    }

    /**
     * @return string
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * @param string $lname
     */
    public function setLname($lname)
    {
        $this->lname = $lname;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    public function offsetUnset($offset)
    {
        $this->$offset = null;
    }
}