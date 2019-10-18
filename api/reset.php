<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include data
$json = file_get_contents("../data/data.json");
$backup = file_get_contents("../data/backup.json");
$existingData = json_decode($json, true);
$incomingData = json_decode(file_get_contents("php://input"));

// change value
if (isset($incomingData->value)) {
    if ($incomingData->value == 'true') {
        file_put_contents('../data/data.json', $backup);
    }
}
?>