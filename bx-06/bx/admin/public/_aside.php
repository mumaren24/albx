<div class="aside">
    <div class="profile">
      <img class="avatar" src="../static/uploads/avatar.jpg">
      <h3 class="name">布头儿</h3>
    </div>
    <ul class="nav">
      <li class="active">
        <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <li>
       <?php
          // aside页面           // echo $current_page;
          $postArr=["posts","post-add",'categories'];
          // 要求 $bool 为true 的展开  false不展开
          // $bool=true;in_array(值,数组) 判断数组里面有没有这个值有true
          // 为true 加上对应的 样式就可以展开了
          $bool=in_array($current_page,$postArr);
       ?>
        <a href="#menu-posts" 
           class="<?php echo $bool?'':'collapsed'  ?>" 
           data-toggle="collapse"
           <?php  echo $bool?'aria-expanded="true"':'' ?>
           >
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" 
            class="collapse <?php echo $bool?'in':'' ?>"
            <?php  echo $bool?'aria-expanded="true"':'' ?>
        >
          <li><a href="posts.php">所有文章</a></li>
          <li><a href="post-add.php">写文章</a></li>
          <li><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li>
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li>
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <li>
        <a href="#menu-settings" class="collapsed" data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse">
          <li><a href="nav-menus.php">导航菜单</a></li>
          <li><a href="slides.php">图片轮播</a></li>
          <li><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>
  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script>
    // 页面一打开 就发送ajax 去获取 昵称和头像
    $(function(){
      $.ajax({
        type:"post",
        url:"api/_getUserAvator.php",
        success:function(res){
            console.log(res);
            // 成功之后 把头像和用户名替换到页面上
            if(res.code==1){//成功
              $(".avatar").attr("src",res.avatar);
              $(".name").text(res.nickname);
            }
        }

      })

    })

  
  
  </script>