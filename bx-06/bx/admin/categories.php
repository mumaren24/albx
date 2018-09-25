<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong><span id="msg">发生XXX错误</span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id="data">
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="classname">类名</label>
              <input id="classname" class="form-control" name="classname" type="text" placeholder="classname">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" id="btn-add" type="button">添加</button>
              <button class="btn btn-primary" id="btn-edit" type="button">编辑完成</button>
              <button class="btn btn-primary" id="btn-cancle" type="button">取消编辑</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a id="delAll" class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th>类名</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>八卦</td>
                <td>uncategorized</td>
                <td>fa fa-user</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs edit">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
                </td>
              </tr>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>八卦</td>
                <td>uncategorized</td>
                <td>fa fa-user</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs edit">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
                </td>
              </tr>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>八卦</td>
                <td>uncategorized</td>
                <td>fa fa-user</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs edit">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php
    $current_page='categories';
  ?>
  <!-- 左边部分 -->
  <?php include 'public/_aside.php'; ?>

  
  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script>
    //页面打开  就发送ajax 去php  查询所有分类  循环生成 html 放到页面上 
    $(function(){
      // 发送ajax 获取所有分类 循环生成tr
      $.ajax({
        type:"post",
        url:"api/_getCate.php",
        success:function(res){
          // console.log(res);
          if(res.code==1 ){//成功
            // 循环数组 生成tr放到页面
            var str='';
            var data=res.data;
            $.each(data,function(index,val){//index’索引 val数组的每一项
              str+=`<tr data-categoryid="${val.id}">
                    <td class="text-center"><input type="checkbox"></td>
                    <td>${val.name}</td>
                    <td>${val.slug}</td>
                    <td>${val.classname}</td>
                    <td class="text-center">
                      <a href="javascript:;" data-categoryid="${val.id}" class="btn btn-info btn-xs edit">编辑</a>
                      <a href="javascript:;"  class="btn btn-danger btn-xs del">删除</a>
                    </td>
                  </tr>`
            })
            // 循环完就拼接了很多tr 放到tbody里面
            $("tbody").html(str);
          }
        }
      })

      // 点击添加按钮 获取填写的分类数据  发送ajax给后台 后台拿到数据 insert 插入到数据库
      $("#btn-add").on("click",function(){
        //  获取填写的 名称 slug classname 值
        var name=$("#name").val();
        var slug=$("#slug").val();
        var classname=$("#classname").val();
        // 判断是否为空
        if(name==''){
            $("#msg").text("name不能为空");
            $(".alert").show();
            return;
        }
        if(slug==''){
            $("#msg").text("slug不能为空");
            $(".alert").show();
            return;
        }
        if(classname==''){
            $("#msg").text("classname不能为空");
            $(".alert").show();
            return;
        }
        // 如果不为空 就发送ajax到后台
        $.ajax({
          type:"post",
          url:"api/_addCate.php",
          data:$("#data").serialize(),
          success:function(res){
              // console.log(res)
              // 判断是否存在或者添加是否成功
              if(res.code==0){//失败 提示错误
                $("#msg").text(res.msg);
                $(".alert").show();
              }else{//成功
                  // 提示成功 把添加的这个分类 追加到 表格后面
                  alert("添加成功");
                  var str=`<tr>
                            <td class="text-center"><input type="checkbox"></td>
                            <td>${name}</td>
                            <td>${slug}</td>
                            <td>${classname}</td>
                            <td class="text-center">
                              <a href="javascript:;" class="btn btn-info btn-xs edit">编辑</a>
                              <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
                            </td>
                          </tr>`
                  $(str).appendTo("tbody");// str to dao tbody
                  //添加完成之后 清空表单里面的值
                   $("#name").val('');
                  $("#slug").val('');
                  $("#classname").val('');

              }
          }
        })

      })
      //当发ajax的时候 这段代码 早就执行完了 那个时候 $(".edit") 是空
      // 给 空 绑定 click事件
      var nowTr='';// 记住 点击的这一行 tr
      //点击 编辑按钮
      $("tbody").on("click",".edit",function(){
        // 把id 取出来 转存到 编辑完成 按钮上面
        var categoryid=$(this).attr("data-categoryid");//没有第二个参数 就是获取  有 就是设置
        // 转存到 编辑完成 按钮上面
        $("#btn-edit").attr("data-categoryid",categoryid);

        // 记住 点击的这一行 tr
        nowTr=$(this).parents('tr');
        // 隐藏 添加按钮  显示 编辑完成 与 取消编辑 按钮
        $("#btn-add").hide();
        $("#btn-edit").show();
        $("#btn-cancle").show();
        // 把点击 的那行 的数据 填到表单里面
        // $(this)  点谁 就是谁  这里是 编辑那个a  parent() 父亲  parents('tr') 祖先 tr
                //  a      祖先tr         孩子   索引1的孩子 的值  
        var name=$(this).parents('tr').children().eq(1).text();
        var slug=$(this).parents('tr').children().eq(2).text();
        var classname=$(this).parents('tr').children().eq(3).text();
        // 填到表单里面
        $("#name").val(name);
        $("#slug").val(slug);
        $("#classname").val(classname);
      })

      // 点击编辑完成
      $("#btn-edit").on("click",function(){
        // 把id 和 修改后的 数据 一起 发送ajax到后台 后台去数据库修改
        var categoryid=$(this).attr("data-categoryid");//没有第二个参数 就是获取  有 就是设置
        // 获取修改后的 表单值
        var name= $("#name").val();
        var slug= $("#slug").val();
        var classname= $("#classname").val();
        // 发送ajax到后台
        $.ajax({
          type:"post",
          url:"api/_updateCate.php",
          data:{ 
            "name":name,
            "slug":slug,
            "classname":classname,
            "id":categoryid 
          },
          success:function(res){
            // console.log(res)
            //发送ajax成功之后 把表单的值 填写到 对应的表格里面
            if(res.code==1){//更新成功了
              alert('更新成功');
              // 把表单的值 填写到nowTr 刚刚记住的那个tr里面
              nowTr.children().eq(1).text(name);
              nowTr.children().eq(2).text(slug);
              nowTr.children().eq(3).text(classname);
              // 清空表单 显示添加按钮 隐藏 编辑完成与取消编辑
              $("#name").val('')
              $("#slug").val('')
              $("#classname").val('')
              $("#btn-add").show();
              $("#btn-edit").hide();
              $("#btn-cancle").hide();
            }

          }
        })
      })

      // 点击 取消编辑按钮 
      $("#btn-cancle").on("click",function(){
        // 清空表单数据  
        $("#name").val('')
        $("#slug").val('')
        $("#classname").val('')
        // 显示添加按钮 隐藏 编辑完成与取消编辑
        $("#btn-add").show();
        $("#btn-edit").hide();
        $("#btn-cancle").hide();
      })

      // 单个 删除
      $("tbody").on("click",".del",function(){
          // 点击删除 获取当前点击的这行id  发送到后台  后台去数据库删除
         var id=$(this).parents("tr").attr("data-categoryid");
         // 发送到后台  后台去数据库删除
        //  var that=this;
        var row=$(this).parents("tr");//提前把tr 赋值 给row
         $.ajax({
           type:"post",
           url:"api/_delCate.php",
           data:{"id":id},
           success:function(res){
            //  console.log(res);
            if(res.code==1){
              // 把删除的那个tr 移出掉
              // $(that).parents("tr").remove();
              row.remove();//自杀
              // console.log(this) 
              // 这里的this不是我们想的删除按钮了 可以提前赋值
            }
           }
         })
      })

      // 点击 全选框 thead里面的
      $("thead input").on("click",function(){
        //  console.log($(this).prop("checked"))
        var status=$(this).prop("checked");
        // tbody里面的 复选框 要一样
        $("tbody input").prop("checked",status);
        if(status){//全选的话就显示
           $("#delAll").show();//显示批量删除按钮
        }else{
           $("#delAll").hide();
        }
      })
      // tbody里面的 复选框 
      $("tbody").on("click","input",function(){
        // 如果 全部选中了  那么 全选框 就要选中  如果没有全选中  全选框就不选
        var all=$("thead input");//全选框
        var cks=$("tbody input");//tbody里面的 所有 复选框 
        // cks.size() size 个数  有多少个 类似 length  $("tbody input:checked") :checked选中的框
        // if(cks.size()==$("tbody input:checked").size()){// 所有框 ==所有选中的框 
        //     all.prop("checked",true); // 如果 所有的框  和  所有的 选中的框 个数相等  证明 全部选中了
        // }else{
        //   all.prop("checked",false);
        // }
        all.prop("checked", cks.size()==$("tbody input:checked").size() )
        if($("tbody input:checked").size()>=2){// 如果 选中的 超过两个 证明 你想 批量删除
          $("#delAll").show();//显示批量删除按钮
        }else{
          $("#delAll").hide();
        }
      })

      // 真正的 点击 批量删除  删除对应数据
      $("#delAll").on("click",function(){
        // 点击批量删除 获取 选中要删除的所有 id  发送到后台
        // 获取 选中 要删除的所有 id  $("tbody input:checked") 所有选中的框
        var ids=[];//存所有id的数组
        var cks=$("tbody input:checked");//所有选中的框
        cks.each(function(index,el){//el 是每一个框
           var id=$(el).parents("tr").attr("data-categoryid");//每一框 上面的 tr 存的 id
           ids.push(id);// 把一个一个的id' 存到ids 这个数组里面
        })
        // console.log(ids);
        $.ajax({
          type:"post",
          url:"api/_delAllCate.php",
          data:{"ids":ids},
          success:function(res){
             if(res.code==1){
              //   删除掉对应的 数据
              cks.parents('tr').remove();//删除tr
             }
          }
        })



      })
      
    })
  </script>
 
</body>
</html>
