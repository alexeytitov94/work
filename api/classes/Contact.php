<?php

class Contact
{

    public function getContact($id)
    {
        $arParam = array(
            'id' => $id
        );

        $arGet = restquery('crm.contact.get.json', $arParam);

        return $arGet['result'];
    }
}