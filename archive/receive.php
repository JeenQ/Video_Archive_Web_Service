<!DOCTYPE html>

<?php
	  include 'property.php';
  session_start();
  if(!isset($_SESSION['key_num'])){  //로그인 했던 사용자가 아닐경우 로그인 페이지로 보내기
    echo '<script type="text/javascript">'.
            'location.replace("http://'.$localhost.'/archive/login.php");'.
              '</script>';
    exit();
  }

  $key = $_SESSION['key_num'];  //현재 접속 id 받아오기
  $name = $_SESSION['name'];  //현재 접속한 사람의 이름 받아오기
  $level = $_SESSION['level'];  //현재 접속한 사람의 레벨 받아오기

  $time = time();

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

          $video = $_FILES['video']['name'][$i];
          if(strcasecmp(strrchr($video,"."),'.mov') && strcasecmp(strrchr($video,"."),'.avi') && strcasecmp(strrchr($video,"."),'.mpg')
              && strcasecmp(strrchr($video,"."),'.mpeg') && strcasecmp(strrchr($video,"."),'.mpe') && strcasecmp(strrchr($video,"."),'.wmv')
                && strcasecmp(strrchr($video,"."),'.asf') && strcasecmp(strrchr($video,"."),'.asx') && strcasecmp(strrchr($video,"."),'.flv')
                  && strcasecmp(strrchr($video,"."),'.dat') && strcasecmp(strrchr($video,"."),'.mkv') && strcasecmp(strrchr($video,"."),'.mp4')){  //파일 확장자 체크하기  mov,

            //확장자가 잘못됐을 경우, error 값을 1로하고 업로드 페이지로 돌려보낸다
            echo '<script type="text/javascript">'.'location.replace("http://'.$localhost.'/archive/upload.php?error=1");'.'</script>';
            exit;
          }

          $videoTmp = $_FILES['video']['tmp_name'][$i];
          $videoSize = $_FILES['video']['size'][$i];
          $videoSize = ($videoSize/1024)/1024;
          $videoSize = round($videoSize, 2);
          
          $videoName = 'video'.$key.'_'.Date("YmdHis",time());
          // 여러 개의 파일일때
          if(count($_FILES['video']['name'])>1){
            $videoName = $videoName.'_'.($i+1);
            $videoName = $videoName.strrchr($video,".");
            // 제목에 index를 붙여서 db에 저장.
            $title_i=$title.'_'.($i+1);
            $query = "INSERT INTO tb_video (shoot_date, title, company, place, cameraman, equipment, detail, extra, path, size, creater_key, group_key)".
                "VALUES ('$date', '$title_i', '$company', '$place', '$cameraman', '$equipment', '$detail', '$extra', '$videoName' ,'$videoSize', '$creater_key', '$time')";
          }
          // 파일이 한개 일때
          else{
            $videoName = $videoName.strrchr($video,".");
            $query = "INSERT INTO tb_video (shoot_date, title, company, place, cameraman, equipment, detail, extra, path, size, creater_key, group_key)".
                "VALUES ('$date', '$title', '$company', '$place', '$cameraman', '$equipment', '$detail', '$extra', '$videoName' ,'$videoSize', '$creater_key', '$time')";
          }
          $videoPath = UPLOADPATH.basename($videoName);

          mysqli_query($conn, $query)
           or die('Error querying database.');
          move_uploaded_file($videoTmp, $videoPath);
        }
        else{
          echo '<script type="text/javascript">'.'location.replace("http://'.$localhost.'/archive/upload.php?error=1");'.'</script>';
          exit;
        }
      }
    }
    else{
      echo '<script type="text/javascript">'.'location.replace("http://'.$localhost.'/archive/upload.php?error=1");'.'</script>';
      exit;
    }

    // 파일 제어
    if(count($_FILES['file']['name'])>=1){
      for($i=0; $i<count($_FILES['file']['name']); $i++) {
        if($_FILES['file']['size'][$i] && !$_FILES['file']['error'][$i]){
          $file = $_FILES['file']['name'][$i];
          $fileTmp = $_FILES['file']['tmp_name'][$i];
          $fileName = 'file'.$key.'_'.Date("YmdHis",time());
          // 여러 개의 파일일때
          if(count($_FILES['file']['name'])>1){
            $fileName = $fileName.'_'.($i+1);
          }
          $fileName = $fileName.strrchr($file,".");
          $filePath = FILEPATH.basename($fileName);

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
