<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 工具类 --- 一些常用函数
 */

class Tool {

     static public $treeList = array(); //存放无限分类结果如果一页面有多个无限分类可以使用 Tool::$treeList = array(); 清空
     
     /**
      * 无限级分类
      * @access public 
      * @param Array $data     //数据库里获取的结果集 
      * @param Int $pid             
      * @param Int $count       //第几级分类
      * @return Array $treeList   
      */
     static public function tree(&$data, $pid = 0,$level = 1) {
         foreach ($data as $key => $value) {
             if ($value['parent_id'] == $pid) {
                 $value['level'] = $level;
                 self::$treeList[] = $value;
                 unset($data[$key]);
                 self::tree($data, $value['privilege_id'], $level+1);
             } 
         }
         return self::$treeList;
     }
     
 }
