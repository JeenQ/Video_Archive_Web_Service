<!DOCTYPE html>

<?php
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
?>


<?php  //계정 추가 요청을 처리하기 위한 블럭
  if(isset($_POST['accountSubmit'])){ //계정 생성 제출 버튼이 눌러졌는지 확인
    /* DB 연결하기 */
    $conn = mysqli_connect('localhost', 'root', 123456)
      or die('Error connection to MySQL server');
    mysqli_select_db($conn, "archive_db");

    /*input data 를 변수로 저장*/
    $id = $_POST['newID'];
    $password = $_POST['newPassword'];
    $userName = $_POST['userName'];
    $userPosition = $_POST['userPosition'];
    $userLevel = $_POST['userLevel'];

    if(!empty($id) && !empty($password)){ //id 와 password 가 입력되었는지 확인한다
      //$connect = mysqli_query($conn, "SELECT * FROM tb_account WHERE id='$id'");
      //$check = mysql_fetch_assoc($connect);
      //$checkID = $check['id'];

      //echo 'please';
      //echo 'final: '.$checkID;


      /* 새로운 계정 table 에 삽입하기 */
      $query = "INSERT into `tb_account` (id, password, name, position, level)".
          "VALUES ('$id', '$password', '$userName', '$userPosition', '$userLevel')";

      mysqli_query($conn, $query)
        or die('Error querying database');

      echo '<script type="text/javascript">'.
              'location.replace("http://localhost/archive/admin.php");'.
                '</script>';
      exit();

    }else {
      //id 또는 password 가 입력되지 않았을 경우 경고창을 보여준다
      echo '<script>alert("You must enter ID and Password");</script>';
      echo '<script type="text/javascript">'.
              'location.replace("http://localhost/archive/admin.php");'.
                '</script>';
      exit();
    }
  }
 ?>

<?php //계정 삭제 요청을 처리하기 위한 블럭
  if(!isset($_GET['id'])){ //삭제요청이 맞는지 확인
    echo '<script type="text/javascript">'.
            'location.replace("http://localhost/archive/login.php");'.
              '</script>';
    exit();
  }

  /* DB 연결하기 */
  $conn = mysqli_connect('localhost', 'root', 123456)
    or die('Error connection to MySQL server');
  mysqli_select_db($conn, "archive_db");


  $deleteID = $_GET['id'];  //몇번째를 삭제하려고 하는지 GET 을 통해 받기

  $query = "DELETE from tb_account where id='$deleteID'"; //삭제 쿼리문

  mysqli_query($conn, $query)
    or die('Error querying database');

  echo '<script type="text/javascript">'.
          'location.replace("http://localhost/archive/admin.php");'.
            '</script>';
  exit();

?>
