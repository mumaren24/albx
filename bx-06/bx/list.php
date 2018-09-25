<?php
// 1.引入config.php
require_once 'config.php';
// 要使用先引入functions.php 
require_once 'functions.php';
// 查询出 当前点击的分类的 文章
// 获取当前 分类的id
$categoryId=$_GET['categoryId'];// echo $categoryId;
// 查询这个分类的文章
// 1、连接数据库
// $connect=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
$connect=connect();
// 2.准备sql语句 根据点击的 分类 id 加上where条件查询出来
$sql="select p.id,p.title,p.feature
,p.created,p.content,p.views,p.likes,c.name,u.nickname
,(select count(*) from comments where post_id=p.id) as commentsCount
from posts p
left join categories c on p.category_id=c.id
left join users u on p.user_id=u.id
where p.category_id={$categoryId}
order by p.created desc
limit 0,10
";
// 3 执行sql语句
$postArr=query($connect,$sql);//返回的二维数组
// $postResult=mysqli_query($connect,$sql);//查询返回的是结果集 还不能用 要转化成二维数组
// $postArr=[];
// while($row=mysqli_fetch_assoc($postResult)){
//   $postArr[]=$row;//把一行一行的 小数组 加到 大数组里面
// }
// print_r($postArr);//二维数组
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
        <li><a href="list.php"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="list.php"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="list.php"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="list.php"><i class="fa fa-gift"></i>美奇迹</a></li>
      </ul>
    </div>
    <!-- 左边 -->
    <?php include './public/_header.php' ?>
    <!-- 右边 -->
    <?php include './public/_aside.php' ?>
    <div class="content">
      <div class="panel new">
        <!-- 因为都是同一个分类 所以随便拿出一条来用 -->
        <h3><?php echo $postArr[0]['name']   ?></h3>
        <?php  foreach($postArr as $value): ?>
          <div class="entry">
            <div class="head">
              <a href="detail.php?postId=<?php echo $value['id'] ?>"><?php echo $value['title']  ?></a>
            </div>
            <div class="main">
              <p class="info"><?php echo $value['nickname']  ?> 发表于 <?php echo $value['created']  ?></p>
              <p class="brief"><?php echo $value['content']  ?></p>
              <p class="extra">
                <span class="reading">阅读(<?php echo $value['views']  ?>)</span>
                <span class="comment">评论(<?php echo $value['commentsCount']  ?>)</span>
                <a href="detail.php" class="like">
                  <i class="fa fa-thumbs-up"></i>
                  <span>赞(<?php echo $value['likes']  ?>)</span>
                </a>
                <a href="javascript:;" class="tags">
                  分类：<span><?php echo $value['name']  ?></span>
                </a>
              </p>
              <a href="javascript:;" class="thumb">
                <img src="static/uploads/hots_2.jpg" alt="">
              </a>
            </div>
          </div>
        <?php  endforeach; ?>
        
        <div class="loadmore">
          <span class="btn"> 加载更多</span>
      </div>
      </div>
    </div>
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
  <!-- list.php 1 先引入jq -->
  <script src="./static/assets/vendors/jquery/jquery.min.js"></script>
  <script>
    // 点击 加载更多 按钮  发送ajax  获取 下次的 十条数据 追加到页面上
    var currentPage=1;//默认为1 每点一次加1
    $(".loadmore .btn").on("click",function(){
      // 发送ajax获取对应分类的十条文章数据
      //jq的方法已经封装使用JSON.parse给你转了
      //js里面没有$_GET了 1.获取当前分类id 传到php
      currentPage++;//点击加载更多 就获取下一次数据 要+1
      var categoryId=location.search.split("=")[1];
      $.ajax({
         type:"post",
         url:"api/_getMorePost.php",
         data:{
           "categoryId":categoryId,
           "currentPage":currentPage,
           "pageSize":10
           },
        // dataType:"json",php写了header这就不用写了
         success:function(res){
            console.log(res);
            if(res.code==1){//1代表成功
              // 循环拿到的十条数据  生成html追加到页面上
              var data=res.data;//数组
              var str='';
              $.each(data,function(index,val){//index是索引 val是数组里面的每一项值 对象
                  // console.log(val)
                 str+=`<div class="entry">
                          <div class="head">
                            <a href="detail.php">${val.title}</a>
                          </div>
                          <div class="main">
                            <p class="info">${val.nickname} 发表于 ${val.created}</p>
                            <p class="brief">${val.content}</p>
                            <p class="extra">
                              <span class="reading">阅读(${val.views})</span>
                              <span class="comment">评论(${val.commentsCount})</span>
                              <a href="detail.php" class="like">
                                <i class="fa fa-thumbs-up"></i>
                                <span>赞(${val.likes})</span>
                              </a>
                              <a href="javascript:;" class="tags">
                                分类：<span>${val.name}</span>
                              </a>
                            </p>
                            <a href="javascript:;" class="thumb">
                              <img src="static/uploads/hots_2.jpg" alt="">
                            </a>
                          </div>
                       </div>`;
              
              })
              //循环完以及 拼接好很多div了 把str这个字符串 放到页面上
              //$(str) 可以把字符串变成jq对象  $(str).insertBefore('.loadmore') jq的方法 
              $(str).insertBefore('.loadmore');

            }
         }
      })
    })
  
  </script>
</body>
</html>