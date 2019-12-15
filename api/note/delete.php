<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/note.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare note object
$note = new Note($db);
 
// get note id
$data = json_decode(file_get_contents("php://input"));
 
// set note id to be deleted
$note->id = $data->id;
 
// delete the note
if($note->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Note was deleted."));
}
 
// if unable to delete the note
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to delete note."));
}
?>