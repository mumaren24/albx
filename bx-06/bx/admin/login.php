<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap">
      <img class="avatar" src="../static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong> <span id="msg">用户名或密码错误！</span>
      </div>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" class="form-control" placeholder="密码">
      </div>
      <span id="btn-login" class="btn btn-primary btn-block">登 录</span>
    </form>
  </div>
  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script>
    //入口函数 建议写上 
    // 点击登录按钮  获取邮箱和密码 判断格式是否正确 如果正确 发送ajax到后台php
    $(function(){
      // 点击登录按钮
      $("#btn-login").on("click",function(){
        // 获取邮箱和密码
        var email=$("#email").val();
        var password=$("#password").val();
        // 判断邮箱格式是否正确  74872648@qq.com \w数字字母下划线 \d数字 .的意思任意字符 \. [.] 真的就是.
        var reg=/^\w+@\w+\.\w+$/;
        // var reg=/^\w+@\w+[.]\w+$/; reg.test(email) 匹配 如果正确返回true 不正确返回false
        if(!reg.test(email)){//不正确
          $("#msg").text('请输入正确的邮箱'); // 提示邮箱错误
          $(".alert").show(); // 显示div
          return;
        }
        var pReg=/\w{6,20}/; // 判断密码 要求 6-20位  手机号码 /1\d{10}/
        if(!pReg.test(password)){//不正确
          $("#msg").text('密码长度不正确'); // 提示密码错误
          $(".alert").show();// 显示div
          return;
        }
        // 都没错 就把邮箱和密码发送ajax到后台php
        $.ajax({
          type:"post",
          url:"api/_userLogin.php",
          data:{"email":email,"password":password},
          success:function(res){
            // console.log(res)
            //判断成功或失败
            if(res.code==1){//成功了
                alert("登录成功");
                // js跳转到首页
                location.href="index.php"
            }else{//失败
              $("#msg").text('邮箱密码错误登录失败啦');
              $(".alert").show();// 显示div
            }
          }
        })

      })  

      
    })
  
  </script>
</body>
</html>
