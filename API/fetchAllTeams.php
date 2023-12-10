<?php

// include the functions php file
include "../cmsfunctions.php";

$results = fetchTeams();

echo json_encode($results);

?>