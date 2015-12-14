<?php
require __DIR__.'/../vendor/autoload.php';
(new Dotenv\Dotenv(__DIR__.'/../'))->load();

if(isSet($_SERVER['REMOTE_ADDR']))
{
	$ipinfo = json_decode(file_get_contents('http://ipinfo.io/'.$_SERVER['REMOTE_ADDR']));
}
else
{
	$ipinfo = json_decode(file_get_contents('http://ipinfo.io'));
}

if($ipinfo === false)
{
	die('Could not get IP info'.PHP_EOL);
}

$owm = new Cmfcmf\OpenWeatherMap();

$weather = $owm->getWeather($ipinfo->postal.','.strToLower($ipinfo->country), 'en', 'imperial', getenv('OPENWEATHERMAP_API_KEY'));

$temp =  intval(str_replace(' kelvin',' ',$weather->temperature->now));

echo 'Temperature in '.$weather->city->name.': '.ceil($temp * (9/5) - 459.67).'°F';

echo PHP_EOL;

