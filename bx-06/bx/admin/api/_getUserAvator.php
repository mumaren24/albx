<?php
require_once '../../config.php';
require_once '../../functions.php';
// 通过登录的 用户id  去数据库查询用户名和头像返回
// 登录的时候在session存了，获取就可以从session拿 用户id
session_start();
$userId=$_SESSION['user_id'];
// 连接数据库
$connect=connect();
// 准备sql语句
$sql="select * from users where id={$userId}";
// 执行
$queryResult=query($connect,$sql);//二维数组
// print_r($queryResult);
$response=["code"=>0,"msg"=>"查询头像失败"];
if($queryResult){//有数据代表成功了
    $response['code']=1;
    $response['msg']='查询头像成功';
    // 用户名和头像返回
    $response['avatar']=$queryResult[0]['avatar'];
    $response['nickname']=$queryResult[0]['nickname'];

}
// 以json格式返回
header("content-type:application/json;charset=utf-8");
echo json_encode($response);



?>