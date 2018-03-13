<?php
include("conn/conn.php");
session_start();

if(isset($_POST["submit"]) && $_POST["submit"] == "确认修改"){
	  $pwd2 = $_POST['pwd2'];
    $pwd1 = $_POST['pwd1'];
    if ($pwd2 !== $pwd1) {
      echo "<script type='text/javascript'>alert('密码输入不一致');history.back();</script>";
    }
     if(strlen($pwd2) < 5){
      echo "<script type='text/javascript'>alert('密码不合法');history.back();</script>";
    }
    
    $sql ="update user set password='$pwd2' where username ='$_SESSION[username]'";  
    $result = mysqli_query($conn,$sql);
    if ($result) {
           echo "<script type='text/javascript'>alert('修改成功');location.href='login.php'; </script>";
    }else{
            echo "<script type='text/javascript'>alert('修改失败');location.href='password.php'; </script>";
    }

}

?>