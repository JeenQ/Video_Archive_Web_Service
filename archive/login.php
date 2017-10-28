<!DOCTYPE html>

<?php
	include 'property.php';
	session_start();

	if(isset($_SESSION['key_num'])){  //로그인 했던 사용자일 경우 메인 페이지로 보내기
	echo '<script type="text/javascript">'.
						'location.replace("http://'.$localhost.'/archive/main.php");'.
							'</script>';
	}

	/* mysql 및 'archive_db' 연결 열기 */
	mysqli_select_db($conn, "archive_db");

	$check = 0;	//로그인 시도 결과를 저장하기 위한 변수

	if(isset($_POST['submit'])){	//submit 버튼이 눌러졌는지 확인한다

			/* 아이디 및 비밀번호를 POST 형식으로 받는다 */
			$id = $_POST['id'];
	    $password = $_POST['password'];

			if(!empty($id) && !empty($password))	//아이디와 비밀번호가 입력되었는 지 확인한다
			{

					/* 테이블로 부터 고유번호와 아이디 및 비밀번호를 모두 가져온다 */
					$query = "SELECT key_num, id, password, name, level FROM `tb_account`";

					$raw = mysqli_query($conn, $query)
						or die('Error querying database.');


					/* 입력된 아이디와 비밀번호를 DataBase 와 비교한다 */
					while(true){
							$user = mysqli_fetch_assoc($raw);

							if($user['key_num'] != null)	//마지막 row 인지 아닌지를 확인한다
							{
									if($user['id']==$id){	//아이디 체크
											if($user['password']==$password){	//암호 체크

													$_SESSION['key_num'] = $user['key_num'];
													$_SESSION['name'] = $user['name'];
													$_SESSION['level'] = $user['level'];
													$_SESSION['contents'] = 3;

													//로그인 시간 업데이트
													$query = "UPDATE tb_account set last_login=NOW() where key_num=".$user['key_num'];
													mysqli_query($conn, $query);

													echo '<script type="text/javascript">'.
											            'location.replace("http://'.$localhost.'/archive/main.php?page=0");'.
											              '</script>';
													break;
											}
											else{
												$check = 2;	//암호가 틀렸을 때
											}
										}else{
												$check = 1;	//아이디가 틀렸을 때
										}
							}else {

								break;
							}
					}

			}
			else
			{
					echo '<script type="text/javascript">alert("You didn\'t enter you id or password");</script>';	//아이디와 비밀번호
			}
	}
	else {


	}
 ?>

<html>
<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Archive System</title>

	<!-- import bootstarp for CSS -->
	<link rel="stylesheet" href="http://<?php echo $localhost ?>/resources/bootstrap/css/bootstrap.css">

	<!-- jQuery for using bootstrap.js -->
	<script src="http://<?php echo $localhost ?>/resources/jquery-3.2.1.min.js"></script>
  <!-- import bootstarp for javascript -->
  <script src="http://<?php echo $localhost ?>/resources/bootstrap/js/bootstrap.min.js"></script>

</head>
<body>
	<header>
  </header>

	<form class="form-horizontal" action="http://<?php echo $localhost ?>/archive/login.php"  method="post" style="margin-top: 20vh">

		  <div class="form-group">
		    <div class="col-md-offset-4 col-md-4">
		      <input type="text" class="form-control" id="id" name="id" placeholder="ID">
		    </div>

				<div class="col-md-4">
					<?php
						if($check == 1){
							echo '<label class="control-label" for="id" style="color: red;">Your Id don\'t exist there</label>';
						}
					?>
				</div>
		  </div>

		  <div class="form-group" style="margin-top: 1vh">
		    <div class="col-md-offset-4 col-md-4">
			      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
		    </div>

				<div class="col-md-4">
					<?php
						if($check == 2){
							echo '<label class="control-label" for="password" style="color: red;">Your Password is wrong</label>';
						}
					?>
				</div>
		  </div>

	    <div class="col-md-offset-4 col-md-2" style="margin-top: 5vh">
	      <button type="submit" name="submit" class="btn btn-default">Sign in</button>
	    </div>

	</form>
</body>
</html>
