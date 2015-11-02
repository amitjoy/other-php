<?php
include("Android.php");
$droid = new Android();
 
//creates alert
$droid->dialogCreateAlert();
 
$result = array();
 
//gets coordinates
$latitude = $droid->dialogGetInput("Location", "Latitude: ");
$longitude= $droid->dialogGetInput("Location", "Longitude: ");
 
//gets the location info
$locations = $droid->dialogGeocode($latitude['result'], $longitude['result']);
 
//parses location info
foreach ($locations['result'] as $location)
{
  $location = get_object_vars($location);
 
  //sets location items
  foreach ($location as $key => $value)
  {
    $result[] = ucfirst(str_replace('_', ' ', $key)).': '.$value;
  }
}
$droid->dialogSetItems($result);
 
//displays the box
$droid->dialogShow();