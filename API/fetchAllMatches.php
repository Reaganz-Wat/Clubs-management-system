<?php

// include the functions php file
include "../cmsfunctions.php";

$results = fetchAllMatches();

echo json_encode($results);

?>