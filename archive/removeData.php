<!DOCTYPE html>

<?php
    include 'property.php';
    session_start();
    if(!isset($_SESSION['key_num']) || $_SESSION['level']==3){  //로그인 했던 사용자가 아니거나, 업로드 제한 계정일 경우 로그인 페이지로 보내기
        echo '<script type="text/javascript">'.
            'location.replace("http://'.$localhost.'/archive/login.php");'.
            '</script>';
        exit();
    }
    $http_host = $_SERVER['HTTP_HOST'];
    $request_uri = $_SERVER['REQUEST_URI'];
    $url = $http_host . $request_uri;
    echo $url;
    exit();

    mysqli_select_db($conn, "archive_db");
    $connect = mysqli_query($conn, 'SELECT * FROM tb_video WHERE ');
    


?>