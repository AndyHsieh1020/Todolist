<?php

header("Access-Control-Allow-Origin: *");
session_start();


function verifyPassword($inputPassword, $hashedPassword, $salt)
{
    
    $inputHashedPassword = hash('sha256', $inputPassword . $salt);
    
    return $inputHashedPassword === $hashedPassword;
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $acc = $_POST["username"];
    $pwd = $_POST["password"];



    $dbms = 'mysql';     
    $host = 'localhost'; 
    $dbName = 'memmo';    
    $user = 'root';      
    $pass = '12345678';          
    $dsn = "$dbms:host=$host;dbname=$dbName";


    try {
        $dbh = new PDO($dsn, $user, $pass); 


        $sql = "SELECT * FROM user WHERE user_name = '" . $acc . "'";

        $numRows = $dbh->query($sql)->rowCount();

        if ($numRows > 0) {

            $result = $dbh->query($sql);
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $hashpwd = $row['password'];
                $salt = $row['salt'];
            }

            
            $isPasswordCorrect = verifyPassword($pwd, $hashpwd, $salt);

            // 输出验证结果
            if ($isPasswordCorrect) {
                echo json_encode(array("success" => true, "message" => "登入成功"));
                
                $dbh = null;
                $_SESSION['loggedin'] = true;
                $_SESSION['acc'] = $acc;
            } else {
                echo json_encode(array("success" => false, "message" => "帳號或密碼錯誤"));
            }

        } else {
            echo json_encode(array("success" => false, "message" => "帳號或密碼錯誤"));
        }

        $dbh = null;

    } catch (PDOException $e) {
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
    }
}
