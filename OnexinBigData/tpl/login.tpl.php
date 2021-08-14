<?php if(!defined('OBD_CONTENT')) exit('Access Denied'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo __( 'OBD BigData', 'onexin-bigdata' ); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://apps.bdimg.com/libs/bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">
<style>
.wrap { max-width: 940px; }
input, form { margin-bottom: inherit!important; }
.pagination { margin: inherit; }
.pagination .input-mini { border-radius: none; font-size: 14px; height: 8px; width: 20px; line-height: 10px; overflow: hidden; }
</style>
<script src="https://apps.bdimg.com/libs/jquery/1.8.3/jquery.min.js"></script>
</head>
<body>
<!--remove-admin-header-->
<div class="content-box container-fluid wrap">
  <h1><?php echo __( 'OBD BigData', 'onexin-bigdata' ); ?></h1>
  <form id="frmlogin" name="frmlogin" method="post" action="">
    OID:
    <input type="text" name="username" id="username" />
    Token:
    <input type="password" name="password" id="password" />
    <input type="submit" name="loginsubmit" id="loginsubmit" value="登陆" />
  </form>
</div>
<!--remove-admin-footer-->
</body>
</html>
