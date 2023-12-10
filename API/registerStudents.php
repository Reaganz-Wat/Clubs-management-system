<?php

// include the functions php file
include "../cmsfunctions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if( isset($_POST['username']) &&
        isset($_POST['firstname']) &&
        isset($_POST['lastname']) &&
        isset($_POST['password']) &&
        isset($_POST['date_of_birth']) && 
        isset($_POST['gender']) && 
        isset($_POST['contactnumber']) && 
        isset($_POST['email']) &&
        isset($_POST['usertype'])
        ){
        $username = $_POST['username'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $password = $_POST['password'];
        $dateOfBirth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $contactNumber = $_POST['contactnumber'];
        $Usertype = $_POST['usertype'];

        // registerStudent($Username, $Firstname, $Lastname, $Password, $DateOfBirth, $Gender, $ContactNumber, $Email, $Usertype);

        registerStudent($username, md5($password), $firstname, $lastname, $email, $dateOfBirth, $gender, $contactNumber);

        }
        else {
            echo "Required fields are missing";
        }
}

// registerStudent("Wati", "wati@123", "Watmon", "Reagan", "reaganwatmon6@gmail.com", "2000-08-29", "Male", "+256780807525");

?>