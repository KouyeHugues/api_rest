<?php
//Headers required

//Access of data from any engine (*)
header("Access-Control-Allow-Origin:*");

//Format of data that will be sent
header("Content-Type: Application/json; charset=UTF-8");

//Authorized method
header("Access-Control-Allow-Methods: POST");

//duration of the request 
header("Access-Control-Allow-Age: 3600");

//header authorored
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-Width");

//-------------------------------------//
//Now we are going to verify that the method used is correct

if($_SERVER["REQUEST_METHOD"]== "POST")
{
    //We include the configuration  files
    require_once "../config/Database.php";
    require_once "../models/Section.php";

    //we initiate now the database
    $database = new Database();
    $db = $database->getConnection();

    //we initiate the section
    $section = new Section($db);

    $data = json_decode(file_get_contents("Php://input"));

    //we now verify that the id exist 
    if(!empty($data->domain) && !empty($data->length) && !empty($data->width))
    {
        $section->domain = $data->domain;
        $section->length = $data->length;
        $section->width = $data->width;

        if($section->create())
        {
            //success
           http_response_code(201);
           echo json_encode(array("message" => "La section a été bien ajouté"))

        }
        else
        {
             //503 error
            http_response_code(503);
        
            echo json_encode(array("message" => "L'ajout n'a pas été fait"));
        }
    }
}
else
{
    //if the method used isn't correct we will sent a message error
    http_response_code(405);
    echo json_encode(["message" => "The method used isn't correct"]);
}