<?php

namespace KarolNet\Model;


class IPressoContact implements IPressoContactInterface
{
    /** @var  string */
    protected $externalId;

    /** @var  string */
    protected $firstName;

    /** @var  string */
    protected $lastName;

    /** @var  string */
    protected $email;

    /** @var  string */
    protected $alternativeEmail;

    /** @var  string */
    protected $name;

    /** @var  string */
    protected $webAddress;

    /** @var  string */
    protected $mobilePhoneNumber;

    /** @var  string */
    protected $stationaryPhoneNumber;

    /**
     * {@inheritdoc}
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * {@inheritdoc}
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * {@inheritdoc}
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlternativeEmail()
    {
        return $this->alternativeEmail;
    }

    /**
     * {@inheritdoc}
     */
    public function setAlternativeEmail($alternativeEmail)
    {
        $this->alternativeEmail = $alternativeEmail;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getWebAddress()
    {
        return $this->webAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function setWebAddress($webAddress)
    {
        $this->webAddress = $webAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function getMobilePhoneNumber()
    {
        return $this->mobilePhoneNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function setMobilePhoneNumber($mobilePhoneNumber)
    {
        $this->mobilePhoneNumber = $mobilePhoneNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function getStationaryPhoneNumber()
    {
        return $this->stationaryPhoneNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function setStationaryPhoneNumber($stationaryPhoneNumber)
    {
        $this->stationaryPhoneNumber = $stationaryPhoneNumber;
    }
}