<?php

use Config\Database;
use App\models\Section;

//Headers required

//Access of data from any engine (*)

header("Access-Control-Allow-Origin:*");

//Format of data that will be sent
header("Content-Type: Application/json; charset=UTF-8");

//Authorized method
header("Access-Control-Allow-Methods: GET");

//duration of the request 
header("Access-Control-Allow-Age: 3600");

//header authorored
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-Width");

//-------------------------------------//
//Now we are going to verify that the method used is correct

if($_SERVER["REQUEST_METHOD"]== "GET")
{   
    //We include the configuration  files
    
    //we initiate now the database
    $database = new Database();
    $db = $database->getConnection();

    //we initiate the section
    $section = new Section($db);

    //now we will get back the datas
    $data = $section->read();

    //we now verify that there is at least 1 section 
    if($data->rowCount() >0)
    {
        //we will initiate a associative array
        $sectionArray =[];
        $sectionArray["sections"] = [];

        while($sectionrow = $data->fetch(PDO::FETCH_ASSOC))
        {
            extract($sectionrow);

            $sect =[
                "id" => $id,
                "domain" => $domain,
                "length" => $length,
                "width" => $width,
                "addedAt" => $addedAt
            ];

            $sectionArray["sections"][] = $sect;

        }
        //we sent response code 200 OK
        http_response_code(200);
        
        //We now encode json
        echo json_encode($sectionArray);
    }
}
else
{
    //if the method used isn't correct we will sent a message error
    http_response_code(405);
    echo json_encode(["message" => "The method used isn't correct"]);
}