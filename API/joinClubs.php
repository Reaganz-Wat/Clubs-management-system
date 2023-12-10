<?php

// include the functions php file
include "../cmsfunctions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(
        isset($_POST['clubID']) && isset($_POST['studentID'])
    ){

        $clubID = $_POST['clubID'];
        $StudentID = $_POST['studentID'];

        joinClubs($ClubID, $StudentID);

        }
        else {
            echo "Required fields are missing";
        }
}

?>