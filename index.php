<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="Access-Control-Allow-Origin" content="*">
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>印么官网</title>
    <link rel="icon" href="vfm-admin/images/Logo.ico" type="image/x-icon" />
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="vfm-admin/css/indexStyle.css">
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="vfm-admin/skins/vfm-2016.css">
</head>
<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark" style="padding: 0px 20px;justify-content: space-between;">
      <div>
          <img src="vfm-admin/images/indexlogo2.png" style="height: 40px;margin: 10px 10px 10px -20px;">
      </div>
      <div>
        <ul class="navbar-nav" style="font-size: 14px;flex-flow: row;">
            <a class="nav-link" href="help.php" style="color: rgba(255,255,255,.9);">帮助</a>
            <a class="nav-link" href="yinme.php" style="font-weight: bold;margin-left: 15px;color: rgba(255,255,255,.9);">登录</a>
        </ul>
      </div>
    </nav>
    <div id="demo" class="carousel slide" data-ride="carousel">
      <ul class="carousel-indicators">
        <li data-target="#demo" data-slide-to="0" class="active"></li>
        <li data-target="#demo" data-slide-to="1"></li>
        <li data-target="#demo" data-slide-to="2"></li>
      </ul>
      <!-- 轮播图片 -->
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="vfm-admin/images/11.png">
        </div>
        <div class="carousel-item">
          <img src="vfm-admin/images/22.png">
        </div>
        <div class="carousel-item">
          <img src="vfm-admin/images/33.png">
        </div>
      </div>
      <a class="carousel-control-prev" href="#demo" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </a>
      <a class="carousel-control-next" href="#demo" data-slide="next">
        <span class="carousel-control-next-icon"></span>
      </a>
    </div>

    <div class="middle-container">
      <!-- 链接列表 -->
    	<table class="table"></table>
      <!-- 学校资源 -->
      <div class="row school">
        <ul class="col-md-4">
          <h3>学校资源</h3>
          <div>
            <li class="schoolcontent">
              <img class="schoollogo" src="vfm-admin/images/schoollogo.png">
            </li>
            <li class="schoolwx">
              <span>
                <img src="vfm-admin/images/ytx.jpg">
                <h6>云塘侠</h6>
                <p>快递、外卖、水果</p>
              </span>
              <span>
                <img src="vfm-admin/images/ycjf.jpg">
                <h6>一call即发</h6>
                <p>零食配送，货到付款</p>
              </span>
              <span>
                <img src="vfm-admin/images/xqe.jpg">
                <h6>喜鹊儿</h6>
                <p>掌上教务</p>
              </span>
              <span>
                <img src="vfm-admin/images/xxf.jpg">
                <h6>校旋风</h6>
                <p>食堂外卖</p>
              </span>
            </li>
          </div>
        </ul>
        <ul class="col-md-8 schoolmap">
          <!-- <h3>校园地图</h3> -->
          <li class="maptitle">
            <span class="title-item titleactive">平面图</span>
            |
            <span class="title-item">3D图</span>
          </li>
          <li class="mapcontent">
            <img class="mapitem" src="vfm-admin/images/2D.jpg" style="z-index: 1;">
            <img class="mapitem" src="vfm-admin/images/3D.jpg">
          </li>
        </ul>
      </div>
    </div>
    <div class="extra">
      <ul class="extra-links">
        <div>
          <h6>友情链接</h6>
          <li class="row extra-link">
            <a class="col-md-4" href="http://www.csust.edu.cn">长沙理工大学官网</a>
            <a class="col-md-4" href="http://xk.csust.edu.cn/">教务管理系统</a>
            <a class="col-md-4" href="http://pt.csust.edu.cn/meol/homepage/common/">网络教学平台</a>
          </li>
        </div>
        <div>
          <h6>常用群聊</h6>
          <li class="row extra-link">
            <span class="col-md-4">二手书交易群:544197431</span>
            <span class="col-md-4">快递代领群:136892715</span>
            <span class="col-md-4">校园网群:518049599</span>
          </li>
        </div>
      </ul>
      <ul class="extra-suggestion">
        <h6>我有话说：</h6>
        <textarea class="suggestion" placeholder="提出您宝贵的意见"></textarea>
        <button class="btn btn-primary">提交</button>
      </ul>
    </div>
    <?php
        require_once 'vfm-admin/class.php';
        Template::getPart('footer');
    ?>
    <!-- 公告 -->
    <div class="QQlink">
        <div class="Q_con1">
            <h4 class="announce_title">公告栏</h4>
        </div>
        <div class="Q_con2">
            <p class="announce_content">欢迎使用印么。</p>
        </div>
        <div class="q_link">
            <a class="" href="http://shang.qq.com/wpa/qunwpa?idkey=c5722abe6f6f9117a034d6665780ee679949f62a3deb7aa36e6467923ae41cdb">联系我们<img src="vfm-admin/images/QQ.png"></a>

        </div>
    </div>
    <!-- 弹窗位 -->
    <!-- <div class="ad"><img src="vfm-admin/images/indexlogo.png"></div> -->
</body>
<script type="text/javascript" src="vfm-admin/js/base.js"></script>
</html>
