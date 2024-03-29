<?php

include_once('/var/www/domocan/www/conf/config.php');

mysql_connect(MYSQL_HOST, MYSQL_LOGIN, MYSQL_PWD);
mysql_select_db(MYSQL_DB);
$retour = mysql_query("SELECT `Fete` FROM `" . TABLE_METEO_FETE . "` WHERE `JourMois` = '" . date('d/m') . "'");
$row = mysql_fetch_array($retour);
mysql_close();

$location = $_GET['location'];
$metric = (int)$_GET['metric'];

$url = 'http://wwwa.accuweather.com/adcbin/forecastfox/weather_data.asp?location=' . $location . '&metric=' . $metric;
//$url = 'http://rainmeter.accu-weather.com/widget/rainmeter/weather-data.asp?location=' . $location . '&metric=' . $metric;

$ch = curl_init();
$timeout = 0;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$file_contents = curl_exec($ch);
curl_close($ch);

$xml = simplexml_load_string($file_contents);

$weather['city']            = (string)$xml->local->city;
$weather['curr_temp']       = (int)$xml->currentconditions->temperature;
$weather['curr_text']       = utf8_encode($row['Fete']);
$weather['curr_icon']       = (int)$xml->currentconditions->weathericon;

// forecast
//$day = count($xml->forecast->day);
$day = 5;
for ($i = 0; $i < $day; $i++) {
    $weather['forecast'][$i]['day_date']       = (string)$xml->forecast->day[$i]->obsdate;
    $weather['forecast'][$i]['day_text']       = (string)$xml->forecast->day[$i]->daytime->txtshort;

switch ($weather['forecast'][$i]['day_text']) {

  case 'Times of sun and clouds':
    $weather['forecast'][$i]['day_text'] = "Mélange de soleil et de nuages";
    break;

  case 'Cloudy':
    $weather['forecast'][$i]['day_text'] = "Nuageux";
    break;

  case 'Cloudy with a shower':
    $weather['forecast'][$i]['day_text'] = "Nuageux avec averses";
    break;

  case 'Cloudy with showers around':
    $weather['forecast'][$i]['day_text'] = "Nuageux avec averses rares";
    break;

  case 'Cloudy with a shower or two':
    $weather['forecast'][$i]['day_text'] = "Nuageux avec temps pluvieux";
    break;

  case 'Cloudy with brief showers':
    $weather['forecast'][$i]['day_text'] = "Nuageux avec averses brèves";
    break;


  default:
    break;

}


    $weather['forecast'][$i]['day_icon']       = (int)$xml->forecast->day[$i]->daytime->weathericon;
    $weather['forecast'][$i]['day_htemp']      = (int)$xml->forecast->day[$i]->daytime->hightemperature;
    $weather['forecast'][$i]['day_ltemp']      = (int)$xml->forecast->day[$i]->daytime->lowtemperature;
}

echo json_encode($weather);

?>
