<?php

// include the functions php file
include "../cmsfunctions.php";

$results = fetchAllClubs();

// reverse the array so that the newly created items shows first
$reverse_results = array_reverse($results);


echo json_encode($reverse_results);

?>