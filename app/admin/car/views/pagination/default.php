<div class="pagination alternate dataTables_paginate">
  <ul>
    <li style="padding:0 0 0 10px; line-height:28px">共 <?php echo $pagination->total;?> 条数据</li>
    <?php
    if($pagination->current == 1) {
      echo '<li class="disabled"><a href="javascript:void(0);">首页</a></li>';
      echo '<li class="disabled"><a href="javascript:void(0);">上一页</a></li>';
    } else {
      echo '<li><a href="'.$pagination->URL($pagination->first).'">首页</a></li>';
      echo '<li><a href="'.$pagination->URL($pagination->previous).'">上一页</a></li>';
    }
    $previousPass = $pagination->current - 5;
    $nextPass = $pagination->current + 5;
    $begin = ($previousPass > 0) ? $previousPass : 1;
    $end = ($nextPass < $pagination->max) ? $nextPass : $pagination->max;
    while($begin <= $end) {
      if($begin == $pagination->current) {
        echo '<li class="active"><a>'. $begin .'</a></li>';
      } elseif($begin == $previousPass || $begin == $nextPass) {
        echo '<li><a href="javascript:void(0);">...</a></li>';
      } elseif($begin > $previousPass && $begin < $nextPass) {
        echo '<li><a href="'.$pagination->URL($begin).'">'. $begin .'</a></li>';
      }
      $begin++;
    }
    if($pagination->current == $pagination->max) {
      echo '<li class="disabled"><a href="javascript:void(0);">下一页</a></li>';
      echo '<li class="disabled"><a href="javascript:void(0);">最后一页</a></li>';
    } else {
      echo '<li><a href="'.$pagination->URL($pagination->next).'">下一页</a></li>';
      echo '<li><a href="'.$pagination->URL($pagination->last).'">最后一页</a></li>';
    }
    ?>
  </ul>
</div>