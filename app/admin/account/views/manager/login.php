<!DOCTYPE html>
<html lang="en">
    
<head>
    <title><?php echo $adminConfig['display_name'];?>管理系统</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/resources/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/resources/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="/resources/css/matrix-login.css" />
    <link rel="stylesheet" href="/resources/font-awesome/css/font-awesome.css" />
    <link href='/resources/css/opensans.css' rel='stylesheet' type='text/css'>
    <style type="text/css">
        input{
            font-family: "Microsoft Yahei";
        }
        .control-label{
            color: #B2DFEE;
            padding-left: 4px;
        }
    </style>
</head>
<body onkeydown="keydown()">
    <div id="loginbox">  
        <div class="control-group normal_text"> 
            <h2 style="color:#B2DFEE;font-size:28px;font-family: monospace;"><?php echo $adminConfig['display_name'];?>管理系统</h2>
            <span id="errorMsg" style="font-size:14px;color:red;font-weight:bold"></span>
        </div>          
        <form id="loginform" class="form-vertical" action="/default/login">
            <div class="control-group">
                <label class="control-label">登录账号</label>
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_lg"><i class="icon-user" style="font-size:16px;"></i></span><input type="text" name="username" placeholder="邮箱" />
                    </div>
                </div>
            </div>
            <div class="control-group2">
                <label class="control-label">登录密码</label>
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_ly"><i class="icon-lock" style="font-size:16px;"></i></span><input type="password" name="password" placeholder="密码" />
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <!--<span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">忘记密码？</a></span>
                <span class="pull-right"><input type="button" id="checkBtn" onclick="checkLogin()" class="btn btn-success" style="width:335px;" value=" 登&nbsp;&nbsp;&nbsp;&nbsp;录"/></span>-->
                <div class="controls"><center><input type="button" id="checkBtn" onclick="checkLogin()" class="btn btn-success" style="width:200px;" value=" 登&nbsp;&nbsp;&nbsp;&nbsp;录"/></center></div>
            </div>
            <div class="control-group normal_text">
                <div style="font-size:14px;color:gray;">推荐使用webkit内核浏览器，如chrome等</div>
            </div>
        </form>
        

        <form id="recoverform" action="#" class="form-vertical" style="padding-top:10px;">
            <label class="control-label">登录账号</label>
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="icon-user" style="font-size:16px;"></i></span><input type="text" name="re_username" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">新密码</label>
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_ly"><i class="icon-lock" style="font-size:16px;"></i></span><input type="password" name="re_password"/>
                    </div>
                </div>
            </div>
            <div class="control-group" style="padding-top:0px;">
                <label class="control-label">确认新密码</label>
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_ly"><i class="icon-lock" style="font-size:16px;"></i></span><input type="password" name="re_confirmpassword" />
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; 返回登录</a></span>
                <span class="pull-right"><a id="changePwd" class="btn btn-info" style="width:310px;">重置密码</a></span>
            </div>
            <div class="control-group normal_text">
                <div style="font-size:14px;color:gray;">推荐使用webkit内核浏览器，如chrome等</div>
            </div>
        </form>

    </div>
    
    <script src="/resources/js/jquery.min.js"></script>  
    <script src="/resources/js/matrix.login.js"></script> 
</body>

</html>
