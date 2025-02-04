<?php

$server = "localhost";
$username = "root";
$password = "p@ssw0rd";
$database = "info_tracker";

// Establish connection using mysqli
$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$table_check = mysqli_query($conn, "SHOW TABLES LIKE 'track'");
if (mysqli_num_rows($table_check) == 0) {
    // SQL to create table
    $sql = "CREATE TABLE track (
       id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
       tm VARCHAR(50) NOT NULL DEFAULT '',
       ref VARCHAR(250) NOT NULL DEFAULT '',
       agent VARCHAR(250) NOT NULL DEFAULT '',
       ip VARCHAR(50) NOT NULL DEFAULT '',
       ip_value INT(50) NOT NULL DEFAULT '0',
       os VARCHAR(50) NOT NULL DEFAULT '',
       browser VARCHAR(100) NOT NULL DEFAULT '',
       location VARCHAR(100) NOT NULL DEFAULT '',
       language VARCHAR(50) NOT NULL DEFAULT '',
       host_name VARCHAR(50) NOT NULL DEFAULT '',
       page_visited VARCHAR(100) NOT NULL DEFAULT '',
       tracking_page_name VARCHAR(50) NOT NULL DEFAULT ''
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";

    // Execute query
    if (mysqli_query($conn, $sql)) {
       echo "Table has been created.";
    } else {
       die("Error creating table: " . mysqli_error($conn));
    }

    // Close connection
    mysqli_close($conn);

}


?>