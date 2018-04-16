<?php

class Lead
{

    public function getLead($id)
    {
        $arParam = array(
            'id' => $id
        );

        $arGet = restquery('crm.lead.get.json', $arParam);

        return $arGet['result'];
    }
}