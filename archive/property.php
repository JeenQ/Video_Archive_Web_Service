<!DOCTYPE html>

<?php
    $conn = mysqli_connect('localhost', 'root', 'Big@1')
    // $conn = mysqli_connect('localhost', 'root', '123456')
        or die('Error connection to MySQL server');
    $localhost = $_SERVER['SERVER_ADDR'];
?>