<?php
require_once '../../config.php';
require_once '../../functions.php';
// 查询数据库 所有分类 返回给前端
// 获取页码  获取每页显示多少条
$currentPage=$_POST['currentPage'];
$pageSize=$_POST['pageSize'];
// 计算从哪个索引开始
$offset=($currentPage-1)*$pageSize;
// 连接数据库
$connect=connect();
// 准备sql语句
$sql="select c.author,c.created
,c.content,c.status,p.title
from comments c
left join posts p on c.post_id=p.id
limit {$offset},{$pageSize}";
// 执行s
$queryResult=query($connect,$sql);//二维数组
// 查询总共的条数
$sqlCount="select count(*) as count from comments";
$countArr=query($connect,$sqlCount);//二维数组
$count=$countArr[0]['count'];//507
// 总共的页码 意思就是 最大的页数
$pageCount=ceil($count/$pageSize);

$response=["code"=>0,"msg"=>"查询评论失败"];
if($queryResult){//有数据代表成功了
    $response['code']=1;
    $response['msg']='查询评论成功';
    $response['data']=$queryResult;
    $response['pageCount']=$pageCount;//页码
}
// 以json格式返回
header("content-type:application/json;charset=utf-8");
echo json_encode($response);










?>