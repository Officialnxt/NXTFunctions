<?php

function calculate($mathString) {
	if($mathString == "pi"){
		return pi();
	}
	
	$mathString = trim($mathString);
	$mathString = ereg_replace ('[^0-9\+-\*\/\(\)]', '', $mathString);
	$compute = create_function("", "return (" . $mathString . ");" );
	return 0 + $compute();

}

function metersToFeet($meters, $echo = true){
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

function metersToInches($meters, $echo = true){
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

function metersToYards($meters, $echo = true){
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


function metersToCentimeters($meters, $echo = true){
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

function metersToMiliimeters($meters, $echo = true){
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

function metersToDecimeters($meters, $echo = true){
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

function metersToDekameters($meters, $echo = true){
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

function metersToHectometers($meters, $echo = true){
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

function metersToKilometers($meters, $echo = true){
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
?>
