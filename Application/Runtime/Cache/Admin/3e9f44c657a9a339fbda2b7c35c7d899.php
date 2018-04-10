<?php if (!defined('THINK_PATH')) exit();?><aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">管理中心</li>
      <!-- 一级菜单 -->
      <?php if(is_array($sidebar)): $i = 0; $__LIST__ = $sidebar;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li class="treeview <?php if(in_array(($item["id"]), is_array($path)?$path:explode(',',$path))): ?>active<?php endif; ?>">
          <a href="<?php echo U($item['url']);?>">
            <i class="fa fa-<?php echo ($item['icon']); ?>"></i>
            <span><?php echo ($item["title"]); ?></span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
          </a>
          <!-- 二级菜单 -->
          <?php if(!empty($item)): ?><ul class="treeview-menu">
              <?php if(is_array($item['children'])): $i = 0; $__LIST__ = $item['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$subitem): $mod = ($i % 2 );++$i;?><li class="<?php if(in_array(($subitem["id"]), is_array($path)?$path:explode(',',$path))): ?>active<?php endif; ?>"><a href="<?php echo U($subitem['url']);?>"><i class="fa fa-circle-o"></i><?php echo ($subitem["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul><?php endif; ?>

        </li><?php endforeach; endif; else: echo "" ;endif; ?>
      
    </ul>
  </section>
</aside>