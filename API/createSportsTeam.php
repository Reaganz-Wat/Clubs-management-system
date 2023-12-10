<?php
include '../cmsfunctions.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (
		isset($_POST['team_name']) && 
		isset($_POST['coach_id'])
	) {
		
		$teamName = $_POST['team_name'];
		$coachID = $_POST['coach_id'];

		createSportsTeam($teamName, $coachID);

	} else {
		echo "Invalid entry";
	}
}

?>