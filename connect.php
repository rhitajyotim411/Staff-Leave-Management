<?php
$host = "localhost"; /* Host name */
$user = "R35"; /* User */
$password = "R35"; /* Password */
$dbname = "r35"; /* Database name */

try {

    // create a PDO instance to represent a connection to the requested database
    $conn = new PDO("mysql:host={$host}; dbname={$dbname}", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connection Successful.";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}