<div id="content">
  <div id="content-header">
    <h1>系统行为日志</h1>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-content nopadding">
            <div class="controls controls-row" style="padding-top:10px">
              <form action="/log/behavior" method="get">
              <input type="submit" value="搜索" class="span1 m-wrap btn-primary" style="float:right;margin-right:10px;">
              <input type="text" name="keyword" value="<?php echo $keyword;?>" placeholder="信息" class="span3 m-wrap" style="float:right">
              </form>
            </div>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-hover">
                <thead>
                   <tr>
                      <th style="width: 5%;">ID</th>
                      <th style="width: 8%;">账号</th>
                      <th style="width: 40%;">信息</th>
                      <th style="width: 17%;">动作</th>
                      <th style="width: 8%;">IP</th>
                      <th style="width: 12%;">时间</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($behaviorLogs as $behaviorLog) {
                    ?>
                    <tr class="gradeX">
                        <td><?php echo $behaviorLog->getLogBehaviorId(); ?></td>
                        <td><?php echo $behaviorLog->getManagerName(); ?></td>
                        <td style="text-align: left;"><?php echo htmlspecialchars($behaviorLog->getMessage()); ?></td>
                        <td style="text-align: left;"><?php echo $behaviorLog->getUri(); ?></td>
                        <td><?php echo $behaviorLog->getIp(); ?></td>
                        <td><?php echo $behaviorLog->getCreateTimeString(); ?></td> 
                    </tr>
                  	<tr class="gradeY" style="display:none;">
                        <td colspan="5" style="text-align:left"><strong></strong></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
          </div>
          <?php echo $pagination; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="/resources/js/jquery.min.js"></script> 
<script src="/resources/js/jquery.ui.custom.js"></script> 
<script src="/resources/js/bootstrap.min.js"></script> 
