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
            <a class="nav-link" href="yinme.php" style="font-weight: bold;margin-left: 15px;color: rgba(255,255,255,.9);">登录</a>
        </ul>
      </div>  
    </nav>
	<div class="help-process">
		<img src="vfm-admin/images/help.jpg" width="100%;">
	</div>
    <?php
        require_once 'vfm-admin/class.php';
        Template::getPart('footer');
    ?>
</body>
<script type="text/javascript" src="vfm-admin/js/base.js"></script>
</html>