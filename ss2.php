<?php
error_reporting(E_ERROR | E_PARSE);
include("ExtractResults.php");


$csv = ['SS2 CISCO 2nd CA(Type1).csv','SS2 CISCO 2nd CA(Type2).csv'];
$extract = (new Extract("ss2",$csv));
$load1 = $extract->loadCSV();

$load = $extract->combine([$load1]);
$save = $extract->save("ss2-ca2",$load);
echo "<pre>";
    print_r($save);
echo "<pre>";



?>