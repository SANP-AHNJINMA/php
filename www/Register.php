<?php
    $con = mysqli_connect("localhost", "admin", "1q2w3e4r", "st");
    mysqli_query($con,'SET NAMES utf8');

    $userID = isset($_POST["userID"]) ? $_POST["userID"] : '';
    $userPassword = isset($_POST["userPassword"]) ? $_POST["userPassword"] : '';
    $userName = isset($_POST["userName"]) ? $_POST["userName"] : '';
    
    $stmt = mysqli_prepare($con, "INSERT INTO user VALUES (?,?,?)");
    mysqli_stmt_bind_param($stmt, "sss", $userID, $userPassword, $userName);
    mysqli_stmt_execute($stmt);


    $response = array();
    $response["success"] = true;


    echo json_encode($response);

?>