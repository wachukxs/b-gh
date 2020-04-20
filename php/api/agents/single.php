<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Resources
include_once '../../config/Database.php';
include_once '../../model/Agents.php';

// Instantiate Database to get a connection
$database_connection = new Database();
$a_database_connection = $database_connection->connect();

// Instantiate green homes agents object
$agent = new Agents($a_database_connection);

// Get ID [& set agent id if id available]
$agent_id = isset($_GET['id']) ? $_GET['id'] : die(); // die? or appropriate msg

// Get the agent [details]
$result = $agent->getSingleAgentByID($agent_id);

// Get total number
$total_number = $result->rowCount();

$agent_details_arr = array();

if ($total_number > 0) {
    $agent_details_arr['message'] = 'good request, no errors';  
    $agent_details_arr['response_code'] = http_response_code(200);

    // returns an array, $row is an array
    $row = $result->fetch(PDO::FETCH_ASSOC);

    extract($row);

    // Create array
    $agent_details_arr['data'] = array(
        'id' => $id,
        'email' => $email,
        'phone_number_1' => $phone_number_1,
    );
} else {
    $agent_details_arr['message'] = 'bad request, errors';
    $agent_details_arr['response_code'] = http_response_code();
}


// Make json and output
print_r(json_encode($agent_details_arr));
