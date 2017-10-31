<!DOCTYPE html>

<?php
	  include 'property.php';
    session_start();
    if(!isset($_SESSION['key_num'])){  //로그인 했던 사용자가 아닐경우 로그인 페이지로 보내기
      echo '<script type="text/javascript">'.
              'location.replace("http://'.$localhost.'/archive/login.php");'.
                '</script>';
    }
    if(isset($_GET['contents']))
      $_SESSION['contents'] = $_GET['contents'];

    $key = $_SESSION['key_num'];  //현재 접속 계정 key 받아오기
    $name = $_SESSION['name'];  //현재 접속한 사람의 이름 받아오기
    $level = $_SESSION['level'];  //현재 접속한 사람의 레벨 받아오기
    $contents = $_SESSION['contents'];
    $page = 0;

    if(isset($_GET['page']))
        $page = $_GET['page'];

    if(isset($_GET['viewNum']))
        $viewNum = $_GET['viewNum'];

    if(!isset($_GET['page']) && !isset($_GET['viewNum']))
        echo '<script>location.href="http://'.$localhost.'/archive/main.php?page=0&viewNum=0"</script>';

    $searchText = "";
    $searchText2 = "";

    if(isset($_GET['searchPre']))
      $searchText = $_GET['searchPre'];
    if(isset($_GET['searchPre2']))
      $searchText2 = $_GET['searchPre2'];
    else
      $searchText2 = "";

    if(isset($_POST['searchBtn']))
      $searchMode = $_POST['searchBtn'];
    else
      $searchMode = 0;

    if(isset($_POST['searchText'])){
      if($searchMode == "d")
        $searchText2 = $searchText2 . " " .  $_POST['searchText'];
      else if($searchMode == "a")
        $searchText = $searchText . " " . $_POST['searchText'];
      else if($searchMode == "s"){
        $searchText = $_POST['searchText'];
        $searchText2 = "";
      }
    }

    if(isset($_SESSION['order']))
      $order = $_SESSION['order'];
    else
      $order = 1;

    if(isset($_GET['order'])){
       if($order == $_GET['order'])
         $order = $_GET['order'] + 1;
       else
         $order = $_GET['order'];
       $_SESSION["order"] = $order;
    }

?>

<html>
<head>
<style type="text/css">
table {table-layout: fixed; /*테이블 내에서 <td>의 넓이,높이를 고정한다.*/}
table th {
  text-align: center;
}
table td {
    width:100%; /* width값을 주어야 ...(말줄임)가 적용된다. */
    overflow: hidden;
    text-overflow:ellipsis; /*overflow: hidden; 속성과 같이 써줘야 말줄임 기능이 적용된다.*/
    white-space:nowrap; /*<td>보다 내용이 길경우 줄바꿈 되는것을 막아준다.*/
    text-align: center;
}
</style>

<style>
#pagebar {text-align:center;}
#pagebar li {display:inline;}

table tr td a {
    display:block;
    height:100%;
    width:100%;
}
</style>

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

  <script type="text/javascript">
    function visible(){
      var object = document.getElementById("category");

      object.style.display = "block";
    }

    function invisible(){
      var object = document.getElementById("category");

      object.style.display = "none";
    }

    //make new windows on the position that you want
    w=1100;
		h=800;

		Left=(screen.width-w)/2;
		Top=(screen.height-h)/2-60;

		function popup_upload(){
			window.open(
				"http://<?php echo $localhost ?>/archive/upload.php",
				"Up",
				"width="+w+",height="+h+",top="+Top+",left="+Left+", scrollbars=no");
		}
  </script>

</head>
<body>
	<header>
    <ul class="nav nav-tabs">
      <a class="navbar-brand" href="http://<?php echo $localhost ?>" style="padding-top: 0px;"><img height="45px" src="http://<?php echo $localhost ?>/image/logo.png"></a>
      <li role="presentation"><a href="http://<?php echo $localhost ?>/archive/main.php">Archive</a></li>
      <!-- <li role="presentation" class="active main" onmouseover="javascript:visible()"><a href="http://<?php echo $localhost ?>/archive/main.php">Archive</a></li> -->

      <?php
        if($level == 2 || $level == 1){
          echo '<li role="presentation" ><a href="#" onclick="popup_upload();">Upload</a></li>';
        }
      ?>

      <?php
        if($level == 1){
          echo '<li role="presentation" ><a href="http://'.$localhost.'/archive/admin.php">Admin</a></li>';
        }
      ?>

      <?php
        echo '<p class="col-md-offset-9" style="margin-top: 10px">안녕하세요 '.$name.' 님! &nbsp
                <a href="http://'.$localhost.'/archive/logout.php">logout</a></p>'
      ?>
    </ul>
	</header>

  <!-- <div>
  <ul id="category" style="display: none" onmouseover="javascript:visible()" onmouseout="javascript:invisible()" class="category nav nav-pills col-md-offset-1">
    <li role="presentation" class="active"><a href="#">방산</a></li>
    <li role="presentation"><a href="#">코람데오</a></li>
    <li role="presentation"><a href="#">4D</a></li>
    <li role="presentation"><a href="#">인쇄</a></li>
    <li role="presentation"><a href="#">0000</a></li>
  </ul>
  </div> -->

  <form class="form-horizontal" <?php echo 'action="http://<?php echo $localhost ?>/archive/main.php?page=0&searchPre='.$searchText.'&searchPre2='.$searchText2.'"' ?> method="post" style="margin-top: 8vh; margin-bottom: 15vh;">

  <div class="col-md-1"></div>
    <div class="col-md-4">

    <button class="btn btn-default" type="button" id="dropdownMenu1" aria-expanded="true">
      &nbsp 업체 &nbsp
      <span class="caret"></span>
    </button>

      <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
        <?php
        for($i = 1; $i < 5; $i++){
          $contentsNum = $i * 3;
          echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="http://'.$localhost.'/archive/main.php?contents='.$contentsNum.'">'.$contentsNum.'</a></li>';
        }
        ?>
      </ul>
      <button class="btn btn-default" type="button" id="dropdownMenu1" aria-expanded="true">
        &nbsp 촬영장소 &nbsp
        <span class="caret"></span>
      </button>

        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
          <?php
          for($i = 1; $i < 5; $i++){
            $contentsNum = $i * 3;
            echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="http://'.$localhost.'/archive/main.php?contents='.$contentsNum.'">'.$contentsNum.'</a></li>';
          }
          ?>
        </ul>
        <button class="btn btn-default" type="button" id="dropdownMenu1" aria-expanded="true">
          &nbsp 촬영일 &nbsp
          <span class="caret"></span>
        </button>

          <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
            <?php
            for($i = 1; $i < 5; $i++){
              $contentsNum = $i * 3;
              echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="http://'.$localhost.'/archive/main.php?contents='.$contentsNum.'">'.$contentsNum.'</a></li>';
            }
            ?>
          </ul>
          <button class="btn btn-default" type="button" id="dropdownMenu1" aria-expanded="true">
            &nbsp 연번 &nbsp
            <span class="caret"></span>
          </button>

            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
              <?php
              for($i = 1; $i < 5; $i++){
                $contentsNum = $i * 3;
                echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="http://'.$localhost.'/archive/main.php?contents='.$contentsNum.'">'.$contentsNum.'</a></li>';
              }
              ?>
            </ul>
    </div>


  <div class="col-md-1">

  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
    &nbsp&nbsp <?php echo $contents ?> &nbsp&nbsp
    <span class="caret"></span>
  </button>

    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
      <?php
      for($i = 1; $i < 5; $i++){
        $contentsNum = $i * 3;
        echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="http://'.$localhost.'/archive/main.php?contents='.$contentsNum.'">'.$contentsNum.'</a></li>';
      }
      ?>
    </ul>
  </div>

    <div class="col-md-3">
      <input type="text" class="form-control" id="searchText" name="searchText" placeholder="<?php if(isset($searchText)) echo $searchText; else echo''; ?>">
    </div>

    <div class="col-md-2">
      <button type="searchBtn" name="searchBtn" value = "s" class="btn btn-default">search</button>
      <button type="searchBtn" name="searchBtn" value = "a" class="btn btn-default">추가</button>
      <button type="searchBtn" name="searchBtn" value = "d" class="btn btn-default">제외</button>
    </div>

  </form>

  <?php
    
    define('UPLOADPATH', 'http://'.$localhost.'/video/');  //동영상 폴더 경로
    define('FILEPATH', 'http://'.$localhost.'/file/');  //동영상 폴더 경로

    //Database 및 table 접근하기
    mysqli_select_db($conn, "archive_db");

    $searchQuery = " WHERE title REGEXP '.'";
    $orderQuery = " ORDER BY ";

    switch($order){
      case 0:
      case 1:
        $orderQuery = $orderQuery . "video_key ";
        break;
      case 2:
      case 3:
        $orderQuery = $orderQuery . "shoot_date ";
        break;
      case 4:
      case 5:
        $orderQuery = $orderQuery . "title ";
        break;
      case 6:
      case 7:
        $orderQuery = $orderQuery . "company ";
        break;
      case 8:
      case 9:
        $orderQuery = $orderQuery . "place ";
        break;
      case 10:
      case 11:
        $orderQuery = $orderQuery . "cameraman ";
        break;
    }

    if($order % 2 == 0)
      $orderQuery = $orderQuery . "ASC";
    else
      $orderQuery = $orderQuery . "DESC";

    if(isset($searchText)){
      $searchToken = explode(' ', $searchText);
      $searchCount = count($searchToken);
      if($searchText != "")
        for($i = 0; $i < $searchCount; $i++){
          $searchQuery = $searchQuery . " AND title REGEXP '" . $searchToken[$i] . "'";
        }
    }

    if(isset($searchText2)){
      $searchToken2 = explode(' ', $searchText2);
      $searchCount2 = count($searchToken2);
      if($searchText2 != "")
        for($i = 0; $i < $searchCount2; $i++){
          if($searchToken2[$i] != "")
            $searchQuery = $searchQuery . " AND title NOT REGEXP '" . $searchToken2[$i] . "'";
        }
    }

    $connect = mysqli_query($conn, 'SELECT * FROM tb_video LEFT JOIN tb_account ON tb_video.creater_key = tb_account.key_num' . $searchQuery. $orderQuery);
    ?>
      <div class="row">
      <div class="col-sm-1"></div>
      <div class="col-sm-10">
      <table class="table table-striped table-bordered table-hover" >
          <thead>
              <tr>
                  <th width = "60" style="cursor:pointer" onclick="location.href='?page=0&order=0<?php echo'&searchPre='.$searchText.'&searchPre2='.$searchText2 ?>'">연번</th>
                  <th style="cursor:pointer" onclick="location.href='?page=0&order=2<?php echo'&searchPre='.$searchText.'&searchPre2='.$searchText2 ?>'">촬영일</th>
                  <th style="cursor:pointer" onclick="location.href='?page=0&order=4<?php echo'&searchPre='.$searchText.'&searchPre2='.$searchText2 ?>'">내용</th>
                  <th style="cursor:pointer" onclick="location.href='?page=0&order=6<?php echo'&searchPre='.$searchText.'&searchPre2='.$searchText2 ?>'">업체</th>
                  <th style="cursor:pointer" onclick="location.href='?page=0&order=8<?php echo'&searchPre='.$searchText.'&searchPre2='.$searchText2 ?>'">촬영장소</th>
                  <th style="cursor:pointer" onclick="location.href='?page=0&order=10<?php echo'&searchPre='.$searchText.'&searchPre2='.$searchText2 ?>'">촬영자</th>
              </tr>
          </thead>
      <?php
      $count=0; //한줄을 세기위한 변수

      while(true){
          $file = mysqli_fetch_assoc($connect);
          if($count < $contents * $page){
            $count++;
            continue;
          }

          if($count >= $contents * ($page+1))
            break;

          $fnum = $count + 1;
          $percentage = $count * 10;
          if($file['video_key']!=null){
            echo '
                  <tbody>
                    <tr style="cursor:pointer;" onclick="location.href=\'http://'.$localhost.'/archive/main.php?page='.$page.'&viewNum='.$count.'\'" onmouseover="window.status=\'http://www.happyjung.com/\'" onmouseout="window.status=\'\'">
                      <td>'.$file['video_key'].'</td>
                      <td>'.$file['shoot_date'].'</td>
                      <td>'.$file['title'].'</td>
                      <td>'.$file['company'].'</td>
                      <td>'.$file['place'].'</td>
                      <td>'.$file['cameraman'].'</td>
                    </tr>
                </tbody>
                ';
            if($count == $viewNum){
                $videoView = $file;
            }
          }else{
            break;
          }

          $count++;

      }
      while($file['video_key']!=null){
        $file = mysqli_fetch_assoc($connect);
        $count++;
      } //전체 개수 받으려고.. 다른거로 대체할 것

      if($count % $contents != 0)
        $count = $count + $contents - ($count % $contents);

      echo '</table>
      </div>
      <div class="col-sm-1"></div>
      </div>';
 ?>

 <div id="pagebar" class="container">

 	<nav>
 	  <ul class="pagination">
 	    <li><a href="#"><span aria-hidden="true">«</span><span class="sr-only">Previous</span></a></li>
       <?php
            if(!isset($searchText))
                $searchText = "";
            if(!isset($searchText2))
                $searchText2 = "";
            for($i = 0; $i < $count/$contents; $i++){
                $pageNum = $i + 1;
                echo '<li><a href="http://'.$localhost.'/archive/main.php?page='.$i.'&searchPre='.$searchText.'&searchPre2='.$searchText2.'">'.$pageNum.'</a></li>';
            }

            // 삭제 과정
            if($_GET['remove']==1){
                $connect = mysqli_query($conn, 'SELECT * FROM tb_video WHERE creater_key = '.$videoView["creater_key"].' AND group_key='.$videoView['group_key']);
                $rowcount = mysqli_num_rows($connect);
                unlink($_SERVER['DOCUMENT_ROOT'].'/video/'.$videoView['path']);

                if($rowcount==1){
                    $connect = mysqli_query($conn, 'SELECT * FROM tb_file WHERE account_key = '.$videoView["creater_key"].' AND group_key = '.$videoView["group_key"]);
                    if($connect){
                    while(true){
                        $file = mysqli_fetch_assoc($connect);
                        if($file==NULL)
                            break;
                        unlink($_SERVER['DOCUMENT_ROOT'].'/file/'.$file['path']);
                        mysqli_query($conn, 'DELETE FROM tb_file WHERE account_key = '.$videoView["creater_key"].' AND group_key = '.$videoView["group_key"]);                        
                        }
                    }
                }
                mysqli_query($conn, 'DELETE FROM tb_video WHERE video_key = '.$videoView["video_key"]);
                echo '<script>location.href="http://'.$localhost.'/archive/main.php"</script>';
            }
       ?>
 	    <li><a href="#"><span aria-hidden="true">»</span><span class="sr-only">Next</span></a></li>
 	  </ul>
 	</nav>

 </div>
 <div class = "row">
   <div class="col-md-offset-1 col-md-5">
     <h3><span class="label label-info">media</span></h3>
   </div>
   <div class="col-md-1">
    <h3><span class="label label-info">information</span></h3>
   </div>
   <div class="col-md-offset-2 col-md-3">
     <p>
        <a href="<?php echo UPLOADPATH.$videoView['path']; //다운로드를 위해서 동영상 url 을 넣어준다 ?>" class="btn btn-primary" role="button" download>다운로드</a>&nbsp&nbsp
        <!-- 작성자이거나 admin의 경우 삭제 가능 -->
        <?php
            if(($key==$videoView['creater_key'] || $_SESSION['level']==1) && $videoView!=NULL){
                $http_host = $_SERVER['HTTP_HOST'];
                $request_uri = $_SERVER['REQUEST_URI'];
                $url = $http_host . $request_uri;
                echo '<a href="#" class="btn btn-danger" role="button" width="20px" onclick="deleteConfirm()">삭제</a>';
            }
        ?>
        <script>
            function deleteConfirm(){
                if(confirm("정말 삭제하시겠습니까?")){
                    location.href = "<?php echo $request_uri ?>" + "&remove=1";
                }
            }
        </script>
     </p>
   </div>
 </div>

 <div class ="row">
 <div class="col-sm-1"></div>
 <div class="col-sm-5">
 <?php
 echo '<div class="thumbnail">
             <video src="'.UPLOADPATH.$videoView['path'].'" width="100%"  controls></video>
             <div class="title">
             </div>
       </div>
   </div>';
 echo '<div class="col-sm-5">
   <p> 촬영일 : '.$videoView['shoot_date'].' <br/><br/>
       내용 : '.$videoView['title'].' <br/><br/>
       업체 : '.$videoView['company'].' <br/><br/>
       촬영장소 : '.$videoView['place'].' <br/><br/>
       촬영자 : '.$videoView['cameraman'].' <br/><br/>
       촬영장비 : '.$videoView['equipment'].'</p>
       크기 : '.$videoView['size'].' MB<br/><br/>
       업로딩 날짜 : '.$videoView['upload_date'].' <br/><br/>
 </div>';
 ?>
 </div>

 <!-- 파일 출력 -->
 <div class ="row">
 <div class="col-sm-1"></div>
 <div class="col-sm-5">
    <label for="comment">세부내용</label>
    <textarea readonly class="form-control" rows="6" id="comment"><?php printf("%s", $videoView['detail']);?></textarea>
 </div>
 <div class="col-sm-5">
   <table class="table table-striped table-bordered table-hover" >
     <tr>
       <th>파일</th>
     </tr>
     <?php
       $connect = mysqli_query($conn, 'SELECT * FROM tb_file WHERE account_key = '.$videoView["creater_key"].' AND group_key = '.$videoView["group_key"]);
       if($connect){
         while(true){
           $file = mysqli_fetch_assoc($connect);
           if($file==NULL)
            break;
           echo '<tr><td><a href='.FILEPATH.$file['file_name'].' target="_blank">'.$file['file_name'].'</a></td></tr>';
         }
       }
     ?>
   </table>
 </div>
 </div>
 </div>

</body>
</html>
