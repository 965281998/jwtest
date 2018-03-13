<?php 
    include("conn/conn.php");
    include ("page.class.php");
    session_start();
    $tmp = !empty($_POST) ? $_POST : $_GET;
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>后台管理</title>
    <link rel="stylesheet" type="text/css" href="css/common.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
    <script type="text/javascript" src="js/libs/modernizr.min.js"></script>
</head>
<body>
<div class="topbar-wrap white">
    <div class="topbar-inner clearfix">
        <div class="topbar-logo-wrap clearfix">
            <h1 class="topbar-logo none"><a href="index.php" class="navbar-brand">后台管理</a></h1>
            <ul class="navbar-list clearfix">
                <li><a class="on" href="index.php">首页</a></li>
                <li><a href="#" target="_blank">网站首页</a></li>
            </ul>
        </div>
        <div class="top-info-wrap">
            <ul class="top-info-list clearfix">
                <li><a href="#"><?php echo $_SESSION["username"]; ?></a></li>
                <li><a href="password.php">修改密码</a></li>
                <li><a href="login.php">退出</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container clearfix">
    <div class="sidebar-wrap">
        <div class="sidebar-title">
            <h1>菜单</h1>
        </div>
        <div class="sidebar-content">
            <ul class="sidebar-list">
                <li>
                    <a href="#"><i class="icon-font">&#xe003;</i>常用操作</a>
                    <ul class="sub-menu">
                        <li><a href="design.php"><i class="icon-font">&#xe008;</i>作品管理</a></li>
                        <li><a href="design.php"><i class="icon-font">&#xe005;</i>博文管理</a></li>
                        <li><a href="design.php"><i class="icon-font">&#xe006;</i>分类管理</a></li>
                        <li><a href="design.php"><i class="icon-font">&#xe004;</i>留言管理</a></li>
                        <li><a href="design.php"><i class="icon-font">&#xe012;</i>评论管理</a></li>
                        <li><a href="design.php"><i class="icon-font">&#xe052;</i>友情链接</a></li>
                        <li><a href="design.php"><i class="icon-font">&#xe033;</i>广告管理</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="icon-font">&#xe018;</i>系统管理</a>
                    <ul class="sub-menu">
                        <li><a href="system.php"><i class="icon-font">&#xe017;</i>系统设置</a></li>
                        <li><a href="system.php"><i class="icon-font">&#xe037;</i>清理缓存</a></li>
                        <li><a href="system.php"><i class="icon-font">&#xe046;</i>数据备份</a></li>
                        <li><a href="system.php"><i class="icon-font">&#xe045;</i>数据还原</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/jscss/admin">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">作品管理</span></div>
        </div>
        <?php
            // if (isset($_POST["sub"]) && $_POST["sub"] == "查询") {
            //     echo $classify = $_POST["search-sort"];
            // }
            if($_POST["search-sort"]=="19"){ 
                $select1 = "selected";
            }elseif ($_POST["search-sort"]=="20") {
                $select2 = "selected";
            }
        ?>
        <div class="search-wrap">
            <div class="search-content">
                <?php echo '<form action="design.php?action=del&page='.$page->page.'" method="post" name="myform" id="myform">' ?>

                    <table class="search-tab">
                        <tr>
                            <th width="120">选择分类:</th>
                            <td>
                                <select name="search-sort" id="">
                                    <option value="">全部</option>
                                    <option value="19" <?php echo $select1; ?> > 精品界面</option>
                                    <option value="20" <?php echo $select2; ?> > 推荐界面</option>
                                </select>
                            </td>
                            <th width="70">关键字:</th>
                            <td><input class="common-text" placeholder="关键字" name="keywords" value="<?php $tmp['keywords']; ?>" id="" type="text"></td>
                            <td><input class="btn btn-primary btn2" name="sub" value="查询" type="submit"></td>
                        </tr>
                    </table>
                <!-- </form> -->
            </div>
        </div>
        

        <div class="result-wrap">
            <!-- <form name="myform" id="myform" method="post"> -->
                <div class="result-title">
                    <div class="result-list">
                        <a href="insert.php"><i class="icon-font"></i>新增作品</a>
                        <?php echo '<a id="batchDel" href="javascript:void(0) design.php?action=del'.$args.'&page='.$page->page.'&id='.$_POST['id[]'].' " onclick="return confirm(\'你确定要删除吗？\')"><i class="icon-font"></i>批量删除</a>' ?>
                        <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th class="tc" width="5%"><input class="allChoose" name="" type="checkbox"></th>
                            <th>排序</th>
                            <th>ID</th>
                            <th>标题</th>
                            <th>审核状态</th>
                            <th>点击</th>
                            <th>发布人</th>
                            <th>更新时间</th>
                            <th>评论</th>
                            <th>操作</th>
                        </tr>
                        <?php
                            
                            if (isset($_POST["sub"]) && $_POST["sub"] == "查询") {
                                $classify = $_POST["search-sort"];

                                }
                                //$_SESSION['classify'] = $classify;
                                //echo $_SESSION['classify'];
                                $whr=array();
                                $args = "";

                                if ($classify) {
                                    $whr[] = "classify like '%{$classify}%'";
                                    $args .= "&classify={$classify}";
                                }
                                
                                if(!empty($tmp['keywords'])) {
                                    $whr[] = "title like '%{$tmp['keywords']}%'";
                    
                                    $args .= "&title={$tmp['keywords']}";
                                }
                                if(!empty($whr)) {
                                    $where = " where ".implode(" and ", $whr);
        
                                } else {
                                    $where = "";
                                }
                                
                                $sql = "select * from production {$where}";
                                // echo $sql;
                                $result = mysqli_query($conn,$sql);

                                $total = mysqli_num_rows($result);
                                //创建分页对象    
                                $num=5;
                                $page=new Page($total,$num, $args);

                                $sql1 = "select * from production {$where} order by id asc {$page->limit}";
                            

                            $result1 = mysqli_query($conn,$sql1);
                            while($array=mysqli_fetch_array($result1)){
                        ?>
                        <tr>
                            <td class="tc"><input name="id[]" value="59" type="checkbox"></td>
                            <td>
                                <input name="ids[]" value="59" type="hidden">
                                <input class="common-input sort-input" name="ord[]" value="0" type="text">
                            </td>
                            <td><?php echo $array['id'] ?></td>
                            <td title="发哥经典"><a target="_blank" href="#" title="发哥经典"><?php echo $array['title'] ?></a>
                            </td>
                            <td>0</td>
                            <td>2</td>
                            <td><?php echo $array['author'] ?></td>
                            <?php
                            echo '<td>'.date("Y-m-d H:i").'</td>';
                            ?>
                            <td></td>
                            <td>
                                <a class="link-update" href="#">修改</a>
                                <?php
                                echo '<a class="link-del" href="design.php?action=del'.$args.'&page='.$page->page.'&id='.$array['id'].'" onclick="return confirm(\'你确定要删除吗？\')">删除</a>'
                                ?>
                            </td>
                        </tr>
                        <?php
                            }
                        
                        
                        ?>
                    </table>
                    <div class="list-page">
                        <?php
                        echo '<form action="design.php?&page='.$page->page.'">';
                        echo '<table border="0" width="900">';
                        echo '<tr><td colspan="9" align="left" >'.$page->fpage().'</td></tr>';
                        echo '</table>';
                        echo '</form>';
                        ?>
                
                    </div>
                </div>
            </form>
            <?php
                //用户是否有动作
                if(isset($_GET['action'])) {
                    //删除图书的动作
                    if($_GET['action'] == "del") {
                        //删除多个
                        if(!empty($_POST['id'])) {
                            $sql = "delete from production where id in(".implode(',', $_POST['id']).")";
                            //echo $_POST['id'];
                        }else {
                            //删除单个
                            $sql = "delete from production where id='{$_GET['id']}'";
                            //echo $_GET['id'];
                        }
            
            
                        $result = mysqli_query($conn,$sql);
                    }
    
                }


            ?>
        </div>
    </div>
    <!--/main-->
</div>
</body>
</html>