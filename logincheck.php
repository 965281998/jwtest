<?php  
    header("Content-Type:text/html;charset=utf-8");

    error_reporting(E_ALL || ~E_NOTICE);
    session_start();

    if(isset($_POST["submit"]) && $_POST["submit"] == "提交")  
    {  
        $user = trim($_POST["username"]); //使用trim移除空格 
        $psw = $_POST["password"];  
        if($user == "" || $psw == "")  
        {  
            echo "<script>alert('请输入用户名或密码！'); history.go(-1);</script>";  
        }  
        else  
        {  
            include("conn/conn.php");
            $sql = "select username,password from user where username = '$_POST[username]' and password = '$_POST[password]'";  
            $result = mysqli_query($conn,$sql);  
            $num = mysqli_num_rows($result);  
            if($num)  
            {   
                $_SESSION["username"]=$_POST[username];
                mysqli_close($conn);
                $row = mysqli_fetch_array($result);  //将数据以索引方式储存在数组中  
                echo $row[0];  
                echo "<script>alert('成功登录'); window.location.href='index.php';</script>";
            }  
            else  
            {  
                mysqli_close($conn);
                echo "<script>alert('用户名或密码不正确！');history.go(-1);</script>";  
            }  
        }  
    }  
    else  
    {  
        echo "<script>alert('提交未成功！'); history.go(-1);</script>";  
    }  
  
?>