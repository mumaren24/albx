<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
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
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select id="category" name="" class="form-control input-sm">
            <option value="all">所有分类</option>
          </select>
          <select id="status" name="" class="form-control input-sm">
            <option value="all">所有状态</option>
            <option value="drafted">草稿</option>
            <option value="published">已发布</option>
            <option value="trashed">已作废</option>
          </select>
          <button id="btn-filt" type="button" class="btn btn-default btn-sm">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <!-- <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li> -->
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr> -->
        </tbody>
      </table>
    </div>
  </div>
    <!-- 左边部分 -->
    <?php  
       $current_page="posts";
    ?>
    <!-- 引入 -->
    <?php  include 'public/_aside.php'; ?>

  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script>
    
    var currentPage=1;// 声明当前页码
    var pageCount=10;// 声明最大页码 声明最大页码=向上取整(总条数/每页显示的条数)
    var pageSize=10;// 每页显示10条
    // 封装 循环 生成 li标签的代码
    function makePageButton(){
      // 开始=当前页码-4
      var start=currentPage-2;//8
      // 判断start 如果 小于1  没有负的页码 强制都从1开始
      if(start<1){
        start=1;//页码永远只能从1开始
      }
      // 结束=开始页码+4
      var end=start+4;//12  视频老师 写错了currentPage 应该用start
      // 如果最大页码是4  那么肯定只能到4
      if(end>pageCount){
        end=pageCount;//如果超过最大页码 肯定没了 只能到最大页码
      }
      // 动态生成分页的 5个 li标签
      var html='';
      // 如果已经是第1页 那么肯定不能有上一页  如果不是第一页 就有上一页
      if(currentPage!=1){//如果不是第一页 就有上一页
          html+=`<li class="item" data-page="${currentPage-1}"><a href="javascript:;">上一页</a></li>`; // 上一页
      }
      for(var i=start;i<=end;i++){//5个li标签
        if(i==currentPage){//如果是当前页 li标签颜色变成 active 深蓝色
            html+=`<li class="item active" data-page="${i}"><a href="javascript:;">${i}</a></li>`;
        }else{
            html+=`<li class="item" data-page="${i}"><a href="javascript:;">${i}</a></li>`;
        }
      }
      // 如果是最后一页 那么肯定不能点 下一页了  如果不是 就应该可以点
      if(currentPage!=pageCount){//如果不是最后一页 就应该可以 点击 下一页  
        html+=`<li class="item" data-page="${currentPage+1}"><a href="javascript:;">下一页</a></li>`; // 下一页
      }
      // 把生成的 li放到ul里面
      $(".pagination").html(html);
    }

    // 页面一打开 发送ajax  获取所有文章相关的数据 循环显示到tbody里面
    //  drafted-草稿/published-已发布/trashed-已作废）
    var statusData={
      drafted:'草稿',
      published:'已发布',
      trashed:'已作废'
    };
    $(function(){
      // 默认发送ajax获取 第一次的数据
      $.ajax({
        type:"post",
        url:"api/_getPostData.php",
        data:{
          "currentPage":1,
          "pageSize":10,
          "status":$("#status").val(),
          "categoryid":$("#category").val()
          },
        success:function(res){
          // console.log(res);
          if(res.code==1){//成功 循环数组 拼接出tr 放到tbody里面
              var data=res.data;
              // 总页数 赋值给全局变量
              pageCount=res.pageCount
              // 生成li的分页按钮
              makePageButton();
              var str='';
              $.each(data,function(index,val){//val 数组的每一项
                 str+=`<tr>
                    <td class="text-center"><input type="checkbox"></td>
                    <td>${val.title}</td>
                    <td>${val.nickname}</td>
                    <td>${val.name}</td>
                    <td class="text-center">${val.created}</td>
                    <td class="text-center">${statusData[val.status]}</td>
                    <td class="text-center">
                      <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
                      <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                    </td>
                  </tr>`
              })
              // 循环完毕 就有很多tr
              $("tbody").html(str);
          }
        }
      })

      // 点击分页的li标签 获取点击的页码 发送ajax到后台获取对应数据
      $(".pagination").on("click",".item",function(){
          // 获取点击的 li的 页码  提前循环生成的时候 放到自定义属性上
          currentPage=parseInt($(this).attr("data-page"));//转换成数字
          // alert(currentPage)
          $.ajax({
            type:"post",
            url:"api/_getPostData.php",
            data:{"currentPage":currentPage,"pageSize":pageSize,"status":$("#status").val(),"categoryid":$("#category").val()},
            success:function(res){
              console.log(res);
                if(res.code==1){//成功 循环数组 拼接出tr 放到tbody里面
                var data=res.data;
                var str='';
                pageCount=res.pageCount;
                // 每次点击 按钮 都要重新生成 因为上面修改了 当前页全局变量currentPage
                makePageButton();
                $.each(data,function(index,val){//val 数组的每一项
                  str+=`<tr>
                      <td class="text-center"><input type="checkbox"></td>
                      <td>${val.title}</td>
                      <td>${val.nickname}</td>
                      <td>${val.name}</td>
                      <td class="text-center">${val.created}</td>
                      <td class="text-center">${statusData[val.status]}</td>
                      <td class="text-center">
                        <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
                        <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                      </td>
                    </tr>`
                })
                // 循环完毕 就有很多tr html会直接替换掉原来的 
                $("tbody").html(str);
              }
            }
          })


      })

      // 直接发送ajax  获取所有分类 写到 select 下拉框
      $.ajax({
        type:"post",
        url:"api/_getCate.php",
        success:function(res){
          // console.log(res);
          if(res.code==1){
            // 把分类 生成 option 标签 追加到 页面的 select里面
            var data=res.data;
            $.each(data,function(i,e){//e是数组的 每一项
              var html=`<option value="${e.id}">${e.name}</option>`
              // 追加到 页面的 select里面
              $(html).appendTo("#category");
            })
          }
        }
      })

      // 点击 筛选按钮 获取对应的十条数据
      $("#btn-filt").on("click",function(){
          var status=$("#status").val();//草稿或者已发布对应的单词 select框的 值 就是 选中的那个option对应的 value值
          // alert(status)  drafted  published trashed
          // 发送ajax  把对应的草稿或者已发布 传到后台 后台返回给我对应的数据
          var categoryid=$("#category").val();// 获取对应的分类
          $.ajax({
            type:"post",
            url:"api/_getPostData.php",
            // 参数
            data:{
              "currentPage":currentPage,
              "pageSize":pageSize,
              "status":status,
              "categoryid":categoryid
            },
            success:function(res){
                // console.log(res);
                if(res.code==1){
                  var str='';
                  var data=res.data;
                  makePageButton();
                  // 循环data数组 生成10条tr数据 显示到页面
                  $.each(data,function(index,val){//val 数组的每一项
                    str+=`<tr>
                        <td class="text-center"><input type="checkbox"></td>
                        <td>${val.title}</td>
                        <td>${val.nickname}</td>
                        <td>${val.name}</td>
                        <td class="text-center">${val.created}</td>
                        <td class="text-center">${statusData[val.status]}</td>
                        <td class="text-center">
                          <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
                          <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                        </td>
                      </tr>`
                  })
                  // 循环完毕 就有很多tr html会直接替换掉原来的 
                  $("tbody").html(str);
                }
            }

          })
      })







    })
  
  
  
  
  </script>
</body>
</html>
