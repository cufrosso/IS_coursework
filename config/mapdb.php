<?php
    require_once "connect.php";

    $query = $_POST['query'];
    switch($query[0]){
        case "get_post":
            $points = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM postamats"));
            echo json_encode($points);
            break;
        case "get_pack":
            $points = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM package"));
            echo json_encode($points);
            break;
          }
