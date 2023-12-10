<?php

// include the functions php file
include "../cmsfunctions.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
        $response = loginAdmin($username);
        echo json_encode($response);
    }
}

?>