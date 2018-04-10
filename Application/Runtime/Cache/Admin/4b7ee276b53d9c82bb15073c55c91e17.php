<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="renderer" content="webkit">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo ($title); ?></title>
  <link rel="stylesheet" href="/Public/lib/bootstrap/3.3.7/css/bootstrap.css">
  <link rel="stylesheet" href="/Public/lib/font-awesome/4.7.0/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/Public/lib/ionicons/2.2.0/css/ionicons.css">
  <!-- adminlte style -->
  <link rel="stylesheet" href="/Public/lib/adminlte/2.4.2/css/adminlte.css">
  <!-- skin style -->
  <link rel="stylesheet" href="/Public/lib/adminlte/2.4.2/css/skins/skin-yellow-light.css">
  <link rel="stylesheet" href="/Public/css/admin.css">
  
</head>
<body class="skin-yellow-light">
  <div class="wrapper">

    
      <?php echo W('Admin/header', array());?>
    

    
      <?php echo W('Admin/sidebar', array());?>
    

    <div class="content-wrapper">
      

  <!-- content-header start -->
  <section class="content-header">
    <h1>用户设置<small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo U('Admin/Index/index');?>"><i class="fa fa-home"></i> 后台首页</a></li>
      <li class="active"><i class="fa fa-golbe"></i> 用户设置</li>
    </ol>
  </section>
  <!-- content-header end -->

  <section class="content">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">注册</a></li>
        <li><a href="#tab_2" data-toggle="tab">登录</a></li>
        <li><a href="#tab_3" data-toggle="tab">默认头像</a></li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">

        </div>
        <div class="tab-pane" id="tab_2">

        </div>

        <div class="tab-pane" id="tab_3">
         
        </div>

      </div>

    </div>

  </section>


    </div>

    

  </div>
  <script type="text/javascript" src="/Public/lib/seajs/seajs/2.2.1/sea.js"></script>
  <script type="text/javascript" src="/Public/lib/seajs-global-config.js"></script>
  
  <script type="text/javascript">
    seajs.use('/Public/js/admin/setting/user.js')
  </script>

</body>
</html>