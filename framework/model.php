<?php
/**
 * 公共模型类
 * 完成数据库连接和一些公共方法
 */

 class Model {
    protected $db = null;

    public $data = null;

    public function __construct()
    {
        $this->init();
    }

    private function init() {
      $dbConfig = [
         'user' => 'edu',
         'pass' => '123456',
         'dbname' => 'edu',
      ];
      $this->db = DB::getInstance($dbConfig);
    }

    public function getAll() {
      $sql = "SELECT * FROM student";
      return $this->data = $this->db->fetchAll($sql);
    }

    public function get($id) {
      $sql = "SELECT * FROM student WHERE id={$id}";
      return $this->data = $this->db->fetch($sql);
    }
 }