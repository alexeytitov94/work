<?php

header("Content-Type: text/html; charset=utf-8");

const INPUT_KEY = ''; //ID входящего хука
const URL_PORTAL = 'https://   .bitrix24.ru'; //адрес портала
const QUERY_URL = URL_PORTAL.'/rest/1/'.INPUT_KEY.'/'; //строка адреса для запросов

require __DIR__.'/bitrix_include.php';


