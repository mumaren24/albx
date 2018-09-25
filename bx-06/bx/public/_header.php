<?php
// 查询数据库的 所有分类 循环显示到页面
// mysqli_connect(地址,用户名,密码,数据库名称)
// echo DB_HOST;
//1. 连接数据库
$connect=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
//2. 准备sql语句
$sql="select * from categories where id!=1";
//3. 执行sql语句
$result=mysqli_query($connect,$sql);//查询 返回的是结果集对象 他里面有一行一行的数据// print_r($result);
// 把结果集里面的 一行一行 拿出来 存到大数组里面
// mysqli_fetch_assoc($result) 取出一行一行的数据
$arr=[];
while($row=mysqli_fetch_assoc($result)){//取出一行一行的数据
    // print_r($row);//一行一行的数据 是一个小数组
    $arr[]=$row;//把 小数组 放到大数组里面
}
// print_r($arr);//二维数组 里面有一个一个的小数组
?>
<div class="header">
    <h1 class="logo"><a href="index.php"><img src="static/assets/img/logo.png" alt=""></a></h1>
    <ul class="nav">
        <!-- <li><a href="list.php"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="list.php"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="list.php"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="list.php"><i class="fa fa-gift"></i>美奇迹</a></li> -->
        <!-- 循环数组 生成对应的 分类    $value 就是大数组里面的 每一个小数组-->
        <?php foreach($arr as $value): ?>
            <li><a href="list.php?categoryId=<?php echo $value['id']; ?>"><i class="fa <?php echo $value['classname'] ?>"></i><?php echo $value['name'] ?></a></li>
        <?php endforeach; ?>
    </ul>
    <div class="search">
    <form>
        <input type="text" class="keys" placeholder="输入关键字">
        <input type="submit" class="btn" value="搜索">
    </form>
    </div>
    <div class="slink">
    <a href="javascript:;">链接01</a> | <a href="javascript:;">链接02</a>
    </div>
</div>