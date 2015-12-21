<?php

namespace KarolNet\IPressoApiBundle\IPressoIntegration;


use KarolNet\Model\IPressoContactInterface;

interface IPressoApiInterface
{
    /**
     * @return string
     */
    public function accessToken();

    /**
     * @param string $email
     * @param string $token
     * @return IPressoContactInterface
     */
    public function findContact($email, $token);

    /**
     * @param IPressoContactInterface $contact
     * @param string $token
     * @return boolean
     */
    public function addContact(IPressoContactInterface $contact, $token);

    /**
     * @param int $contactId
     * @param IPressoContactInterface $contact
     * @param string $token
     * @return boolean
     */
    public function updateContact($contactId, IPressoContactInterface $contact, $token);
}