<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(array("success" => false, "message" => "請先登入"));
    exit;
} else {
    echo json_encode(array("success" => true, "message" => "已登入"));
    exit;
}