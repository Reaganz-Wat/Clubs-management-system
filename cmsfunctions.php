<?php

// function to make connection to the database
function connectToDatabase(){
    $serverName = "localhost";
    $userName = "root";
    $password = "";
    $databaseName = "CMSDB";

    // create connection to the database
    $connection = mysqli_connect($serverName, $userName, $password, $databaseName);

    // check for the connection
    if(!$connection){
        die ("Conncection failed: " . mysqli_connect_error());
    }

    return $connection;
}


function registerTeacher($username, $password, $firstname, $lastname, $email, $contactNumber) {

    // create a connection to database
    $conn = connectToDatabase();

    // Insert user record
    $sqlUser = "INSERT INTO Users (Username, Password, Firstname, Lastname, Email, UserType) 
                VALUES ('$username', '$password', '$firstname', '$lastname', '$email', 'Teacher')";

    $users_results = mysqli_query($conn, $sqlUser);

    $userID = mysqli_insert_id($conn); // Get the last inserted ID (UserID)

    // Insert teacher record
    $sqlTeacher = "INSERT INTO Teachers (UserID, ContactNumber) 
                   VALUES ('$userID', '$contactNumber')";
    $teachers_results = mysqli_query($conn, $sqlTeacher);

    if ($users_results && $teachers_results) {
        echo "Teacher Created Successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}

function registerStudent($username, $password, $firstname, $lastname, $email, $dateOfBirth, $gender, $contactNumber) {
    $conn = connectToDatabase();

    // Insert user record
    $sqlUser = "INSERT INTO Users (Username, Password, Firstname, Lastname, Email, UserType) 
                VALUES ('$username', '$password', '$firstname', '$lastname', '$email', 'Student')";
    $users_results = mysqli_query($conn, $sqlUser);

    $userID = mysqli_insert_id($conn); // Get the last inserted ID (UserID)

    // Insert student record
    $sqlStudent = "INSERT INTO Students (UserID, DateOfBirth, Gender, ContactNumber) 
                   VALUES ('$userID', '$dateOfBirth', '$gender', '$contactNumber')";
    $students_results = mysqli_query($conn, $sqlStudent);

    if ($users_results && $students_results) {
        echo "Students Created Successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}


function editTeacher($teacherID, $username, $firstname, $lastname, $email, $contactNumber) {
    $conn = connectToDatabase();

    // Update user record
    $sqlUser = "UPDATE Users SET Username = '$username', Firstname='$firstname', Lastname='$lastname', Email='$email' 
                WHERE UserID = (SELECT UserID FROM Teachers WHERE UserID = '$teacherID')";
    $edit_users = mysqli_query($conn, $sqlUser);

    // Update teacher record
    $sqlTeacher = "UPDATE Teachers SET ContactNumber='$contactNumber' WHERE UserID = '$teacherID'";
    $edit_students = mysqli_query($conn, $sqlTeacher);

    if ($edit_students && $edit_users) {
        echo "Edited teachers successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}


function editStudent($studentID, $username, $firstname, $lastname, $email, $contactNumber) {
    $conn = connectToDatabase();

    // Update user record
    $sqlUser = "UPDATE Users SET Username = '$username', Firstname='$firstname', Lastname='$lastname', Email='$email' 
                WHERE UserID = (SELECT UserID FROM Students WHERE UserID = '$studentID')";
    $edit_users = mysqli_query($conn, $sqlUser);

    // Update student record
    $sqlStudent = "UPDATE Students SET ContactNumber='$contactNumber' 
                   WHERE UserID = '$studentID'";
    $edit_students = mysqli_query($conn, $sqlStudent);


    if ($edit_users && $edit_students) {
        echo "Students edited successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}


function fetchAllStudents(){
    $conn = connectToDatabase();

    $sql = "SELECT username, email FROM Users WHERE UserType = 'Student'";

    $results = mysqli_query($conn, $sql);

    if($results){

        // Fetch the data and store it in an array
        $data = array();
        while ($row = mysqli_fetch_assoc($results)) {
            $data[] = $row;
        }

        // Encode the data as JSON and return it
        //echo json_encode($data);

    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

    return $data;
}


function fetchAllTeachers(){
    $conn = connectToDatabase();

    $sql = "SELECT UserID, Firstname, Email FROM Users WHERE UserType = 'Teacher'";

    $results = mysqli_query($conn, $sql);

    if($results){

        // Fetch the data and store it in an array
        $data = array();
        while ($row = mysqli_fetch_assoc($results)) {
            $data[] = $row;
        }

        // Encode the data as JSON and return it
        //echo json_encode($data);

    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

    return $data;
}


function createClubs($creatorID, $club_name, $club_description){
    $conn = connectToDatabase();

    $sql = "INSERT INTO Clubs (ClubName, Description, TeacherID) 
    VALUES ('$club_name', '$club_description', '$creatorID')";

    $results = mysqli_query($conn, $sql);

    if($results){
        echo "New Club Created Successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

}


function fetchAllClubs(){
    $conn = connectToDatabase();

    // Query for fetching the database to get all the club information
    $sql = "SELECT Clubs.ClubID, Clubs.ClubName, Clubs.Description, Users.Username AS Creator
            FROM Clubs
            LEFT JOIN Users ON Clubs.TeacherID = Users.UserID";
    $results = mysqli_query($conn, $sql);

    if($results){

        // Fetch the data and store it in an array
        $data = array();
        while ($row = mysqli_fetch_assoc($results)) {
            $data[] = $row;
        }

    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

    return $data;

}


function loginStudent($username){
    $con = connectToDatabase();


    // Query to fetch data based on the provided username
    $query = "SELECT Users.UserID, Users.Firstname, Users.Lastname, Users.Email, Users.Password, Students.ContactNumber AS Contact
            FROM Users
        JOIN Students ON Users.UserID = Students.UserID
        WHERE Users.Username = ?";


    $stmt = mysqli_prepare($con, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
    
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
                    
            if ($row = mysqli_fetch_assoc($result)) {
                // User with the provided username exists
                $response = array("success" => true, "message" => "User found", "user_data" => $row);
                echo json_encode($response);

                } else {
                    // User with the provided username does not exist
                    $response = array("success" => false, "message" => "User not found");
                    echo json_encode($response);
                    

                    }
                } else {
                    // Error executing the statement
                    $response = array("success" => false, "message" => "Error executing statement");
                    echo json_encode($response);

                }
    
                mysqli_stmt_close($stmt);
            } else {
                // Error preparing the statement
                $response = array("success" => false, "message" => "Error preparing statement");
                echo json_encode($response);

            }

    mysqli_close($con);
}

function loginTeacher($username){
    $con = connectToDatabase();


    // Query to fetch data based on the provided username
    $query = "SELECT Users.UserID, Users.Firstname, Users.Lastname, Users.Email, Users.Password, teachers.ContactNumber AS Contact
            FROM Users
        JOIN teachers ON Users.UserID = teachers.UserID
        WHERE Users.Username = ?";


    $stmt = mysqli_prepare($con, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
    
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
                    
            if ($row = mysqli_fetch_assoc($result)) {
                // User with the provided username exists
                $response = array("success" => true, "message" => "User found", "user_data" => $row);
                echo json_encode($response);

                } else {
                    // User with the provided username does not exist
                    $response = array("success" => false, "message" => "User not found");
                    echo json_encode($response);
                    

                    }
                } else {
                    // Error executing the statement
                    $response = array("success" => false, "message" => "Error executing statement");
                    echo json_encode($response);

                }
    
                mysqli_stmt_close($stmt);
            } else {
                // Error preparing the statement
                $response = array("success" => false, "message" => "Error preparing statement");
                echo json_encode($response);

            }

    mysqli_close($con);
}

function loginAdmin($username){
    $con = connectToDatabase();


    // Query to fetch data based on the provided username
    $query = "SELECT * FROM Users WHERE Username = ?";


    $stmt = mysqli_prepare($con, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
    
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
                    
            if ($row = mysqli_fetch_assoc($result)) {
                // User with the provided username exists
                $response = array("success" => true, "message" => "User found", "user_data" => $row);
                echo json_encode($response);

                } else {
                    // User with the provided username does not exist
                    $response = array("success" => false, "message" => "User not found");
                    echo json_encode($response);
                    

                    }
                } else {
                    // Error executing the statement
                    $response = array("success" => false, "message" => "Error executing statement");
                    echo json_encode($response);

                }
    
                mysqli_stmt_close($stmt);
            } else {
                // Error preparing the statement
                $response = array("success" => false, "message" => "Error preparing statement");
                echo json_encode($response);

            }

    mysqli_close($con);

}

function createSportsTeam($teamName, $coachID){
    $con = connectToDatabase();

    $sql = "INSERT INTO SportsTeams (TeamName, CoachID) VALUES ('$teamName', '$coachID')";

    $results = mysqli_query($con, $sql);

    if ($results) {
        echo "Sports team created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }

    mysqli_close($con);

}

function fetchSportsTeam(){
    $con = connectToDatabase();

    $sql = "SELECT sportsteams.teamid AS TeamID, sportsteams.teamname AS TeamName, users.username AS Coach FROM users LEFT JOIN teachers ON users.userid = teachers.userid INNER JOIN sportsteams ON teachers.teacherid = sportsteams.coachid";


    $results = mysqli_query($con, $sql);

    if($results){

        // Fetch the data and store it in an array
        $data = array();
        while ($row = mysqli_fetch_assoc($results)) {
            $data[] = $row;
        }

    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }

    mysqli_close($con);

    return $data;

}

function fetchTeams(){
    $con = connectToDatabase();

    $sql = "SELECT TeamID, TeamName FROM SportsTeams";


    $results = mysqli_query($con, $sql);

    if($results){

        // Fetch the data and store it in an array
        $data = array();
        while ($row = mysqli_fetch_assoc($results)) {
            $data[] = $row;
        }

    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }

    mysqli_close($con);

    return $data;

}

function createMatches($teamID, $opponent, $date){
    $con = connectToDatabase();
    $sql = "INSERT INTO TeamMatches (TeamID, Opponent, MatchDate) VALUES ('$teamID', '$opponent', '$date')";
    $results = mysqli_query($con, $sql);
    if ($results) {
        echo "Matches created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
    mysqli_close($con);

}

function fetchAllMatches(){
    $con = connectToDatabase();

    $sql = "SELECT SportsTeams.TeamName, TeamMatches.Opponent, TeamMatches.MatchDate FROM SportsTeams INNER JOIN TeamMatches ON SportsTeams.TeamID = TeamMatches.TeamID";


    $results = mysqli_query($con, $sql);

    if($results){

        // Fetch the data and store it in an array
        $data = array();
        while ($row = mysqli_fetch_assoc($results)) {
            $data[] = $row;
        }

    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }

    mysqli_close($con);

    return $data;

}

function joinClubs($ClubID, $StudentID){
    $con = connectToDatabase();

    $JoinDate = 

    $sql = "INSERT INTO ClubMembers (ClubID, StudentID, JointDate) VALUES ('$ClubID','$studentID','$JoinDate')";


    $results = mysqli_query($con, $sql); 

    if ($results) {
        echo "Clubs joined successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
    mysqli_close($con);
}

?>