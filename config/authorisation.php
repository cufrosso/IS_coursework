<?php
    require_once "connect.php";

    $nick = $_POST["auth_nick"];
    $exist = mysqli_fetch_row(mysqli_query($connect,"SELECT COUNT(*) FROM users WHERE nickname = '$nick'"));
    if ($exist[0] == 0){
        echo 0;
    }
    else{
        session_start();
        $_SESSION['nick'] = $nick;
        echo 1;
    }
?>
