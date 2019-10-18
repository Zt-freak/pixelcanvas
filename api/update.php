<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include data
$json = file_get_contents("../data/data.json");
$existingData = json_decode($json, true);
$incomingData = json_decode(file_get_contents("php://input"));

// change value
if (isset($incomingData->x) && isset($incomingData->y) && isset($incomingData->colour)) {
    if (strlen($incomingData->colour) == 7 && $incomingData->colour[0] == '#') {
        $existingData['grid'][$incomingData->y][$incomingData->x] = [$incomingData->colour];
        $newJson = json_encode($existingData);
        file_put_contents('../data/data.json', $newJson);
    }
}
?>