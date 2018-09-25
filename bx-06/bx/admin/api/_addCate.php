<?php
require_once '../../config.php';
require_once '../../functions.php';
// 操作数据库
// 接收传来的 name 分类名称
$name=$_POST['name'];
// $slug=$_POST['slug'];
// 判断分类名字 是否已经存在
// 连接数据库
$connect=connect();
// 准备sql语句 查询分类在数据库的条数
$countSql="select count(*) as count from categories 
where name='{$name}'";
// 执行
$countResult=query($connect,$countSql);//二维数组
// print_r($countResult);
$count=$countResult[0]['count'];//$count值0条证明没有 1条就代表有

$response=["code"=>0,"msg"=>"操作失败"];
if($count>0){//有一个名字一样的 已经存在了
    $response['msg']="分类已经存在啦，请重新输入";
}else{//不存在这个分类 就可以 添加到数据库
// insert into 插入到数据库
// print_r($_POST);//数组
$keys=array_keys($_POST);//array_keys(数组) 返回一个 数组的 键 组成的新数组
// print_r($keys);//[name slug classname]
//implode(",",$keys) 以逗号 拆分数组 变成一个字符串
$keyStr=implode(",",$keys);
// echo $keyStr;//name,slug,classname
$values=array_values($_POST);//array_keys(数组) 返回一个 数组的 值 组成的新数组
// print_r($values);
$valueStr=implode("','",$values);//以 ',' 拆分
// echo $valueStr;
// 假装成功一下 明天再写插入 老师写的复杂 (目的 拼接出下面的sql语句)
$addSql="insert into categories(".$keyStr.") values('".$valueStr."')";
// 执行
$addResult=mysqli_query($connect,$addSql);
if($addResult){//true 成功
    $response['code']=1;
    $response['msg']="添加成功";
}
// echo $addSql;
// $addSql="insert into categories(name,slug,classname) values('明星','mx','fa-mx')";
   
}
// 以json格式返回
header("content-type:application/json;charset=utf-8");
echo json_encode($response);










?>