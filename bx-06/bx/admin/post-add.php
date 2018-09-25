<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
     <!-- 右上部分 -->
     <!-- 引入 -->
     <?php  include 'public/_navbar.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form id="data-form" class="row">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容"></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong>slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none">
            <input id="feature" class="form-control" name="feature" type="file">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">
              <option value="1">未分类</option>
              <option value="2">潮生活</option>
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
              <option value="published">已发布</option>
            </select>
          </div>
          <div class="form-group">
            <button id="btn-save" class="btn btn-primary" type="button">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <?php
  // 这里的变量下面都可以用的
      $current_page='post-add';
  ?>
  <!-- 左边部分 -->
  <?php include 'public/_aside.php'; ?>

  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <!-- 1 引入对应的js -->
  <script src="../static/assets/vendors/ckeditor/ckeditor.js"></script>
  <script>NProgress.done()</script>

  <script>
    $(function(){
      // 选择文件上传  原生的 onchange 事件  文件选中会触发  下拉框选择 也会触发
      $("#feature").on("change",function(){
        // 获取 要上传的 文件
        // console.dir(this);//this 就是这个框 打印出这个标签里面的所有东西 可以在控制台看见
        // console.log(this.files);//伪数组 ；里面有要上传的文件
        var file=this.files[0];//要上传的那个文件 原生有
        // this 原生 $(this) 转化成jq对象了
        // console.log(file)
        var formdata=new FormData();
        // formdata.append(名字,值) 追加一个 参数
        formdata.append("abc",file);//追加一个 参数 abc 值是 要上传的文件对象
        // 把他通过ajax上传
        $.ajax({
          type:"post",
          url:"api/_uploadFile.php",
          data:formdata,
          // jq的ajax上传文件 必须设置下面两句话 使用原生xhr的方式上传文件
          contentType:false,//不需要设置头部
          processData:false,//
          success:function(res){
            // console.log(res);
            if(res.code==1){//成功了
              // 把图片 设置 src 显示到页面上
              $(".thumbnail").attr("src",res.src).show();
            }
          }
        })
        


      })

      // 2 初始化 富文本编辑器 只要引入了 就有 CKEDITOR 这个
      CKEDITOR.replace("content");

      // 3 点击保存 按钮 把文章的数据 获取 发送到后台 去插入到数据库
      $("#btn-save").on("click",function(){
        // 文本域被隐藏 上面覆盖了一层div 我们修改的值 其实在div里面 所以文本域本身就没有值
        // 所以要想有值 我们需要把div里面的内容 放到 文本域里面去
        // CKEDITOR.instances.文本域的id.updateElement()
        CKEDITOR.instances.content.updateElement();
        // 获取填写的 文章表单数据
        var dataStr=$("#data-form").serialize();
        // console.log(data);
        $.ajax({
          type:"post",
          url:"api/_addPost.php",
          data:dataStr,
          success:function(res){
            console.log(res)
          }
        })
      })


    })
  
  
  </script>
</body>
</html>
