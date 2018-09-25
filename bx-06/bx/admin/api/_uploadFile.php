<?php

// print_r($_FILES);

// Array
// (
//     [abc] => Array
//         (
//             [name] => banner300.jpg 文件名字
//             [type] => image/jpeg 类型
//             [tmp_name] => C:\Windows\phpBEA.tmp 临时文件
//             [error] => 0  0代表成功
//             [size] => 46328 大小
//         )
// )
// move_uploaded_file(临时文件,要上传到的文件夹+文件名字)
$file=$_FILES['abc'];
// 获取后缀名
$ext=strrchr($file['name'],'.');//从名字里面 找到 . 把 .jpg 截出来
// 先生成一个 不重复的名字  php 的 uniqid() 方法  生成一个不会重复的随机数
$fileName=time().rand(10000,99999).$ext;//124235782578.jpg
// move_uploaded_file 上传成功 返回true  失败返回false
$bool=move_uploaded_file(
    $file['tmp_name'],
    '../../static/uploads/'.$fileName
);

$response=["code"=>0,"msg"=>"上传失败"];
if($bool){//true代表成功了
    $response['code']=1;
    $response['msg']='上传成功';
    // 顺便返回 图片的路径 前端要拿来显示
    $response['src']='../static/uploads/'.$fileName;
}
// 以json格式返回
header("content-type:application/json;charset=utf-8");
echo json_encode($response);



?>