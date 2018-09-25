<?php
// 引入config
require_once 'config.php';
require_once 'functions.php';
// 获取 传过来的 文章id 
$postId=$_GET['postId'];
// echo $postId;
// 根据  文章的id  去数据库查询出这篇文章
// 1.连接数据库
$connect=connect();
// 2.准备sql语句
$sql="select p.title,p.created,p.views,p.likes,p.content,c.name,u.nickname 
from posts p
left join categories c on c.id=p.category_id
left join users u on u.id=p.user_id
where p.id={$postId}";
// 3.执行
$postArr=query($connect,$sql);//返回的是二维数组 只有一条数据 
$postData=$postArr[0];//直接取出这篇文章的数据
// print_r($postData);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>阿里百秀-发现生活，发现美!</title>
  <link rel="stylesheet" href="static/assets/css/style.css">
  <link rel="stylesheet" href="static/assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
  <div class="wrapper">
    <div class="topnav">
      <ul>
        <li><a href="javascript:;"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="javascript:;"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="javascript:;"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="javascript:;"><i class="fa fa-gift"></i>美奇迹</a></li>
      </ul>
    </div>
    <!-- 左边 -->
    <?php include './public/_header.php' ?>
    <!-- 右边 -->
    <?php include './public/_aside.php' ?>
    <div class="content">
      <div class="article">
        <div class="breadcrumb">
          <dl>
            <dt>当前位置：</dt>
            <!-- 只有一条数据 直接用就可以 -->
            <dd><a href="javascript:;"><?php  echo $postData['name'] ?></a></dd>
            <dd><?php  echo $postData['title'] ?></dd>
          </dl>
        </div>
        <h2 class="title">
          <a href="javascript:;"><?php  echo $postData['title'] ?></a>
        </h2>
        <div class="meta">
          <span><?php  echo $postData['nickname'] ?> 发布于 <?php  echo $postData['created'] ?></span>
          <span>分类: <a href="javascript:;"><?php  echo $postData['name'] ?></a></span>
          <span>阅读: (<?php  echo $postData['views'] ?>)</span>
          <span>点赞: (<?php  echo $postData['likes'] ?>)</span>
        </div>
        <div class="neirong">
          <?php  echo $postData['content'] ?>
        </div>
      </div>
      <div class="panel hots">
        <h3>热门推荐</h3>
        <ul>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/hots_2.jpg" alt="">
              <span>星球大战:原力觉醒视频演示 电影票68</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/hots_3.jpg" alt="">
              <span>你敢骑吗？全球第一辆全功能3D打印摩托车亮相</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/hots_4.jpg" alt="">
              <span>又现酒窝夹笔盖新技能 城里人是不让人活了！</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/hots_5.jpg" alt="">
              <span>实在太邪恶！照亮妹纸绝对领域与私处</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
</body>
</html>
