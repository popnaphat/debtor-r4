<?php
    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $db = "voc";

    // // Create connection
    // $conn = new mysqli($servername, $username, $password, $db);

    // // Check connection
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // mysqli_query($conn, "SET NAMES utf8");

    //$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

    $server = 'localhost';
    $username = 'root';
    $password = '123456';
    $db = 'import-excel-to-mysql';

    $conn = new mysqli($server, $username, $password, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    mysqli_query($conn, "SET NAMES utf8");