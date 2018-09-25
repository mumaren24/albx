<?php
require_once '../../config.php';
require_once '../../functions.php';
// 查询数据库 所有分类 返回给前端
// 连接数据库
$connect=connect();
// 准备sql语句
$sql="select * from categories";
// 执行
$queryResult=query($connect,$sql);//二维数组

$response=["code"=>0,"msg"=>"查询分类失败"];
if($queryResult){//有数据代表成功了
    $response['code']=1;
    $response['msg']='查询分类成功';
    $response['data']=$queryResult;
}
// 以json格式返回
header("content-type:application/json;charset=utf-8");
echo json_encode($response);










?>