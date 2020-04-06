<?php
class Clients {
    // DB stuff
    public $database_connection;
    private $table = 'clients';

    // Client properties
    /* public $first_name;
    public $last_name;
    public $last_seen;
    public $middle_name;
    public $id;
    public $phone_numbers; */

    /**
     * Constructor taking db as params
     */
    public function __construct($a_database_connection)
    {
        $this->database_connection = $a_database_connection;
    }

    // Get all clients
    public function getAllClients()
    {
        // Create query
        $query = 'SELECT * FROM ' . $this->table;
        
        // Prepare statement
        $query_statement = $this->database_connection->prepare($query);

        // Execute query statement
        $query_statement->execute();

        return $query_statement;
    }

    public function getSingleClientByID($id)
    {
        // Create query
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';

        // Prepare statement
        $query_statement = $this->database_connection->prepare($query);

        // Execute query statement
        $query_statement->bindParam(1, $id);

        // Execute query statement
        $query_statement->execute();

        return $query_statement;

    }

}