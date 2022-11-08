<?php
error_reporting(E_ERROR | E_PARSE);
include("ExtractResults.php");


$csv = ['SS3 CISCO 2nd CA.csv'];
$extract = (new Extract("ss3",$csv));
$load1 = $extract->loadCSV();
unset($load1["arms"]['H']);

$load = $extract->combine([$load1]);
$save = $extract->save("ss3-ca2",$load);
echo "<pre>";
    print_r($save);
echo "<pre>";



?>