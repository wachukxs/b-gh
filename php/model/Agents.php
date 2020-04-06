<?php
class Agents {
    // DB stuff
    public $database_connection;
    private $table = 'agents';

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

    // Create new client, an entry
    public function createAgent($password, $phonenumber, $email) {
        $query = 'INSERT INTO ' . $this->table . '
            SET
            phone_number_1 = :phonenumber,
            email = :email,
            password = :password
        ';

        $stmt = $this->database_connection->prepare($query);

        // Ensure safe data
        $pn = htmlspecialchars(strip_tags($phonenumber));
        $e = htmlspecialchars(strip_tags($email));
        $p = htmlspecialchars(strip_tags($password));

        // Bind parameters to prepared stmt
        $stmt->bindParam(':phonenumber', $pn);
        $stmt->bindParam(':email', $e);
        $stmt->bindParam(':password', $p);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}