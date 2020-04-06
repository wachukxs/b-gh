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
$client = new Clients($a_database_connection);

// Get ID [& set client id if id available]
$client_id = isset($_GET['id']) ? $_GET['id'] : die(); // die? or appropriate msg

// Get the client [details]
$result = $client->getSingleClientByID($client_id);

// Get total number
$total_number = $result->rowCount();

$client_details_arr = array();

if ($total_number > 0) {
    $client_details_arr['message'] = 'good request, no errors';  
    $client_details_arr['response_code'] = http_response_code(200);

    // returns an array, $row is an array
    $row = $result->fetch(PDO::FETCH_ASSOC);

    extract($row);

    // Create array
    $client_details_arr['data'] = array(
        'id' => $id,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'phone_numbers' => $phone_numbers,
    );
} else {
    $client_details_arr['message'] = 'bad request, errors';
    $client_details_arr['response_code'] = http_response_code();
}


// Make json and output
print_r(json_encode($client_details_arr));
