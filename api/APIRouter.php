<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

// Load the router responsible for UsersAPI.php and AppsAPI.php 
require_once __DIR__ . "/AppsAPI.php";
require_once __DIR__ . "/UsersAPI.php";



// Class for routing all our API requests

class APIRouter{

    private $path_parts, $query_params;
    private $routes = [];

    public function __construct($path_parts, $query_params)
    {
        // Available routes
        // Add to this if you need to add any route to the API
        $this->routes = [
            // Whenever someone calls "api/Apps" and "api/Users" we 
            // will load the AppsAPI and UsersAPI class
            "apps" => "AppsAPI"
            "users" => "UsersAPI"
        ];

        $this->path_parts = $path_parts;
        $this->query_params = $query_params;
    }

    public function handleRequest(){

        // Get the requested resource from the URL such as "Apps/Users" or "Products"
        $resource = strtolower($this->path_parts[1]); //gets the 2nd one which is apps/users. It starts on 0 on array.

        // Cet the class specified in the routes
        $route_class = $this->routes[$resource];

        // Create a new object from the resource class
        $route_object = new $route_class($this->path_parts, $this->query_params);

        // Handle the request
        $route_object->handleRequest();
    }
}