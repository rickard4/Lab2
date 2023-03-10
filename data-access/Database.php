<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

// Data access:
// Class for connecting to database

class Database
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "multitier_shop";

    protected $conn;

    // Connect to the database in the constructor so all member functions can use $this->conn
    public function __construct()
    {
        $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db);

        if (!$this->conn) {
            die("Error connection to db!");
        }
    }

    // Retrieves all rows from the specified 
    // table in the database and returns the result.
    protected function getAllRowsFromTable($table_name)
    {
        // Variables inside the query are OK when the variables are not user input.
        // Never use variables directly in queries when the variables value is user input.
        $query = "SELECT * FROM {$table_name}";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result;
    }

    // Retrieves one from the specified 
    // table in the database and returns the result.
    protected function getOneRowByIdFromTable($table_name, $id_name, $id)
    {
        // Variables inside the query are OK when the variables are not user input.
        // Never use variables directly in queries when the variables value is user input.
        $query = "SELECT * FROM {$table_name} WHERE {$id_name} = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result;
    }
}
