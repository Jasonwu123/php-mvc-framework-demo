<?php
/**
 * 学生模块控制器
 * 模块管理一般有：CRUD增删改查
 * 模型根据数据表创建，控制器根据模型创建
 */

 class StudentController {
    // 获取所有数据
    public function listAllAction() {
        $stu = new StudentModel();
        $data = $stu->getAll();
        // echo '<pre>';
        // print_r($data);
        require './application/home/view/student_list.php'; // 渲染模板
    }

      // 获取单条数据
      public function infoAction($id = 1) {
        $id = isset($_GET['id'])?$_GET['id']:$id;
        $stu = new StudentModel();
        $data = $stu->get($id);
        // echo '<pre>';
        // print_r($data);
        require './application/home/view/student_info.php'; // 渲染模板
    }
 }