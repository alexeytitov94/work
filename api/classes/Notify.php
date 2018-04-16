<?php

class Notify
{

    public function sendNotifySystem($to, $message)
    {
        $arParamNoti = array(
            'to' => $to,
            'message' => $message,
            'type' => 'SYSTEM'
        );

        restquery('im.notify', $arParamNoti);
    }

    public function sendNotifyUser($to, $message)
    {
        $arParamNoti = array(
            'to' => $to,
            'message' => $message,
            'type' => 'USER'
        );

        restquery('im.notify', $arParamNoti);
    }


}