<!DOCTYPE html>

<?php
    session_start();
    if(!isset($_SESSION['key_num']) || $_SESSION['level']==3){  //로그인 했던 사용자가 아니거나, 업로드 제한 계정일 경우 로그인 페이지로 보내기
      echo '<script type="text/javascript">'.
              'location.replace("http://localhost/archive/login.php");'.
                '</script>';
      exit();
    }

    $key = $_SESSION['key_num'];  //현재 접속 id 받아오기
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

  <script>
    <?php
      if(isset($_GET['error']) && $_GET['error']==1){
        echo 'alert("The file name extension is wrong type");';
      }else if(isset($_GET['error']) && $_GET['error']==2){
        echo 'alert("Please enter all of the information to add");';
      }
    ?>

  </script>

</head>
<body>
  <header>
    <ul class="nav nav-tabs">
      <a class="navbar-brand" href="http://localhost" style="padding-top: 0px;"><img height="45px" src="http://localhost/image/logo.png"></a>
      <li role="presentation" class="active"><a href="http://localhost/archive/upload.php">Upload</a></li>

      <?php
        echo '<p class="col-md-offset-9" style="margin-top: 10px">안녕하세요 '.$name.' 님! &nbsp
                <a href="http://localhost/archive/logout.php">logout</a></p>'
      ?>

	</header>

    <!-- 업로드 폼 -->
    <form name="file_send" onsubmit="return check()" action="http://localhost/archive/receive.php" method="post" enctype="multipart/form-data">
      <div class="col-md-offset-1">
        <div class="row" style="margin-top: 1vh">
    			<label class="col-md-2" for="date">촬영일*</label>
          <div class="col-md-8">
    			     <input type="date" class="form-control" id="date" name="date" value=""/>
          </div>
        </div>

        <div class="row" style="margin-top: 1vh">
    			<label class="col-md-2" for="title">제목*</label>
          <div class="col-md-8">
    			     <input type="text" class="form-control" id="title" name="title" value=""/>
          </div>
        </div>
      
        <div class="row" style="margin-top: 1vh">
    			<label class="col-md-2" for="company">업체*</label>
          <div class="col-md-8">
            <select class="form-control" id="company" name="company">
              <option> </option>
              <?php
                $conn = mysqli_connect('localhost', 'root', 123456)
                  or die('Error connection to MySQL server');
                mysqli_select_db($conn, "archive_db");
                $connect = mysqli_query($conn, 'SELECT * FROM tb_company');
                while(true){
                  $company = mysqli_fetch_assoc($connect);
                  if($company['company_name']!=null){
                    echo '<option>'.$company["company_name"].'</option>';
                  }
                  else{
                    break;
                  }
                }
              ?>

            </select>
          </div>
        </div>

        <div class="row" style="margin-top: 1vh">
    			<label class="col-md-2" for="place">촬영장소*</label>
          <div class="col-md-8">
    			     <input type="text" class="form-control" id="place" name="place" value=""/>
          </div>
        </div>

        <div class="row" style="margin-top: 1vh">
          <label class="col-md-2" for="cameraman">촬영자*</label>
          <div class="col-md-8">
               <input type="text" class="form-control" id="cameraman" name="cameraman" value=""/>
          </div>
        </div>

        <div class="row" style="margin-top: 1vh">
    			<label class="col-md-2" for="equipment">촬영장비*</label>
          <div class="col-md-8">
    			     <input type="text" class="form-control" id="equipment" name="equipment" value=""/>
          </div>
        </div>

        <div class="row" style="margin-top: 1vh">
    			<label class="col-md-2" for="detail">세부내용</label>
          <div class="col-md-8">
            <textarea class="col-md-12" rows="7" name="detail"></textarea>
            <!-- <input type="text" style="height:200px" class="form-control" id="detail" name="detail" value=""/> -->
          </div>
        </div>

        <div class="row" style="margin-top: 1vh">
    			<label class="col-md-2" for="extra">비고</label>
          <div class="col-md-8">
    			     <input type="text" class="form-control" id="extra" name="extra" value=""/>
          </div>
        </div>

      <div class="row" style="margin-top: 1vh">
  			<label class="col-md-2" for="video">영상*</label>
        <div class="col-md-8">
  			     <input multiple="multiple" id="video" type="file" name="video[]">
        </div>
      </div>

      <div class="row" style="margin-top: 1vh">
  			<label class="col-md-2" for="file">파일</label>
        <div class="col-md-8">
      	  <input multiple="multiple" type="file" name="file[]">
        </div>
      </div>

      <div class="row">
        <div class="form-group">
           <input style="margin-top: 4vh" type="submit" value="보내기" name="submit" class="btn btn-default col-md-offset-8 col-md-2">
        </div>
      </div>
    </form>
    <script>
    function check(){
      var myform = document.forms['file_send'];
      if(myform['date'].value.length < 1){
        alert('촬영일을 입력 하세요.');
        return false;
      }
      if(myform['title'].value.length < 1){
        alert('제목을 입력 하세요.');
        return false;
      }
      if(myform['company'].value.length < 1){
        alert('업체를 입력 하세요.');
        return false;
      }
      if(myform['place'].value.length < 1){
        alert('촬영장소를 입력 하세요.');
        return false;
      }
      if(myform['cameraman'].value.length < 1){
        alert('촬영자를 입력 하세요.');
        return false;
      }
      if(myform['equipment'].value.length < 1){
        alert('촬영장비를 입력 하세요.');
        return false;
      }
      if(myform['video'].value.length < 1){
        alert('영상파일이 없습니다.');
        return false;
      }
      return true;
    }
    </script>
  </div>
</body>
</html>
