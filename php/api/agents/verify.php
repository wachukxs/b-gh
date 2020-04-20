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

// get data
$data = json_decode(file_get_contents('php://input'));

if (isset($data->password, $data->email)
    &&
    !empty($data->password)
    &&
    !empty($data->email) 
) { // if good data was provided
    // Verify the agent [details]
    $result = $agent->verifyAgent($data->password, $data->email);
    if ($result) { 
        echo json_encode(
            array(
                'message' => 'Verified returned true',
                'response' => 'OK',
                'response_code' => http_response_code()
            )
        );
    } else {
        echo json_encode(
            array(
                'message' => 'Verification returned false',
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