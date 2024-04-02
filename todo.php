<?php
header("Access-Control-Allow-Origin: *");

session_start();

if (isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == true) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $logout = $_POST["logout"];
        $id = $_POST["id"];
        $done_status = $_POST["done_status"];
        $formData = $_POST["formData"];
        parse_str($formData, $formDataArray);
        $title = $formDataArray['title'];
        $content = $formDataArray['content'];
        $time = $formDataArray['time'];
        if (isset($formDataArray['send_mail'])) {
            $send_mail = $formDataArray['send_mail'];
        } else {
            $send_mail = '0';
        }
       
        $status = $_POST["status"];


        $dbms = 'mysql';    
        $host = 'localhost'; 
        $dbName = 'memmo';    
        $user = 'root';      
        $pass = '12345678';          
        $dsn = "$dbms:host=$host;dbname=$dbName";

        switch ($status) {
            case "logout":
                if (!$logout) {
                    echo json_encode(array("success" => true, "message" => "您已登出"));
                    session_destroy();
                }
                break;
            case "delete":
                try {
                    $dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
                    $stmt = $dbh->prepare("DELETE FROM memmo_list WHERE id = :id AND user_name = :user");

                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':user', $_SESSION['acc']);

                    $result = $stmt->execute();

                    $dbh = null;

                    echo json_encode(array("success" => true, "message" => "刪除完成"));

                } catch (PDOException $e) {
                    echo json_encode(array("success" => true, "message" => $e->getMessage()));
                }
                break;
            case "insert":
                try {
                    $dbh = new PDO($dsn, $user, $pass); 

                    $stmt = $dbh->prepare("INSERT INTO memmo_list (user_name, date, title, content, send_mail, finish) VALUES (:user, :time, :title, :content, :send_mail, '0')");

                    $stmt->bindParam(':user', $_SESSION['acc']);
                    $stmt->bindParam(':title', $title);
                    $stmt->bindParam(':time', $time);
                    $stmt->bindParam(':content', $content);
                    $stmt->bindParam(':send_mail', $send_mail);

                    $result = $stmt->execute();

                    $dbh = null;

                    echo json_encode(array("success" => true, "message" => "新增完成"));

                } catch (PDOException $e) {
                    echo json_encode(array("success" => true, "message" => $e->getMessage()));
                }
                break;
            case "edit_save":
                try {
                    $dbh = new PDO($dsn, $user, $pass);

                    $stmt = $dbh->prepare("UPDATE memmo_list SET date = :time, title = :title, content = :content, send_mail = :send_mail WHERE id = :id AND user_name = :user");

                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':user', $_SESSION['acc']);
                    $stmt->bindParam(':title', $title);
                    $stmt->bindParam(':time', $time);
                    $stmt->bindParam(':content', $content);
                    $stmt->bindParam(':send_mail', $send_mail);

                    $result = $stmt->execute();

                    $dbh = null;

                    echo json_encode(array("success" => true, "message" => "更新完成"));

                } catch (PDOException $e) {
                    echo json_encode(array("success" => false, "message" => $e->getMessage()));
                }
                break;
            case "done":
                try {
                    $dbh = new PDO($dsn, $user, $pass); 

                    $stmt = $dbh->prepare("UPDATE memmo_list SET finish = :done WHERE id = :id AND user_name = :user");

                    $done_status = !intval($done_status);
                    $stmt->bindParam(':done', $done_status);
                    $stmt->bindParam(':user', $_SESSION['acc']);
                    $stmt->bindParam(':id', $id);

                    $result = $stmt->execute();

                    $dbh = null;

                    echo json_encode(array("success" => true, "message" => "更新完成"));

                } catch (PDOException $e) {
                    echo json_encode(array("success" => false, "message" => $e->getMessage()));
                }
                break;
            default:

        }

    }
}

