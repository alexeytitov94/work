<?php

class Deal
{

    public function getDeal($id)
    {
        $arParam = array(
            'id' => $id
        );

        $arGet = restquery('crm.deal.get.json', $arParam);

        return $arGet['result'];
    }
}