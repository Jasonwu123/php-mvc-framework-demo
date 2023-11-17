<?php
/**
 * 数据库的基本操作
*/

class DB {
    // 数据库的默认链接参数
    private $dbConfig = [
        'db' => 'mysql',
        'host' => 'localhost',
        'port' => '3306',
        'user' => 'edu',
        'pass' => '123456',
        'charset' => 'utf8',
        'dbname' => 'edu',
    ];

    // 单例模式 本类的实例
    private static $instance = null;

    // 数据库的链接
    private $conn = null;

    // 新增主键id
    public $insertId = null;

    // 受影响的记录数量
    public $num = 0;

    /**
     * DB 构造方法
     * 私有化以防止外部实例化
     * @param $params 
    */
    private function __construct($params) {
        // 初始化链接参数
        $this->dbConfig = array_merge($this->dbConfig, $params);

        // 链接数据库
        $this->connect();
    }

    /**
     * 禁止外部克隆该实例
     */
    private function __clone() {}

    /**
     * 获取当前类的单一实例
     * @return DB/null
     */
    public static function getInstance($params = []) {
        if(!self::$instance instanceof self) {
            self::$instance = new self($params);
        }
        return self::$instance;
    }

    /**
     * 数据库的链接
     */
    private function connect() {
        try {
            //配置数据源DSN
            $dsn = "{$this->dbConfig['db']}:host={$this->dbConfig['host']};port={$this->dbConfig['port']};dbname={$this->dbConfig['dbname']};charset={$this->dbConfig['charset']}";

            // 创建PDO对象
            $this->conn = new PDO($dsn, $this->dbConfig['user'], $this->dbConfig['pass']);

            // 设置客户端默认字符集
            $this->conn->query("SET NAMES {$this->dbConfig['charset']}");

        } catch (PDOException $e) {
            die('数据库链接失败'.$e->getMessage());
        }
    }

    /**
     * @param string $sql SQL
     * @return $number Number
     * 完成数据表的写操作：增删改查
     * 返回受影响的记录，如果新增需要返回新增主键id
    */
    public function exec($sql) {
        $num = $this->conn->exec($sql);

        // 如果有受影响的记录
        if ($num > 0) {
            // 如果是新增操作，初始化新增主键id属性
            if (null !== $this->conn->lastInsertId()) {
                $this->insertId = $this->conn->lastInsertId();
            }
            // 返回受影响的记录数量
            return $this->num = $num;  
        } else {
            $error = $this->conn->errorInfo(); // 获取最后操作的错误信息的数组
            // [0]错误标识符 [1]错误代码 [2]错误信息
            print '操作失败'.$error[0].":".$error[1].":".$error[2];
        }
    }

    // 获取单条查询结果
    public function fetch($sql) {
        return $this->conn->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    // 获取多条查询结果
    public function fetchAll($sql) {
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    }

}