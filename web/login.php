<?php
require('common.php');
require('ssp.php');
session_start();

$error_msg = "";

if(!isset($_SESSION['user'])){
    if(isset($_POST['submit']) and isset($_POST['username']) and isset($_POST['password']) and $_POST['username'] != '' and $_POST['password'] != ''){
        $auth1 = sha1($_POST['username']);
        $auth2 = sha1($_POST['password']);
        $sql = "select id from user where auth1='" . $auth1 . "' and auth2='" . $auth2 . "'";
        $data = SSP::simple('acl.db', $sql);
        if(count($data)==1){
            $_SESSION['user'] = $data[0][0];
            header('Location: index.php');
        }else{
            $error_msg = '用户名或密码错误';
        }
    }
}else{
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="bookmark" href="/favicon.ico" />
    <title>若海数据 - 用户登录</title>
    <?php echo $bd_stat; ?>
</head>
<body>
<form method="post" action="login.php">
    <fieldset style="width:90%;">
        <legend>用户登录</legend>
        <table style="text-align:right;">
            <tr><td>用户名</td><td><input type="text" id="username" name="username" value="<?php if(isset($_POST['username'])){ echo $_POST['username']; } ?>" /></td></tr>
            <tr><td>密码</td><td><input type="password" id="password" name="password" /></td></tr>
            <tr><td></td><td><input type="submit" value="登录" name="submit"/></td></tr>
        </table>
        <span style="color: green">本站点提供各种金融数据分享</span><br />
        <span style="color: green">请使用IE9以上版本浏览器，或最新版Firefox、Chrome浏览器进行登录</span><br />
        <span style="color: green">测试用户的用户名和密码都是test</span><br />
    <?php echo '<span style="color: red">'.$error_msg.'</span>'; ?>
    </fieldset>
</form>
</body>
</html>
