<?php

// include the functions php file
include "../cmsfunctions.php";

$results = fetchAllTeachers();

echo json_encode($results);

?>