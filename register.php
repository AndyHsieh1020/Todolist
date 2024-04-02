<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

// 用户注册时创建密码的函数，加盐并返回加密后的密码和盐
function generateHashAndSalt($password)
{
    // 生成一个随机的盐值
    $salt = bin2hex(random_bytes(32));
    // 使用盐值对密码进行加密
    $hashedPassword = hash('sha256', $password . $salt);
    // 返回加密后的密码和盐值
    return array('password' => $hashedPassword, 'salt' => $salt);
}


// 检查是否通过 POST 方法提交表单
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单中提交的数据
    $acc = $_POST["username"];
    $pwd = $_POST["password"];
    $email = $_POST["email"];



    
    $hashedAndSalted = generateHashAndSalt($pwd);
    $hashedPassword = $hashedAndSalted['password'];
    $salt = $hashedAndSalted['salt'];


    $dbms = 'mysql';     
    $host = 'localhost'; 
    $dbName = 'memmo';    
    $user = 'root';      
    $pass = '12345678';          
    $dsn = "$dbms:host=$host;dbname=$dbName";


    try {
        $dbh = new PDO($dsn, $user, $pass); 
        
        
        $sql = "INSERT INTO user (user_name, password, salt, email) VALUES ('$acc', '$hashedPassword', '$salt', '$email')";
        $sql_check_user = "SELECT user_name from user WHERE user_name = '$acc'";
        $numRows = $dbh->query($sql_check_user)->rowCount();
        
        
        // 执行 SQL 语句
        if ($numRows > 0) {
            echo json_encode(array("success" => false, "message" => "已有人使用此帳號"));
        } else {
            $dbh->query($sql);
            echo json_encode(array("success" => true, "message" => "註冊成功"));
        }

        $dbh = null;

    } catch (PDOException $e) {
        die("Error!: " . $e->getMessage() . "<br/>");
    }
    
}


