<?php

// include the functions php file
include "../cmsfunctions.php";

$results = fetchSportsTeam();

echo json_encode($results);

?>