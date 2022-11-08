<?php
error_reporting(E_ERROR | E_PARSE);
include("ExtractResults.php");


$csv = ['SS1 CISCO 2nd CA(Type 1).csv','SS1 CISCO 2nd CA(Type 2).csv'];
$extract = (new Extract("ss1",$csv));
$load1 = $extract->loadCSV();

$load = $extract->combine([$load1]);
$save = $extract->save("ss1-ca2",$load);
echo "<pre>";
    print_r($save);
echo "<pre>";



?>