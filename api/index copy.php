<?php

// Define global constant to prevent direct script loading 
/* We define MY_APP which is makes every request go through MY_APP and then out to the other folders with files
    In every other file there is a IF statement that goes through the MY_APP. They cant be accessed directly 
    but through the index.php */
define('MY_APP', true);

// Load the router responsible for handling API requests
require_once __DIR__ . "/api/APIRouter.php";

// Get URL path 
// PATH is either how to get from the route of something to another file or how to get from where you are to another specfic file
$path = $_GET["path"]; //"customers/3/bookings" example
$path_parts = explode("/", $path); // ["customers" "3" "bookings"] -- It's component parts
$base_path = strtolower($path_parts[0]); //lowercase, but makes it OK to write with capital in postman

// If the URL path starts with "api", and have more then 1 path, load the API. Else page not found
// In postman if we write in just api it will say page not found. Becasue it's only one path. Instead api/customers/ 
if($base_path == "api" && count($path_parts) > 1){
    $query_params = $_GET; //Gets neccessary parameters 

    // Handle requests using the API router and start the presenatation layer
    $api = new APIRouter($path_parts, $query_params); //object which passes 2 parameters to the APIRouter
    $api->handleRequest(); 
}
else{ // If URL path is not API, or just API, respond with "not found"
    http_response_code(404);
    die("Page not found");
}
