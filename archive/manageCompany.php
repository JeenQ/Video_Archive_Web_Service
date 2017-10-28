<!DOCTYPE html>

<?php
	  include 'dbProperty.php';
    session_start();
    if(!isset($_SESSION['key_num']) || $_SESSION['level']!=1){  //로그인 했던 사용자가 아닐경우 로그인 페이지로 보내기
      echo '<script type="text/javascript">'.
              'location.replace("http://localhost/archive/login.php");'.
                '</script>';
      exit();
    }

    $key = $_SESSION['key_num'];  //현재 접속 id 받아오기
    $name = $_SESSION['name'];  //현재 접속한 사람의 이름 받아오기
    $level = $_SESSION['level'];  //현재 접속한 사람의 레벨 받아오기

    mysqli_select_db($conn, "archive_db");

    $mode = $_GET['mode'];
    $company = $_GET['company'];
    
    if($mode==1){
        mysqli_query($conn, "INSERT INTO tb_company VALUES('$company')")
            or die('Error querying database');
    }
    else{
        mysqli_query($conn, "DELETE FROM tb_company WHERE company_name = '$company'")
            or die('Error querying database');
    }
    
    echo '<script type="text/javascript">'.
        'location.replace("http://localhost/archive/admin.php");'.
        '</script>';
?>