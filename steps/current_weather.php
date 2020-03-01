<?php

#https://api.openweathermap.org/data/2.5/forecast?lat=42.148789&lon=-83.216602&appid=132a3bee3599ca1072f6a8161def0488&units=imperial


include_once("../core/connection.php");

$zip        = '48183';
$app_id     = '132a3bee3599ca1072f6a8161def0488';

$json = file_get_contents("https://api.openweathermap.org/data/2.5/weather?zip=$zip,us&appid=$app_id");
$obj = json_decode($json,true);
//var_dump($obj);
$temp       = isset($obj['main']['temp']) ? $obj['main']['temp'] : '0'; //k
$temp_feel  = isset($obj['main']['feels_like']) ? $obj['main']['feels_like'] : '0'; //k
$temp_min   = isset($obj['main']['temp_min']) ? $obj['main']['temp_min'] : '0'; //k
$temp_max   = isset($obj['main']['temp_max']) ? $obj['main']['temp_max'] : '0'; //k
$pressure   = isset($obj['main']['pressure']) ? $obj['main']['pressure'] : '0'; //Atmospheric pressure (on the sea level, if there is no sea_level or grnd_level data), hPa
$humidity   = isset($obj['main']['humidity']) ? $obj['main']['humidity'] : '0'; //%
$vis        = isset($obj['visibility']) ? $obj['visibility'] : '0';//in meters
$wind       = isset($obj['wind']['speed']) ? $obj['wind']['speed'] : '0';//in m/s
$wind_dir   = isset($obj['wind']['deg']) ? $obj['wind']['deg'] : '0';//degrees (meteorological)
$cloud_cov  = isset($obj['clouds']['all']) ? $obj['clouds']['all'] : '0'; //percent cloud cover
$sunrise    = isset($obj['sys']['sunrise']) ? $obj['sys']['sunrise'] : '0'; //utc
$sunset     = isset($obj['sys']['sunset']) ? $obj['sys']['sunset'] : '0'; //utc



$insert     = "INSERT INTO weather.current
(temp,feels_like,temp_min,temp_max,pressure,humidity,visibility,wind_speed,wind_dir,cloud_cover,sunrise,sunset)
VALUES
('$temp','$temp_feel','$temp_min','$temp_max','$pressure','$humidity','$vis','$wind','$wind_dir','$cloud_cov','$sunrise','$sunset')";
//echo $insert;
$db->query($insert);

echo "Data inserted\n";
?>