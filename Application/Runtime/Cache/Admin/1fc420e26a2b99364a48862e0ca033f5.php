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
    <h1>课程设置<small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo U('Admin/Index/index');?>"><i class="fa fa-home"></i> 后台首页</a></li>
      <li class="active"><i class="fa fa-golbe"></i> 课程设置</li>
    </ol>
  </section>
  <!-- content-header end -->

  <section class="content">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">课程</a></li>
        <li><a href="#tab_2" data-toggle="tab">默认图片</a></li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <form class="form-horizontal" method="POST">
            <div class="box-body">

              <div class="form-group">
                <label for="send" class="col-sm-3 control-label">给新学员发送欢迎私信</label>
                <div class="col-sm-8 radio">
                  <label>
                    <input id="send" name="send"  type="radio" value="1" <?php if(($setting["send"]) == "1"): ?>checked="checked"<?php endif; ?> > 是
                  </label>
                  <label>
                    <input id="send" name="send"  type="radio" value="0" <?php if(($setting["send"]) == "0"): ?>checked="checked"<?php endif; ?>> 否
                  </label>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">欢迎私信内容</label>
                <div class="col-sm-8">
                  <textarea class="form-control" name="welcome" rows="3"><?php echo ($setting["welcome"]); ?></textarea>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">允许教员添加/移除学员</label>
                <div class="col-sm-8 radio">
                  <label>
                    <input name="teacher_manage_student"  type="radio" value="1" <?php if(($setting["teacher_manage_student"]) == "1"): ?>checked="checked"<?php endif; ?> > 是
                  </label>
                  <label>
                    <input name="teacher_manage_student"  type="radio" value="0" <?php if(($setting["teacher_manage_student"]) == "0"): ?>checked="checked"<?php endif; ?>> 否
                  </label>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">允许学员下载视频</label>
                <div class="col-sm-8 radio">
                  <label>
                    <input name="student_download"  type="radio" value="1" <?php if(($setting["student_download"]) == "1"): ?>checked="checked"<?php endif; ?> > 是
                  </label>
                  <label>
                    <input name="student_download"  type="radio" value="0" <?php if(($setting["student_download"]) == "0"): ?>checked="checked"<?php endif; ?>> 否
                  </label>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">免费课时允许未登录用户观看</label>
                <div class="col-sm-8 radio">
                  <label>
                    <input name="allow_anonymous_preview"  type="radio" value="1" <?php if(($setting["allow_anonymous_preview"]) == "1"): ?>checked="checked"<?php endif; ?> > 是
                  </label>
                  <label>
                    <input name="allow_anonymous_preview"  type="radio" value="0" <?php if(($setting["allow_anonymous_preview"]) == "0"): ?>checked="checked"<?php endif; ?>> 否
                  </label>
                </div>
              </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-flat btn-warning col-sm-offset-3"><i class="fa fa-check"></i> 确认</button>
            </div>
            <!-- /.box-footer -->
          </form>

        </div>
        <!-- /.tab-pane -->

        <div class="tab-pane" id="tab_2">

        </div>
        <!-- /.tab-pane -->
      </div>
      <!-- /.tab-content -->
    </div>

  </section>


    </div>

    

  </div>
  <script type="text/javascript" src="/Public/lib/seajs/seajs/2.2.1/sea.js"></script>
  <script type="text/javascript" src="/Public/lib/seajs-global-config.js"></script>
  
  <script type="text/javascript">
    seajs.use('/Public/js/admin/setting/course.js')
  </script>

</body>
</html>