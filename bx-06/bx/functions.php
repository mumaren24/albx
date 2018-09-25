<?php
// 封装判断 登录的 代码
function checkLogin(){
    // 打开这个页面 应该判断一下 有没有登录过 如果没有请跳转到登录页面去登录
    session_start();//使用session一定先写这句话 开启
    // 没有isLogin或者不等于1 那么肯定没有登录
    if(!isset($_SESSION['isLogin']) ||$_SESSION['isLogin']!=1){
        // 就代表没有登录 跳转到login.php
        header("location:login.php");
    }
}

// 连接数据库
function connect(){
    $connect=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
    return $connect;
}
// connect()
// 查询
function query($connect,$sql){
    $result=mysqli_query($connect,$sql);//查询返回的结果集
     return fetch($result);
}
// 把结果集转化成 二维数组
function fetch($result){
    $arr=[];
    while($row=mysqli_fetch_assoc($result)){
        $arr[]=$row;//把一行一行的小数组 放到大数组
    }
    return $arr;//二维数组
}




?>