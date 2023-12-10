<?php

// include the functions php file
include "../functions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(
        isset($_POST['username']) &&
        isset($_POST['password']) &&
        isset($_POST['firstname']) && 
        isset($_POST['lastname']) && 
        isset($_POST['email']) && 
        isset($_POST['usertype'])
        ){
        $Username = $_POST['username'];
        $Password = $_POST['password'];
        $Firstname = $_POST['firstname'];
        $Lastname = $_POST['lastname'];
        $Email = $_POST['email'];
        $Usertype = $_POST['usertype'];

        registerUser($Username, md5($Password), $Firstname, $Lastname, $Email, $Usertype);

        }
        else {
            echo "Required fields are missing";
        }
}

?>