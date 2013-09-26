<?php

function maths($mathString) {
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
?>
