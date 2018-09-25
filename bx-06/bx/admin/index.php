<?php
// // 打开这个页面 应该判断一下 有没有登录过 如果没有请跳转到登录页面去登录
// session_start();//使用session一定先写这句话 开启
// // 没有isLogin或者不等于1 那么肯定没有登录
// if(!isset($_SESSION['isLogin']) ||$_SESSION['isLogin']!=1){
//   // 就代表没有登录 跳转到login.php
//   header("location:login.php");
// }
// 每个页面都需要判断 以后写完项目在做，免得经常登录麻烦
require_once '../config.php';
require_once '../functions.php';
// 可以调用刚刚封装的 checkLogin方法
checkLogin();


?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
     <!-- 右上部分 -->
     <!-- 引入 -->
     <?php  include 'public/_navbar.php'; ?>
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.php" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong>10</strong>篇文章（<strong>2</strong>篇草稿）</li>
              <li class="list-group-item"><strong>6</strong>个分类</li>
              <li class="list-group-item"><strong>5</strong>条评论（<strong>1</strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>
  <?php  
  // 只要单词 不是那三个 肯定就不展开 随便给 不过为了有意义给index
    $current_page='index';
  ?>
  <!-- 左边部分 -->
  <?php include 'public/_aside.php'; ?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
