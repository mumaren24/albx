<?php
require_once '../../config.php';
require_once '../../functions.php';
// 操作数据库
// 接收ajax传来的 name slug classname id
$name=$_POST['name'];
$slug=$_POST['slug'];
$classname=$_POST['classname'];
$id=$_POST['id'];
// 连接数据库
$connect=connect();
// 准备sql语句
$sql="update categories 
set name='{$name}',slug='{$slug}',classname='{$classname}' 
where  id={$id}";
// 执行
$queryResult=mysqli_query($connect,$sql);//增加删除修改直接返回 true 或者false

$response=["code"=>0,"msg"=>"更新失败"];
if($queryResult){//有数据代表成功了
    $response['code']=1;
    $response['msg']='更新成功';
}
// 以json格式返回
header("content-type:application/json;charset=utf-8");
echo json_encode($response);










?>