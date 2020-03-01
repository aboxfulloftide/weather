<?php

#https://api.openweathermap.org/data/2.5/forecast?lat=42.148789&lon=-83.216602&appid=132a3bee3599ca1072f6a8161def0488&units=imperial


include_once("../core/connection.php");

$zip        = '48183';
$app_id     = '132a3bee3599ca1072f6a8161def0488';

//$json = file_get_contents("https://api.openweathermap.org/data/2.5/weather?zip=$zip,us&appid=$app_id");
$json = file_get_contents("https://api.openweathermap.org/data/2.5/forecast?zip=$zip,us&appid=$app_id");
$obj = json_decode($json,true);
//var_dump($obj);
$count_results  = $obj['cnt'];
$current_result = 0;
while ($current_result<$count_results) {
    $temp = isset($obj['list']["$current_result"]['main']['temp']) ? $obj['list']["$current_result"]['main']['temp'] : '0'; //k
    $temp_feel = isset($obj['list']["$current_result"]['main']['feels_like']) ? $obj['list']["$current_result"]['main']['feels_like'] : '0'; //k
    $temp_min = isset($obj['list']["$current_result"]['main']['temp_min']) ? $obj['list']["$current_result"]['main']['temp_min'] : '0'; //k
    $temp_max = isset($obj['list']["$current_result"]['main']['temp_max']) ? $obj['list']["$current_result"]['main']['temp_max'] : '0'; //k
    $humidity = isset($obj['list']["$current_result"]['main']['humidity']) ? $obj['list']["$current_result"]['main']['humidity'] : '0'; //%
    $forecast_dt = isset($obj['list']["$current_result"]['dt']) ? $obj['list']["$current_result"]['dt'] : '0'; //Atmospheric pressure (on the sea level, if there is no sea_level or grnd_level data), hPa
    $wind = isset($obj['list']["$current_result"]['wind']['speed']) ? $obj['list']["$current_result"]['wind']['speed'] : '0';//in m/s
    $wind_dir = isset($obj['list']["$current_result"]['wind']['deg']) ? $obj['list']["$current_result"]['wind']['deg'] : '0';//degrees (meteorological)
    $cloud_cov = isset($obj['list']["$current_result"]['clouds']['all']) ? $obj['list']["$current_result"]['clouds']['all'] : '0'; //percent cloud cover
    $weather_id = isset($obj['list']["$current_result"]['weather']['0']['id']) ? $obj['list']["$current_result"]['weather']['0']['id'] : '0'; //weather id
    $weather_main = isset($obj['list']["$current_result"]['weather']['0']['main']) ? $obj['list']["$current_result"]['weather']['0']['main'] : '0'; //weather main
    $weather_desc = isset($obj['list']["$current_result"]['weather']['0']['description']) ? $obj['list']["$current_result"]['weather']['0']['description'] : '0'; //weather desc

    $insert = "INSERT INTO weather.forecast (
  forecast_dt,
  temp,
  temp_feel,
  temp_min,
  temp_max,
  humidity,
  wind_speed,
  wind_dir,
  cloud_cover,
  weather_id,
  weather_main,
  weather_desc
)
VALUES
  (
    '$forecast_dt',
    '$temp',
    '$temp_feel',
    '$temp_min',
    '$temp_max',
    '$humidity',
    '$wind',
    '$wind_dir',
    '$cloud_cov',
    '$weather_id',
    '$weather_main',
    '$weather_desc'
  )";
//echo $insert . "\n";
    $db->query($insert);
    $current_result++;
}
echo "Data inserted";
?>