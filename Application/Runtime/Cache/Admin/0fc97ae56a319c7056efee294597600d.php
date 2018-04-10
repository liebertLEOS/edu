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
            <th class="text-center">
              <input id="checkall" type="checkbox" />
            </th>
            <th>表名称</th>
            <th>类型</th>
            <th>版本</th>
            <th>字符集</th>
            <th>数据量</th>
            <th>数据大小</th>
            <th>创建时间</th>
            <th>更新时间</th>
          </tr>
          <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td class="text-center">
              <input name="check" type="checkbox" value="<?php echo ($vo["id"]); ?>" data-table="<?php echo ($vo["name"]); ?>"/>
            </td>
            <td><?php echo ($vo["name"]); ?></td>
            <td><?php echo ($vo["engine"]); ?></td>
            <td><?php echo ($vo["version"]); ?></td>
            <td><?php echo ($vo["collation"]); ?></td>
            <td><?php echo ($vo["rows"]); ?></td>
            <td><?php echo ($vo["data_length"]); ?></td>
            <td><?php echo ($vo["create_time"]); ?></td>
            <td><?php echo ($vo["update_time"]); ?></td>
          </tr><?php endforeach; endif; else: echo "" ;endif; ?>
          </tbody></table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix">
        <div class="pull-left">
          <span id="optimize" class="btn btn-warning btn-sm" data-placement="top"><i class="fa fa-gears"></i> 优化表</span>
          <span id="repair" class="btn btn-warning btn-sm" data-placement="top"><i class="fa fa-gears"></i> 修复表</span>
        </div>
        <div class="pull-right">
          <?php echo ($page); ?>
        </div>
      </div>

    </div>
  </section>


    </div>

    

  </div>
  <script type="text/javascript" src="/Public/lib/seajs/seajs/2.2.1/sea.js"></script>
  <script type="text/javascript" src="/Public/lib/seajs-global-config.js"></script>
  
  <script type="text/javascript">
    seajs.use('/Public/js/admin/database/repair.js')
  </script>

</body>
</html>