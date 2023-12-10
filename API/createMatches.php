<?php
include '../cmsfunctions.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (
		isset($_POST['teamID']) && 
		isset($_POST['team2']) && 
		isset($_POST['date'])
	) {
		
		$teamID = $_POST['teamID'];
		$opponent = $_POST['team2'];
		$date = $_POST['date'];

		createMatches($teamID, $opponent, $date);

	} else {
		echo "Invalid entry";
	}
}

?>