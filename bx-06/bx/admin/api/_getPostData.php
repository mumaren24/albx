<?php
require_once '../../config.php';
require_once '../../functions.php';
// 查询数据库 所有文章 返回给前端
// 接收前端传来的 当前页 每页显示10条
$currentPage=$_POST['currentPage'];//页码
$pageSize=$_POST['pageSize'];//10
$status=$_POST['status'];//草稿或者已发布或者已删除
$categoryid=$_POST['categoryid'];//分类
// 从哪开始
$offset=($currentPage-1)*$pageSize;
// 判断是否需要 拼接出 where
$where =" where 1=1 ";
// $status   $categoryid 有可能会传来 all
// 如果是all 不需要拼接 如果不是all 比如是草稿 就需要拼接and p.sta...
if($status!='all'){//不是all就拼接
    $where.=" and p.status='{$status}' ";
}
if($categoryid!='all'){//不是all 就拼接
    $where.=" and p.category_id='{$categoryid}' ";
}
// 连接数据库
$connect=connect();
// 准备sql语句
$sql="select p.id,p.title,p.created
,p.status,c.name,u.nickname
from posts p
left join categories c on p.category_id=c.id
left join users u on p.user_id=u.id
{$where}
limit {$offset},{$pageSize}";
// where p.status='{$status}' and p.category_id={$categoryid}
// 执行
$queryResult=query($connect,$sql);//文章二维数组
// 查询出总条数 如果有条件就加上
$countSql="select count(*) as count from posts p {$where} ";
// echo $countSql;
//执行
$countArr=query($connect,$countSql);//二维数组
$postCount=$countArr[0]['count'];//1004
// 算出 总共多少页
$pageCount=ceil($postCount/$pageSize);//101
$response=["code"=>0,"msg"=>"查询文章失败"];
if($queryResult){//有数据代表成功了
    $response['code']=1;
    $response['msg']='查询文章成功';
    $response['data']=$queryResult;
    $response['pageCount']=$pageCount;
}
// 以json格式返回
header("content-type:application/json;charset=utf-8");
echo json_encode($response);










?>