<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Content-Control-Allow-Methods: POST');
header('Content-Control-Allow-Headers: Content-Control-Allow-Methods, Content-Type, Content-Control-Allow-Headers, Authorization, X-Requested-With');

// Resources
include_once '../../config/Database.php';
include_once '../../model/Agents.php';

// Instantiate Database to get a connection
$database_connection = new Database();
$a_database_connection = $database_connection->connect();

// Instantiate green homes clients object
$agent = new Agents($a_database_connection);

// get data
$data = json_decode(file_get_contents('php://input'));

if (isset($data->password, $data->phonenumber, $data->email)
    &&
    !empty($data->password)
    &&
    !empty($data->phonenumber)
    &&
    !empty($data->email) 
) { // if good data was provided
    // Create the agent [details]
    $result = $agent->createAgent($data->password, $data->phonenumber, $data->email);
    if ($result) { 
        echo json_encode(
            array(
                'message' => 'House agent created',
                'response' => 'OK',
                'response_code' => http_response_code()
            )
        );
    } else {
        echo json_encode(
            array(
                'message' => 'Could not create house agent',
                'response' => 'NOT OK',
                'response_code' => http_response_code()
            )
        );
    }
} else { // if bad or empty data was provided
    echo json_encode(
        array(
            'message' => 'Bad data provided',
            'response' => 'NOT OK',
            'response_code' => http_response_code()
        )
    );
}

?>
