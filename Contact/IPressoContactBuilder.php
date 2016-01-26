<?php

namespace KarolNet\IPressoApiBundle\Contact;


class IPressoContactBuilder
{
    public function build(array $data)
    {
        $contact = new IPressoContact(
            $data['lname'],
            $data['name'],
            $data['email'],
            $data['mobile']
        );
        foreach ($data as $key=>$row) {
            $contact->$key = $row;
        }

        return $contact;
    }
}