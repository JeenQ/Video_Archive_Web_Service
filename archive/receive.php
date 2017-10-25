<!DOCTYPE html>

<?php
  session_start();
  if(!isset($_SESSION['key_num'])){  //로그인 했던 사용자가 아닐경우 로그인 페이지로 보내기
    echo '<script type="text/javascript">'.
            'location.replace("http://localhost/archive/login.php");'.
              '</script>';
    exit();
  }

  $key = $_SESSION['key_num'];  //현재 접속 id 받아오기
  $name = $_SESSION['name'];  //현재 접속한 사람의 이름 받아오기
  $level = $_SESSION['level'];  //현재 접속한 사람의 레벨 받아오기

  $time = time();

  $conn = mysqli_connect('localhost', 'root', 123456)
    or die('Error connection to MySQL server');
  mysqli_select_db($conn, "archive_db");

  define('UPLOADPATH', $_SERVER['DOCUMENT_ROOT'].'/video/');
  define('FILEPATH', $_SERVER['DOCUMENT_ROOT'].'/file/');

  if(isset($_POST['submit'])){  //submit 버튼이 눌러졌는지 확인
    var_dump($_FILES);
    /* input 데이터 변수로 저장 */
    $date = $_POST['date'];
    $title = $_POST['title'];
    $company = $_POST['company'];
    $place = $_POST['place'];
    $cameraman = $_POST['cameraman'];
    $equipment = $_POST['equipment'];
    $detail = $_POST['detail'];
    $extra = $_POST['extra'];
    $creater_key = $key;

    // multiple file upload
    if(count($_FILES['video']['name'])>=1){
      for($i=0; $i<count($_FILES['video']['name']); $i++) {
        if($_FILES['video']['size'][$i] && !$_FILES['video']['error'][$i]){

          $videoName = $_FILES['video']['name'][$i];
          if(strcasecmp(strrchr($videoName,"."),'.mov') && strcasecmp(strrchr($videoName,"."),'.avi') && strcasecmp(strrchr($videoName,"."),'.mpg')
              && strcasecmp(strrchr($videoName,"."),'.mpeg') && strcasecmp(strrchr($videoName,"."),'.mpe') && strcasecmp(strrchr($videoName,"."),'.wmv')
                && strcasecmp(strrchr($videoName,"."),'.asf') && strcasecmp(strrchr($videoName,"."),'.asx') && strcasecmp(strrchr($videoName,"."),'.flv')
                  && strcasecmp(strrchr($videoName,"."),'.dat') && strcasecmp(strrchr($videoName,"."),'.mkv') && strcasecmp(strrchr($videoName,"."),'.mp4')){  //파일 확장자 체크하기  mov,

            //확장자가 잘못됐을 경우, error 값을 1로하고 업로드 페이지로 돌려보낸다
            echo '<script type="text/javascript">'.'location.replace("http://localhost/archive/upload.php?error=1");'.'</script>';
            exit;
          }

          $videoTmp = $_FILES['video']['tmp_name'][$i];
          $videoSize = $_FILES['video']['size'][$i];
          $videoSize = ($videoSize/1024)/1024;
          $videoSize = round($videoSize, 2);

          if (!file_exists(UPLOADPATH.$videoName)) {
            $videoPath = UPLOADPATH.basename($videoName);
          }
          else {
            $videoName = basename($videoName);
            // 파일이 이미 존재할때
            $videoName = substr($videoName, 0, -1*strlen(strrchr($videoName,".")))."_".time().strrchr($videoName,".");
            $videoPath = UPLOADPATH.$videoName;
          }

          if(count($_FILES['video']['name'])>1){
            // 제목에 index를 붙여서 db에 저장.
            $title_i=$title.'_'.($i+1);
            $query = "INSERT INTO tb_video (shoot_date, title, company, place, cameraman, equipment, detail, extra, path, size, creater_key, group_key)".
                "VALUES ('$date', '$title_i', '$company', '$place', '$cameraman', '$equipment', '$detail', '$extra', '$videoName' ,'$videoSize', '$creater_key', '$time')";
          }
          else{
            $query = "INSERT INTO tb_video (shoot_date, title, company, place, cameraman, equipment, detail, extra, path, size, creater_key, group_key)".
                "VALUES ('$date', '$title', '$company', '$place', '$cameraman', '$equipment', '$detail', '$extra', '$videoName' ,'$videoSize', '$creater_key', '$time')";
          }
          mysqli_query($conn, $query)
           or die('Error querying database.');
          move_uploaded_file($videoTmp, $videoPath);
        }
        else{
          echo '<script type="text/javascript">'.'location.replace("http://localhost/archive/upload.php?error=1");'.'</script>';
          exit;
        }
      }
    }
    else{
      echo '<script type="text/javascript">'.'location.replace("http://localhost/archive/upload.php?error=1");'.'</script>';
      exit;
    }

    // 파일 제어
    if(count($_FILES['file']['name'])>=1){
      for($i=0; $i<count($_FILES['file']['name']); $i++) {
        if($_FILES['file']['size'][$i] && !$_FILES['file']['error'][$i]){
          $fileName = $_FILES['file']['name'][$i];
          $fileTmp = $_FILES['file']['tmp_name'][$i];

          if (!file_exists(FILEPATH.$fileName)) {
            $filePath = FILEPATH.basename($fileName);
          }
          else {
            $fileName = basename($fileName);
            // 파일이 이미 존재할때
            $fileName = substr($fileName, 0, -1*strlen(strrchr($fileName,".")))."_".time().strrchr($fileName,".");
            $filePath = FILEPATH.$fileName;
          }

          $query = "INSERT INTO tb_file (file_name, account_key, group_key)
              VALUES ('$fileName', '$creater_key', '$time')";

          mysqli_query($conn, $query)
           or die('Error querying database.');
          move_uploaded_file($fileTmp, $filePath);
        }
      }
    }

    mysqli_close($conn);
    echo
      '<script>
        alert("Upload is completed");
        opener.location.reload();
        self.close();
      </script>';
  }
  else{
    //submit 버튼을 누르지 않고 페이지에 접근했을 때 요청을 거부한다
    mysqli_close($conn);
    echo
      '<script>
        alert("It is bad request");
        opener.location.reload();
        self.close();
      </script>';
  }
?>
