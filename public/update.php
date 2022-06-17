<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://almacen3.lndo.site/api.php/10',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PUT',
  CURLOPT_POSTFIELDS =>'{
    "id":"10",
    "nombre":"Televisor",
    "sku":"120004",
    "marca":"Huawei",
    "costo":"5600"
}     ',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: text/plain',
    'Cookie: PHPSESSID=8e9605434369a4d5fed588685aecb320'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;