<?php

// include the functions php file
include "../cmsfunctions.php";

$results = fetchAllStudents();

echo json_encode($results);

?>