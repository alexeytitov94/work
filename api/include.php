<?php

function auth_b24($arUserfields)
{

    $_url = 'https://' . $arUserfields["portal"];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_url);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $res = curl_exec($ch);
    $l = '';
    if (preg_match('#Location: (.*)#', $res, $r)) {
        $l = trim($r[1]);
    }
    //echo $l.PHP_EOL;
    curl_setopt($ch, CURLOPT_URL, $l);
    $res = curl_exec($ch);
    preg_match('#name="backurl" value="(.*)"#', $res, $math);
    $post = http_build_query([
        'AUTH_FORM' => 'Y',
        'TYPE' => 'AUTH',
        'backurl' => $math[1],
        'USER_LOGIN' => $arUserfields["userlogin"],
        'USER_PASSWORD' => $arUserfields["userpass"],
        'USER_REMEMBER' => 'Y'
    ]);
    curl_setopt($ch, CURLOPT_URL, 'https://www.bitrix24.net/auth/');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $res = curl_exec($ch);
    $l = '';
    if (preg_match('#Location: (.*)#', $res, $r)) {
        $l = trim($r[1]);
    }
    //echo $l.PHP_EOL;
    curl_setopt($ch, CURLOPT_URL, $l);
    $res = curl_exec($ch);
    $l = '';
    if (preg_match('#Location: (.*)#', $res, $r)) {
        $l = trim($r[1]);
    }
    //echo $l.PHP_EOL;
    curl_setopt($ch, CURLOPT_URL, $l);
    $res = curl_exec($ch);
    //end autorize
    curl_setopt($ch, CURLOPT_URL, 'https://' . $arUserfields["portal"] . '/oauth/authorize/?response_type=code&client_id=' . $arUserfields["clientid"]);
    $res = curl_exec($ch);
    $l = '';
    if (preg_match('#Location: (.*)#', $res, $r)) {
        $l = trim($r[1]);
    }
    preg_match('/code=(.*)&do/', $l, $code);
    $code = $code[1];
    curl_setopt($ch, CURLOPT_URL, 'https://' . $arUserfields["portal"] . '/oauth/token/?grant_type=authorization_code&client_id=' . $arUserfields["clientid"] . '&client_secret=' . $arUserfields["clientsecret"] . '&code=' . $code . '&scope=' . $arUserfields["scope"]);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $res = curl_exec($ch);
    curl_close($ch);

    $jsonreturn = json_decode($res);

    $arResAuthServ = array();
    foreach ($jsonreturn as $key => $value) {
        $arResAuthServ[$key] = $value;
    }

    return $arResAuthServ;
}


/**
 * @param $Method   //метод REST Битрикс24
 * @param $Data     //данные передаваемы в метод
 * @return mixed    //результат работы метода
 */
function restquery($Method, $Data)
{
    $queryUrl = QUERY_URL . $Method;
    $queryData = http_build_query($Data);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryUrl,
        CURLOPT_POSTFIELDS => $queryData,
    ));

    $result = curl_exec($curl);
    curl_close($curl);

    $result = json_decode($result, 1);
    //writeToLog($result, 'webform result');
    return $result;
}


/**
 * Запись в лог.
 *
 * @param mixed $data
 * @param string $title
 *
 * @return bool
 */
function writeToLog($data, $title = '') {
    $log = "\n------------------------\n";
    $log .= date("Y.m.d G:i:s") . "\n";
    $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
    $log .= print_r($data, 1);
    $log .= "\n------------------------\n";
    file_put_contents(getcwd() . '/hook.log', $log, FILE_APPEND);
    return true;
}


function __autoload( $className ) {
    $className = str_replace( "..", "", $className );
    require_once( "classes/$className.php" );
}