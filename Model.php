<?php
namespace learning\db;
use PDO;

/**
 * Description of Model
 *
 * @author Arthur Kushman
 */
class Model
{
    public $dbConn, $dbConnObject;

    public function __construct($conn)
    {
        // create db connection
        $this->dbConn = $conn;
    }

    /**
     * Executes CRUD query with PDO and param bindings
     *
     * @param string $sql    SQL Query
     * @param array  $params an array of parameters for $bindType=1 assoc, indexed otherwise
     *
     * @return int             affected rows
     */
    public function executeQuery($sql, $params)
    {
        $stmt = $this->dbConn->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->execute($params);

        return $stmt->rowCount();
    }

    /**
     * Executes CRUD query with PDO and param bindings
     *
     * @param string $sql    SQL Query
     * @param array  $params an array of parameters for $bindType=1 assoc, indexed otherwise
     *
     * @return int            PSOStatement object
     */
    public function executeQueryStmt($sql, $params)
    {
        $stmt = $this->dbConn->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->execute($params);

        return $stmt;
    }

    /**
     * Executes simply any query without overhead and !!! bind-protection !!!
     *
     * @param string $sql
     *
     * @return int affected rows
     */
    public function execQuery($sql)
    {
        return $this->dbConn->exec($sql);
    }

    /**
     * Executes CRUD query with PDO and param bindings
     *
     * @param string $sql    SQL Query
     * @param array  $params an array of parameters for $bindType=1 assoc, indexed otherwise
     *
     * @return int            last insert ID
     */
    public function executeQueryLid($sql, $params)
    {
        $stmt = $this->dbConn->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->execute($params);
        if($stmt->rowCount() > 0)
        {
            return (int) $this->dbConn->lastInsertId();
        }

        return 0;
    }

    /**
     * Executes simply any query without overhead and !!! bind-protection !!!
     *
     * @param string $sql SQL Query
     *
     * @return int          last insert ID
     */
    public function execQueryLid($sql)
    {
        if($this->dbConn->exec($sql) > 0)
        {
            return (int) $this->dbConn->lastInsertId();
        }

        return 0;
    }

    /**
     * Executes query with PDO and param bindings
     *
     * @param string $sql    SQL Query
     * @param array  $params an array of parameters assoc or indexed
     *
     * @return array           1 row result
     */
    public function query($sql, $params = [])
    {
        $stmt = $this->dbConn->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Executes query with PDO and param bindings
     *
     * @param string $sql    SQL Query
     * @param array  $params an array of parameters assoc or indexed
     *
     * @return array           multiple rows result
     */
    public function queryAll($sql, $params = [])
    {
        $stmt = $this->dbConn->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Executes query with PDO and param bindings returning a column
     *
     * @param string $sql    SQL Query
     * @param array  $params an array of parameters for $bindType=1 assoc, indexed otherwise
     *
     * @return string          value of a column
     */
    public function fetchColumn($sql, $params = [])
    {
        $stmt = $this->dbConn->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->execute($params);

        return $stmt->fetchColumn();
    }

    /**
     * Runs mysqli query
     *
     * @param string $sql
     *
     * @return mixed
     */
    public function mysqliQuery($sql)
    {
        return mysqli_query($this->dbConn, $sql);
    }

    /**
     * Sets different Connectors to be used - DI
     *
     * @param Connector $conn particular Connector implementation
     */
    public function setDbConnection($conn)
    {
        $this->dbConn = $conn;
    }

    public function __destruct()
    {
        $this->dbConn = null;
    }
}