<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/note.php';
 
// instantiate database and note object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$note = new Note($db);
 
// query notes
$stmt = $note->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // notes array
    $notes_arr=array();
    $notes_arr["records"]=array();
 
    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $note_item=array(
            "id" => $id,
            "name" => $name,
            "text" => html_entity_decode($text),
            "category_id" => $category_id,
            "category_name" => $category_name
        );
 
        array_push($notes_arr["records"], $note_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show notes data in json format
    echo json_encode($notes_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no notes found
    echo json_encode(
        array("message" => "No notes found.")
    );
}

?>