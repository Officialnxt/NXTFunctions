<?php

function calculate($problem) {
	if($mathString == "pi"){
		return M_PI;
	}
	
	$problem = trim($problem);
	$problem = ereg_replace ('[^0-9\+-\*\/\(\)]', '', $problem;
	$compute = create_function("", "return (" . $problem . ");" );
	return 0 + $compute();

}

// Metric: Meters

function meterstofeet($meters, $echo = true){
	$m = $meters;
	$InFeet = $m*3.2808399;
	$Feet = (int)$InFeet;
	$Inches = round(($InFeet-$Feet)*12);
	$data = $Feet." ".$Inches;
	if($echo == true)
	{
		echo $data;
	} else {
		return $data;
	}
}

function meterstoinches($meters, $echo = true){
	$m = $meters;
	$Inches = $m*39.3701;
	$data = $Inches;
	if($echo == true)
	{
		echo $data;
	} else {
		return $data;
	}
}

function meterstoyards($meters, $echo = true){
	$m = $meters;
	$Yards = $m*1.09361;
	$data = $Yards;
	if($echo == true)
	{
		echo $data;
	} else {
		return $data;
	}
}


function meterstocentimeters($meters, $echo = true){
	$m = $meters;
	$Centi = $m*100;
	$data = $Centi;
	if($echo == true)
	{
		echo $data;
	} else {
		return $data;
	}
}

function meterstomiliimeters($meters, $echo = true){
	$m = $meters;
	$Mili = $m*1000;
	$data = $Mili;
	if($echo == true)
	{
		echo $data;
	} else {
		return $data;
	}
}

function meterstodecimeters($meters, $echo = true){
	$m = $meters;
	$Deci = $m*10;
	$data = $Deci;
	if($echo == true)
	{
		echo $data;
	} else {
		return $data;
	}
}

function meterstodekameters($meters, $echo = true){
	$m = $meters;
	$Deka = $m*0.1;
	$data = $Deka;
	if($echo == true)
	{
		echo $data;
	} else {
		return $data;
	}
}

function meterstohectometers($meters, $echo = true){
	$m = $meters;
	$Hecto = $m*0.01;
	$data = $Hecto;
	if($echo == true)
	{
		echo $data;
	} else {
		return $data;
	}
}

function meterstokilometers($meters, $echo = true){
	$m = $meters;
	$Kilo = $m*0.1;
	$data = $Kilo;
	if($echo == true)
	{
		echo $data;
	} else {
		return $data;
	}
}

//Metric: Grams

function gramstopounds($grams, $echo = true){
	$g = $grams;
	$pounds = $m*0.00220462;
	$data = $pounds;
	if($echo == true)
	{
		echo $data;
	} else {
		return $data;
	}
}

function gramstoounce($grams, $echo = true){
	$g = $grams;
	$pounds = $m*0.035274;
	$data = $pounds;
	if($echo == true)
	{
		echo $data;
	} else {
		return $data;
	}
}
?>
