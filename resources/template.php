<!DOCTYPE html>

<!DOCTYPE html>

<?php
    session_start();
    if(!isset($_SESSION['id'])){  //로그인 했던 사용자가 아닐경우 로그인 페이지로 보내기
      echo '<script type="text/javascript">'.
              'location.replace("http://localhost/archive/login.php");'.
                '</script>';
    }

    $id = $_SESSION['id'];  //현재 접속 id 받아오기
    $name = $_SESSION['name'];  //현재 접속한 사람의 이름 받아오기
    $level = $_SESSION['level'];  //현재 접속한 사람의 레벨 받아오기
?>

<html>
<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- import bootstarp for CSS -->
	<link rel="stylesheet" href="http://localhost/resources/bootstrap/css/bootstrap.css">

	<!-- jQuery for using bootstrap.js -->
	<script src="http://localhost/resources/jquery-3.2.1.min.js"></script>
  <!-- import bootstarp for javascript -->
  <script src="http://localhost/resources/bootstrap/js/bootstrap.min.js"></script>

</head>
<body>
	<header>
    <ul class="nav nav-tabs">
      <a class="navbar-brand" href="http://localhost" style="padding-top: 0px;"><img height="45px" src="http://localhost/image/logo.png"></a>
      <li role="presentation" class="active"><a href="http://localhost/archive/main.php">Archive</a></li>
      <li role="presentation" ><a href="http://localhost/archive/upload.php">Upload</a></li>

      <?php
        if($level == 1){
          echo '<li role="presentation" ><a href="http://localhost/archive/admin.php">Admin</a></li>';
        }
      ?>

      <?php
        echo '<p class="col-md-offset-9" style="margin-top: 10px">안녕하세요 '.$name.' 님! &nbsp
                <a href="http://localhost/archive/logout.php">logout</a></p>'
      ?>

	</header>
</body>
</html>
