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
    <h1>网站设置<small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo U('Admin/Index/index');?>"><i class="fa fa-home"></i> 后台首页</a></li>
      <li class="active"><i class="fa fa-golbe"></i> 网站设置</li>
    </ol>
  </section>
  <!-- content-header end -->
  <section class="content">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">基础信息</a></li>
      </ul>
      <div class="tab-content">

        <div class="tab-pane active" id="tab_1">
          <form class="form-horizontal" method="POST" enctype=multipart/form-data>
            <div class="box-body">

              <div class="form-group">
                <label for="sitename" class="col-sm-2 control-label">网站名称</label>
                <div class="col-sm-10">
                  <input class="form-control" id="sitename" name="sitename" placeholder="网站名称" type="text" value="<?php echo ($setting["sitename"]); ?>">
                </div>
              </div>

              <div class="form-group">
                <label for="subtitle" class="col-sm-2 control-label">网站副标题</label>
                <div class="col-sm-10">
                  <input class="form-control" id="subtitle" name="subtitle" placeholder="网站副标题" type="text" value="<?php echo ($setting["subtitle"]); ?>">
                </div>
              </div>

              <div class="form-group">
                <label for="sitelogo" class="col-sm-2 control-label">网站LOGO</label>
                <div class="col-sm-10">
                  <input class="file" id="sitelogo" name="sitelogo" type="file">
                  <div class="help-block">请上传png, gif, jpg格式的图片文件。LOGO图片建议不要超过50*250。</div>
                </div>
              </div>

              <div class="form-group">
                <label for="email" class="col-sm-2 control-label">管理员邮箱</label>
                <div class="col-sm-10">
                  <input class="form-control" id="email" name="email" placeholder="管理员邮箱" type="email" value="<?php echo ($setting["email"]); ?>">
                </div>
              </div>


            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-flat btn-warning"><i class="fa fa-check"></i> 确认</button>
            </div>
            <!-- /.box-footer -->
          </form>
        </div>

      </div>
      <!-- /.tab-content -->
    </div>
  </section>


    </div>

    

  </div>
  <script type="text/javascript" src="/Public/lib/seajs/seajs/2.2.1/sea.js"></script>
  <script type="text/javascript" src="/Public/lib/seajs-global-config.js"></script>
  
  <script type="text/javascript">
    seajs.use('/Public/js/admin/setting/website.js')
  </script>

</body>
</html>