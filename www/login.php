<?php
    $con = mysqli_connect("localhost", "admin", "1q2w3e4r", "st");
    mysqli_query($con,'SET NAMES utf8');

    //isset으로 undefined index 에러 해결
    $userID = isset($_POST["userID"]) ? $_POST["userID"] : '';
    $userPassword = isset($_POST["userPassword"]) ? $_POST["userPassword"] : '';

    $statement = mysqli_prepare($con, "SELECT * FROM user WHERE userID =? AND userPassword = ?");
    mysqli_stmt_bind_param($statement, "ss", $userID, $userPassword);
    mysqli_stmt_execute($statement);


    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $userID, $userPassword, $userName);

    $response = array();
    $response["success"] = false;

    while(mysqli_stmt_fetch($statement)) {
        $response["success"] = true;
        $response["userID"] = $userID;
        $response["userPassword"] = $userPassword;
        $response["userName"] = $userName;
    }

    echo json_encode($response);

?>