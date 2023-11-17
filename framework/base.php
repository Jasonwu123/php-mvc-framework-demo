<?php
/**
 * 框架基础类，引导类，前端控制器
 * 1. 读取配置
 * 2. 自动加载类
 * 3. 请求分发
 */

 class Base {
    // 创建run方法, 完成框架的所有功能
    public function run() {
        // 加载配置
        $this-> loadConfig();

        // 注册自动加载
        $this->registerAutoLoad();

        // 获取请求参数
        $this->getRequestParams();

        // 请求分发
        $this->dispatch();
    }

    // 加载配置方法
    private function loadConfig() {
        // 使用全局变量保存用户配置
        $GLOBALS['config'] = require './application/config/config.php';
    }

    // 创建用户自定义类的加载方法
    public function userAutoLoad($className) {
        // 定义基本类的列表
        $baseClass = [
            'Model' =>  './framework/model.php',
            'DB' =>  './framework/db.php',
        ];

        // 依次进行判断：基础类？模型类？控制类？
        if (isset($baseClass[$className])) {
            require $baseClass[$className]; // 加载模型基类
        } elseif (substr($className, -5) == 'Model') {
            require './application/home/model/'.$className.'.php';
        } elseif (substr($className, -10) == 'Controller') {
            require './application/home/controller/'.$className.'.php';
        }
    }

    // 注册自动加载方法
    private function registerAutoLoad() {
        spl_autoload_register([$this, 'userAutoLoad']);
    }

    // 获取请求参数
    private function getRequestParams() {
        // 当前模块
        $defPlate = $GLOBALS['config']['app']['default_platform'];
        $platForm = isset($_GET['p'])?$_GET['p']:$defPlate;
        define('PLATFORM', $platForm);

        // 当前控制器
        $defController = $GLOBALS['config'][PLATFORM]['default_controller'];
        $controller = isset($_GET['c'])?$_GET['c']:$defController;
        define('CONTROLLER', $controller);

        // 当前方法
        $defAction = $GLOBALS['config'][PLATFORM]['default_action'];
        $action = isset($_GET['a'])?$_GET['a']:$defAction;
        define('ACTION', $action);
    }

    // 请求分发
    private function dispatch() {
        // 实例化控制器类
        $controllerName = CONTROLLER.'Controller';
        $controller = new $controllerName;

        // 调用当前方法
        $actionName = ACTION.'Action';
        $controller->$actionName();
    }
 }