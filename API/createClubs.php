<?php

// include the functions php file
include "../cmsfunctions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(
        isset($_POST['club_name']) && isset($_POST['club_description']) && isset($_POST['creatorID'])){

        $club_name = $_POST['club_name'];
        $club_description = $_POST['club_description'];
        $creatorID = $_POST['creatorID'];

        createClubs($creatorID, $club_name, $club_description);

        }
        else {
            echo "Required fields are missing";
        }
}

// createClubs("Debating Club", "This is one of the most best clubs ever in the history of debating");

?>

