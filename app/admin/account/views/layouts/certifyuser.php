<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $adminConfig['display_name'];?>管理系统</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/css/bootstrap.min-3.3.4.css" />
<link rel="stylesheet" href="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/css/common.css" />
<link rel="stylesheet" href="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/css/sweetalert.css" />
<link rel="stylesheet" href="<?php if(isset($resourcePath) && $resourcePath) echo $resourcePath;?>/resources/css/fileinput.css" />
</head>
<body>
<?php echo $content;?>
</body>
</html>
