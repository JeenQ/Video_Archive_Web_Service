<?php
	  include 'dbProperty.php';
  session_start();
  session_destroy();  //session 끝내기

  /* 세션 끝낸 후에 로그인 페이지로 보내기 */
  echo '<script type="text/javascript">'.
          'location.replace("http://localhost/archive/login.php");'.
            '</script>';
?>
