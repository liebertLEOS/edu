app = {}

app.version = '1.0.0'

seajs.config({
  alias: {
    'jquery'              : 'jquery/1.11.2/jquery',
    '$'                   : 'jquery/1.11.2/jquery',
    'jquery-3.3.1'        : 'jquery/3.3.1/jquery',
    'jquery-validation'   : 'jquery-validation/1.17.0/jquery-validation',
    'bootstrap.validator' : 'common/validator',
    'autocomplete'        : 'arale/autocomplete/1.2.2/autocomplete',
    'upload'              : 'arale/upload/1.1.0/upload',
    'class'               : 'arale/class/1.1.0/class',
    'base'                : 'arale/base/1.1.1/base',
    'widget'              : 'arale/widget/1.1.1/widget',
    'position'            : 'arale/position/1.0.1/position',
    'overlay'             : 'arale/overlay/1.1.4/overlay',
    'mask'                : 'arale/overlay/1.1.4/mask',
    'sticky'              : 'arale/sticky/1.3.1/sticky',
    'cookie'              : 'arale/cookie/1.0.2/cookie',
    'messenger'           : 'arale/messenger/2.0.0/messenger',
    "templatable"         : "arale/templatable/0.9.1/templatable",
    'placeholder'         : 'arale/placeholder/1.1.0/placeholder',
    'jquery-menu'         : 'jquery-menu/0.0.1/jquery-menu',
    'bootstrap'           : 'bootstrap/3.3.7/js/bootstrap',
    'adminlte'            : 'adminlte/2.4.2/js/adminlte',
    'tree'                : 'adminlte/2.4.2/js/tree',
    'pushmenu'            : 'adminlte/2.4.2/js/pushmenu',
    'layout'              : 'adminlte/2.4.2/js/layout',
    'confirmation'        : 'bootstrap-confirmation/1.0.1/bootstrap-confirmation',
    'notify'              : 'bootstrap-notify/3.1.5/bootstrap-notify',
    'animate-css'         : 'animate-css/3.6.0/animate.css',
    'fileinput'           : 'bootstrap-fileinput/4.4.8/js/fileinput',
    'fileinput-zh'        : 'bootstrap-fileinput/4.4.8/js/locales/zh',
    'fileinput-css'       : 'bootstrap-fileinput/4.4.8/css/fileinput.css',
    'sortable'            : 'jquery-sortable/0.9.10/sortable'
  },
  // 变量配置
  vars: {
    'locale': 'zh-cn'
  },
  // 预加载项
  preload: [this.JSON ? '' : 'json'],

  // 路径配置
  paths: {
    "common":"common"
  },

  debug: true

});

var __SEAJS_FILE_VERSION = '?v' + app.version;

seajs.on('fetch', function(data) {
  if (!data.uri) {
    return ;
  }

  if (data.uri.indexOf(app.mainScript) > 0) {
    return ;
  }

  if (/\:\/\/.*?\/assets\/libs\/[^(common)]/.test(data.uri)) {
    return ;
  }

  data.requestUri = data.uri + __SEAJS_FILE_VERSION;

});

seajs.on('define', function(data) {
  if (data.uri.lastIndexOf(__SEAJS_FILE_VERSION) > 0) {
    data.uri = data.uri.replace(__SEAJS_FILE_VERSION, '');
  }
});