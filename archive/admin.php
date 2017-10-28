<!DOCTYPE html>

<?php
	  include 'dbProperty.php';
    session_start();
    if(!isset($_SESSION['key_num']) || $_SESSION['level']!=1){  //로그인 했던 사용자가 아니거나, 관리자가 아닐경우 로그인 페이지로 보내기
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

  <style>
      .add_btn {
      position: absolute;
      right: 25px;
      top: 8px;
      }
      /* 스위치 버튼 생성을 위한 css */

      .switch {
      position: absolute;
      right: 30px;
      top: 17px;
      display: inline;
      width: 38px;
      height: 5px;
      }

      /* Hide default HTML checkbox */
      .switch input {display:none;}

      /* The slider */
      .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
      }

      .slider:before {
      position: absolute;
      content: "";
      height: 13px;
      width: 13px;
      left: 0;
      bottom: -4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
      }

      input:checked + .slider {
      background-color: #2196F3;
      }

      input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
      }

      input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
      }

      /* Rounded sliders */
      .slider.round {
      border-radius: 34px;
      }

      .slider.round:before {
      border-radius: 50%;
      }

  </style>

  <script type="text/javascript">
    //make new windows on the position that you want
    w=1100;
		h=600;

		Left=(screen.width-w)/2;
		Top=(screen.height-h)/2-60;

		function popup_upload(){
			window.open(
				"http://localhost/archive/upload.php",
				"업로드",
				"width="+w+",height="+h+",top="+Top+",left="+Left+", scrollbars=no");
		}
    function popup_addCompany(){
      window.open(
        "http://localhost/archive/addCompany.php",
        "회사 추가",
        "width="+w+",height="+h+",top="+Top+",left="+Left+", scrollbars=no");
    }
  </script>

</head>
<body>
	<header>
    <ul class="nav nav-tabs">
      <a class="navbar-brand" href="http://localhost" style="padding-top: 0px;"><img height="45px" src="http://localhost/image/logo.png"></a>
      <li role="presentation" class="main" onmouseover="javascript:visible()"><a href="http://localhost/archive/main.php">Archive</a></li>

      <?php
        if($level == 2 || $level == 1){
          echo '<li role="presentation" ><a href="#" onclick="popup_upload();">Upload</a></li>';
        }
      ?>

      <?php
        if($level == 1){
          echo '<li class="active" role="presentation" ><a href="http://localhost/archive/admin.php">Admin</a></li>';
        }
      ?>

      <?php
        echo '<p class="col-md-offset-9" style="margin-top: 10px">안녕하세요 '.$name.' 님! &nbsp
                <a href="http://localhost/archive/logout.php">logout</a></p>'
      ?>
    </ul>
	</header>

  <!-- 계정 생성을 위한 form -->
  <div class="col-md-8 col-md-offset-2" style="margin-top: 10vh">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="panel-title">계정 생성</h2>
      </div>

      <div class="panel-body">
        <form class="form-horizontal" action="http://localhost/archive/manageAccount.php" method="post">
        <div class="form-group">
          <label for="newID" class="col-md-2 control-label">ID</label>
          <div class="col-md-7">
            <input type="text" class="form-control" id="newID" name="newID" placeholder="ID"/>
          </div>
        </div>

        <div class="form-group">
          <label for="newPassword" class="col-md-2 control-label">Password</label>
          <div class="col-md-7">
            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Password"/>
          </div>
        </div>

        <div class="form-group">
          <label for="userName" class="col-md-2 control-label">이름</label>
          <div class="col-md-7">
            <input type="text" class="form-control" id="userName" name="userName" placeholder="Name"/>
          </div>
        </div>

        <div class="form-group">
          <label for="userPosition" class="col-md-2 control-label">직급</label>
          <div class="col-md-7">
            <input type="text" class="form-control" id="userPosition" name="userPosition" placeholder="Position"/>
          </div>
        </div>

        <div class="form-group">
          <label for="levelRadio" class="col-md-2 control-label">권한</label>
          <div class="col-md-7" id="levelRadio">
            <label for="userLevel1" class="radio-inline">
              <input type="radio" name="userLevel" id="userLevel1" value="1"/>admin
            </label>
            <label for="userLevel2" class="radio-inline">
              <input type="radio" name="userLevel" id="userLevel2" value="2" checked/>level2(upload, download)
            </label>
            <label for="userLevel3" class="radio-inline">
              <input type="radio" name="userLevel" id="userLevel3" value="3"/>level1(download)
            </label>
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
            <button type="submit" name="accountSubmit" class="btn btn-default">등록</button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- 사용자 목록 출력 -->
  <div class="col-md-8 col-md-offset-2" style="margin-top: 10vh">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="panel-title">사용자 목록</h2>

        <!-- Rounded switch -->
        <label class="switch">
          <input type="checkbox" id="modify">
          <span class="slider round"></span>
        </label>
      </div>


        <table class="table">
          <tr>
            <th class="text-center">아이디</th>
            <th class="text-center">비밀번호</th>
            <th class="text-center">이름</th>
            <th class="text-center">직급</th>
            <th class="text-center">권한</th>
            <th class="text-center">마지막 로그인 시간</th>
          </tr>

          <?php  //모든 계정을 불러와서 출력해준다
        mysqli_select_db($conn, "archive_db");

        $connect = mysqli_query($conn, 'SELECT * FROM tb_account');

        for($i=0; ;$i++){
          $account = mysqli_fetch_assoc($connect);

          if($account['key_num']!=null){
            echo '<tr class="text-center"><td id="id'.$i.'" class="text-center">'.$account['id'].'</td>'.
                '<td>'.$account['password'].'</td>'.
                '<td>'.$account['name'].'</td>'.
                '<td>'.$account['position'].'</td>'.
                '<td>'.$account['level'].'</td>'.
                '<td id="row'.$i.'" width="190px">'.$account['last_login'].'</td></tr>';

                $userKey[$i] = $account['key_num'];
          }else {
            break;
          }
        }

        ?>
        </table>

      </div>
    </div>

    <!-- 회사 목록 관리 -->
    <div class="col-md-8 col-md-offset-2" style="margin-top: 10vh">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h2 class="panel-title">회사 목록</h2>
            <button type="button" class="add_btn btn-primary btn-xs" onclick="addCompany()">추가</button>
            <script>
              function addCompany(){
                var company = prompt("회사명");
                location.href='manageCompany.php?mode=1&company=' + company;
              }
            </script>
          </div>
          <table class="table">
            <tr>
              <th class="text-center">회사명</th>
            </tr>

            <?php  //모든 회사명을 불러와서 출력해준다
              $connect = mysqli_query($conn, 'SELECT * FROM tb_company');

              for($i=0; ;$i++){
                $company = mysqli_fetch_assoc($connect);

                if($company['company_name']!=null){
                  echo
                    '<tr class="text-center">
                      <td class="text-center">'.$company['company_name'].'</td>
                      <td width="10px" id="deleteButton'.$i.'">
                        <button type="button" class="btn btn-danger btn-xs" onclick=\'location.href="manageCompany.php?mode=0&company='.$company['company_name'].'"\'>삭제</button>
                      </td>
                    </tr>';
                }else {
                  break;
                }
              }
            ?>
            <tr>
              <td class="text-center"></td>
            </tr>

          </table>
        </div>
      </div>

    <script>
      $("#modify").click(function(){
        if($("#modify").is(":checked")){
              for(var i=0; ; i++){
                  if($("#row"+i).length==0)
                    break;
                  else
                    $("#row"+i).after("<td id=\"deleteButton"+i+"\"><a href=\"http://localhost/archive/manageAccount.php?id="+$("#id"+i).text()+"\"><button type=\"button\" class=\"btn btn-danger btn-xs\">삭제</button></a></td>");
              }
          }else{
            for(var i=0; ; i++){
                if($("#deleteButton"+i).length==0)
                  break;
                else
                  $("#deleteButton"+i).remove();
            }
          }
      })
    </script>

</body>
</html>
