<?php
/**
 * 入口文件
 */

 // 导入框架基础类
 require './framework/base.php';

 // 实例化框架类
 $app = new Base();

 // 让框架跑起来
 $app->run();