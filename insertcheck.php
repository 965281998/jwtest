<?php
	include("conn/conn.php");
	session_start();

    if(isset($_POST["submit"]) && $_POST["submit"] == "提交"){
        $colId = $_POST["colId"];
        $title = trim($_POST["title"]);
        $author = trim($_POST["author"]);
        $smallimg = $_POST["smallimg"];
        $content = $_POST["content"];

        $sql = "INSERT INTO production (classify,title,author,content) VALUES ('$colId','$title','$author','$content')";
        $result = mysqli_query($conn,$sql);

        if($result){
        	echo "<script>alert('注册成功');location.href='insert.php';</script>";
        }else{
			echo "<script>alert('注册失败');history.go(-1);</script>";
		}
        
    }else{
		echo "<script>alert('未提交成功');history.go(-1);</script>";
	}
      
?>