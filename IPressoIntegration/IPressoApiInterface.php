<?php

namespace KarolNet\IPressoApiBundle\IPressoIntegration;


use KarolNet\IPressoApiBundle\Contact\IPressoContactInterface;

interface IPressoApiInterface
{
    /**
     * @return string
     */
    public function accessToken();

    /**
     * @param string $email
     * @param string $token
     * @return array
     */
    public function findContact($email, $token);

    /**kwinkwin
     *
     * @param IPressoContactInterface $contact
     * @param string $token
     * @return boolean
     */
    public function addContact(\ArrayAccess $contact, $token);

    /**
     * @param int $contactId
     * @param IPressoContactInterface $contact
     * @param string $token
     * @return boolean
     */
    public function updateContact($contactId, IPressoContactInterface $contact, $token);
}