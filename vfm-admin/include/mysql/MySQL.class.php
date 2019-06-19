<?php

/**
 * @File:   MySQL.class.php
 * @Author: Alan_Albert
 * @Email:  1766447919@qq.com
 * @Date:   2018-07-17 12:53:20
 * @Last Modified by:   Alan_Albert
 * @Last Modified time: 2018-07-21 22:47:55
 * @Comment: MySQL数据库 单例模式
 */

define('SQL_INC', true);

class MySQL
{
    private static $conn = null;

    /**
     * private屏蔽外界调用MySQL构造方法、克隆方法、析构方法
     */
    private function __construct() {}
    private function __clone() {}
    private function __destruct() {}

    /**
     * 静态方法，获取MySQL连接
     * @return PDO|false MySQL数据库PDO连接
     */
    public static function getConn()
    {
        // MySQL数据库配置
        $mysql = [
            'host' => '120.79.77.83:3306',
            'user' => 'yinme',
            'passwd' => 'SQLKuye5893',
            'dbname' => 'test'
        ];
        
        if (!self::$conn) {
            $dsn = 'mysql:host=' . $mysql['host'] . ';dbname=' . $mysql['dbname'];
            try {
                self::$conn = new PDO($dsn, 
                    $mysql['user'], 
                    $mysql['passwd']);
            } catch (PDOException $e) {
                echo "Error: 连接数据库错误" , $e->getMessage();
                return false;
            }
        }
        return self::$conn;
    }
   
    public static function getlink(){

        $link=mysqli_connect("120.79.77.83:3306","yinme","SQLKuye5893")or die("数据库服务器连接失败！<BR>");
        mysqli_select_db($link,"test") or die("数据库选择失败！<BR>");
        mysqli_set_charset($link,"utf8");
        return $link;
    }

}