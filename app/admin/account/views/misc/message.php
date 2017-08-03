<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php if(isset($adminConfig)) {echo $adminConfig['display_name'];}?>管理系统</title>
    <link href="/resources/css/bootstrap.min-3.3.5.css" rel="stylesheet">
    <link href="/resources/css/bootstrap-combined.min.css" rel="stylesheet">
    <link href="/resources/font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        body{
            background:#2E363F;
        }
    </style>
</head>
<body>
<br/><br/><br/><br/><br/><br/><br/><br/>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="row-fluid">
                <div class="span4">
                </div>
                <div class="span4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>提示信息</strong></h3>
                        </div>
                        <div class="panel-body">
                            <?php echo $message;?>
                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-warning" onclick="reload(this)" type="button">返回</button>
                        </div>
                    </div>
                </div>
                <div class="span4"></div>
            </div>
        </div>
    </div>
</div>
<script src="/resources/js/jquery.min.js"></script>
<script src="/resources/js/bootstrap.min.js"></script>

<script type="text/javascript">
  var isInFancybox = self != top;
  if(isInFancybox) {
    $("a").click( function () { parent.$.fancybox.close(); });
    setTimeout(function(){parent.$.fancybox.close();}, 2000);
  } else {
    <?php if($redirect !== NULL) {?>
    $('a').attr('href','<?php echo URL::site($redirect); ?>'); 
    setTimeout('(function(uri) {location.href = uri;})("<?php echo URL::site($redirect); ?>")', <?php echo $delay * 1000; ?>);
    <?php } else {?>
    $('a').attr('href','/profile/index'); 
    setTimeout('(function(uri) {location.href = uri;})("/profile/index")', <?php echo $delay * 1000; ?>);
    <?php }?>
  }
</script>
</body>
</html>
