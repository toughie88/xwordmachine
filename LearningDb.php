<?php

class LearningDb
{
    private static $host,
        $user,
        $pwd,
        $port,
        $dbName,
        $hostIp,
        $dbh;

    private function __construct()
    {
    }

    public static function getConnection()
    {
        static::setDbParams();

        if(static::$dbh === null)
        {
            try
            {// try to connect
                static::$dbh = new PDO(
                    static::$host, static::$user, static::$pwd, [
//                    PDO::ATTR_PERSISTENT => true
                ]
                );
                static::$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                static::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e)
            {
//                Helper::log((string) $e, 'error.log');
            }
        }

        return static::$dbh;
    }

    private static function setDbParams()
    {
        $params         = parse_ini_file(__DIR__ . '/config.ini', true);
        static::$hostIp = $params['mysql']['host'];
        static::$dbName = $params['mysql']['db'];
        static::$host   = 'mysql:host=' . static::$hostIp . ';dbname=' . static::$dbName . ';charset=utf8mb4';
        static::$user   = $params['mysql']['user'];
        static::$pwd    = $params['mysql']['pwd'];
        static::$port   = $params['mysql']['port'];
    }
}