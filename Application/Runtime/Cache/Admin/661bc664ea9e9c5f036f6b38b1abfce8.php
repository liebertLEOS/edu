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
    <h1>数据表维护<small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo U('Admin/Index/index');?>"><i class="fa fa-home"></i> 后台首页</a></li>
      <li class="active"><i class="fa fa-golbe"></i> 数据表维护</li>
    </ol>
  </section>
  <!-- content-header end -->
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">数据表列表</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-bordered table-hover">
          <tbody><tr>
            <th>序号</th>
            <th>备份项目名</th>
            <th>卷数</th>
            <th>压缩方式</th>
            <th>数据大小</th>
            <th>备份时间</th>
            <th class="text-center">操作</th>
          </tr>
          <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($i); ?></td>
            <td><?php echo ($vo["name"]); ?></td>
            <td><?php echo ($vo["part"]); ?></td>
            <td><?php echo ($vo["compress"]); ?></td>
            <td><?php echo ($vo["size"]); ?></td>
            <td><?php echo ($vo["time"]); ?></td>
            <td class="text-center">
              <span  class="btn btn-success btn-xs import" data-id="<?php echo ($vo["id"]); ?>" data-placement="left" data-file="<?php echo ($vo["name"]); ?>">恢复</span>
              <span  class="btn btn-danger btn-xs delete" data-id="<?php echo ($vo["id"]); ?>" data-placement="left" data-file="<?php echo ($vo["name"]); ?>">删除</span>
            </td>
          </tr><?php endforeach; endif; else: echo "" ;endif; ?>
          </tbody></table>
      </div>

    </div>
  </section>


    </div>

    

  </div>
  <script type="text/javascript" src="/Public/lib/seajs/seajs/2.2.1/sea.js"></script>
  <script type="text/javascript" src="/Public/lib/seajs-global-config.js"></script>
  
  <script type="text/javascript">
    seajs.use('/Public/js/admin/database/import.js')
  </script>

</body>
</html>