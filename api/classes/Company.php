<?php

class Company
{

    public function getCompany($id)
    {
        $arParam = array(
            'id' => $id
        );

        $arGet = restquery('crm.company.get.json', $arParam);

        return $arGet['result'];
    }
}