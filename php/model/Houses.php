<?php
class House{
    public $database_connection;
    private $table = 'houses';

    /**
     * Constructor taking db as params
     */
    public function __construct($a_database_connection)
    {
        $this->database_connection = $a_database_connection;
    }
}

?>