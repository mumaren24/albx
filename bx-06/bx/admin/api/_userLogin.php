<?php
require_once '../../config.php';
require_once '../../functions.php';
// 获取传过来的邮箱和密码
$email=$_POST['email'];
$password=$_POST['password'];
// 去数据库查询有没有这个邮箱和密码
// 1 连接数据库
$connect=connect();
// 2.准备sql语句 sql如果是字符串值 必须用单引号包裹
$sql="select * from users 
where email='{$email}' 
and password='{$password}' and status='activated'";
// 3 执行
$queryResult=query($connect,$sql);//二维数组 只不过只有一条
// print_r($queryResult);//只能测试看一看 记得用完就注释掉
$response=["code"=>0,"msg"=>"登录失败"];
if($queryResult){//有数据 成功了
    // 进来这个判断 代表 肯定登录成功 先存一个登录成功的 标志
    session_start();//使用session一定先写这句话 开启
    $_SESSION['isLogin']=1;
    // 顺便存上 刚刚登录的这个人的 id
    $_SESSION['user_id']=$queryResult[0]['id'];//1
    
    $response["code"]=1;
    $response["msg"]="登录成功";
}
// 返回给前端
header("content-type:application/json;charset=utf-8");
echo json_encode($response);



?>