<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $adminConfig['display_name'];?>管理后台</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/css/bootstrap.css" />
<link rel="stylesheet" href="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/css/matrix-style2.css" />
<link rel="stylesheet" href="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/css/matrix-media.css" />
<link rel="stylesheet" href="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/css/sweetalert.css" />
<link rel="stylesheet" href="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/css/datepicker.css" />
<link rel="stylesheet" href="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/css/jquery.fancybox.css" />
<link rel="stylesheet" href="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/css/common-custom.css" />
<link href="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href='<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/css/opensans.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/css/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/css/common.css" />
</head>
<body>
<?php echo $content;?>
</body>
</html>