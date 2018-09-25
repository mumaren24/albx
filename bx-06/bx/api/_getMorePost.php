<?php
// 查询对应的 十条数据 返回给前端
// 1 分类要对应好
// 引入文件
require_once '../config.php';
require_once '../functions.php';
// 查询返回对应分类数据的十条数据
$categoryId=$_POST["categoryId"];//获取传来的分类id
$currentPage=$_POST['currentPage'];// 获取是第几次
$pageSize=$_POST['pageSize'];// 获取每次显示多少条 10
$offset=($currentPage-1)*$pageSize;//计算出 从哪个索引开始
// 1 连接数据库
$connect=connect();
// 2.准备sql语句
$sql="select p.id,p.title,p.feature
,p.created,p.content,p.views,p.likes,c.name,u.nickname
,(select count(*) from comments where post_id=p.id) as commentsCount
from posts p
left join categories c on p.category_id=c.id
left join users u on p.user_id=u.id
where p.category_id={$categoryId}
order by p.created desc
limit {$offset},{$pageSize}";
// 3,执行sql语句
$postArr=query($connect,$sql);//封装好了 直接是二维数组
header("content-type:application/json;charset=utf8");//告诉前端我是json
//必须使用echo 我想返回 code 0代表失败 1代表成功 msg 标识信息 data 数据存在这 
// 为了格式好看 容易区分成功还是失败
$response=["code"=>0,"msg"=>"操作失败"];//数组
if($postArr){//有数据代表成功了
    $response["code"]=1;
    $response["msg"]="查询成功";
    $response["data"]=$postArr;//数组存在这里
}
echo json_encode($response);//把数组变成 长的很像数组或者对象的字符串



?>