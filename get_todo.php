<?php

header("Access-Control-Allow-Origin: *");
session_start();
//检查用户是否登录，如果未登录则跳转回登录页面
if (isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == true) {
    $dbms = 'mysql';     
    $host = 'localhost'; 
    $dbName = 'memmo';    
    $user = 'root';      
    $pass = '12345678';         
    $dsn = "$dbms:host=$host;dbname=$dbName";


    try {
        $dbh = new PDO($dsn, $user, $pass); 

        $stmt = $dbh->prepare("SELECT * FROM memmo_list WHERE user_name = :user");

        $stmt->bindParam(':user', $_SESSION['acc']);

        $stmt->execute();

        $tasks = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tasks[] = $row;
        }

        $dbh = null;

        header('Content-Type: application/json');
        echo json_encode($tasks);

    } catch (PDOException $e) {
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
    }
}

