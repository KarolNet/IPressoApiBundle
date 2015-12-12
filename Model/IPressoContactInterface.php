<?php

namespace KarolNet\Model;


interface IPressoContactInterface
{
    /**
     * @param string $externalId
     */
    public function setExternalId($externalId);

    /**
     * @return string
     */
    public function getExternalId();

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName);
    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param string $lastName
     */
    public function setLastName($lastName);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getAlternativeEmail();

    /**
     * @param string $alternativeEmail
     */
    public function setAlternativeEmail($alternativeEmail);

    /**
     * @return string
     */
    public function getName();
    /**
     * @param string $name
     */
    public function setName($name);
    /**
     * @return string
     */
    public function getWebAddress();
    /**
     * @param string $webAddress
     */
    public function setWebAddress($webAddress);

    /**
     * @return string
     */
    public function getMobilePhoneNumber();

    /**
     * @param string $mobilePhoneNumber
     */
    public function setMobilePhoneNumber($mobilePhoneNumber);

    /**
     * @return string
     */
    public function getStationaryPhoneNumber();

    /**
     * @param string $stationaryPhoneNumber
     */
    public function setStationaryPhoneNumber($stationaryPhoneNumber);
}