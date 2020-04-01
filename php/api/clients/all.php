<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Resources
include_once '../../config/Database.php';
include_once '../../model/Clients.php';

// Instantiate Database to get a connection
$database_connection = new Database();
$a_database_connection = $database_connection->connect();

// Instantiate green homes clients object
$clients = new Clients($a_database_connection);

// green homes clients query
$results = $clients->getAllClients();

// Get total number
$total_number = $results->rowCount();

// Check the number of clients gotten
if ($total_number > 0) {
    $clients_array = array();
    $clients_array['response_code'] = http_response_code(200);
    $clients_array['message'] = 'good request, no errors';
    $clients_array["response"]= 'OK';
    $clients_array['data'] = array();
    
    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $a_client = array( // later add an object of states the client operates in
            'firstname' => $first_name,
            'lastname' => $last_name,
            'id' => $id,
            // 'phonenumbers' => $phone_numbers // will change to contact_id
        );

        // Push to data index
        array_push($clients_array['data'], $a_client);
    }

    // Turn to JSON & output
    echo json_encode($clients_array);
    
} else {
    // No client
    echo json_encode(
        array(
            'message' => 'No clients available',
            'response' => 'NOT OK',
            'response_code' => http_response_code()
        )
    );

}

?>
