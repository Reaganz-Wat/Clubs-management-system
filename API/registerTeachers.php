<?php

// include the functions php file
include "../cmsfunctions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(
        isset($_POST['username']) &&
        isset($_POST['firstname']) &&
        isset($_POST['lastname']) &&
        isset($_POST['password']) &&
        isset($_POST['contactnumber']) && 
        isset($_POST['email']) &&
        isset($_POST['usertype'])
        ){
        $username = $_POST['username'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $contactNumber = $_POST['contactnumber'];
        $Usertype = $_POST['usertype'];

        registerTeacher($username, md5($password), $firstname, $lastname, $email, $contactNumber);

        }
        else {
            echo "Required fields are missing";
        }
}

?>