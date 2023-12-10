<?php

// include the functions php file
include "../cmsfunctions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if( isset($_POST['id']) &&
        isset($_POST['username']) &&
        isset($_POST['firstname']) &&
        isset($_POST['lastname']) &&
        isset($_POST['contactnumber']) && 
        isset($_POST['email'])
        ){
        $studentID = $_POST['id'];
        $username = $_POST['username'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $contactNumber = $_POST['contactnumber'];


        editTeacher($studentID, $username, $firstname, $lastname, $email, $contactNumber);

        }
        else {
            echo "Required fields are missing";
        }
}


// editTeacher(2, "Simpsons", "Samson", "Keira", "keirasamsom@gmail.com", "+256741612094");

?>