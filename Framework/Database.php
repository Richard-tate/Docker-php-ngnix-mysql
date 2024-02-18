<?php
namespace  Framework;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
    /**
     * Static property to hold the PDO connection.
     * @var PDO|null
     */
    public static ?PDO $conn = null;

    /**
     * Static method to initialize the PDO database connection.
     *
     * @param array $config Configuration array containing 'host', 'port', 'dbname', 'username', 'password'.
     * @throws PDOException If connection fails.
     */
    public static function init(array $config): void
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ];

        try {
            self::$conn = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    /**
     * Query the database
     *
     * @param string $query
     * @param array $params
     * @return PDOStatement
     * @throws PDOException
     */
    public static function query(string $query, array $params = []): PDOStatement
    {
        try {
            $sth = self::$conn->prepare($query);

            // bind the params to the query
            foreach ($params as $key => $value) {
                $sth->bindValue(":$key", $value);
            }
            $sth->execute();
            return $sth;
        } catch (PDOException $e) {
            throw new PDOException("Query failed to execute: {$e->getMessage()}");
        }
    }

    /**
     * Constructs a SELECT query with a WHERE clause based on the provided conditions.
     *
     * @param string $table The name of the table to select from.
     * @param array $conditions An associative array of column names and their desired values.
     * @return PDOStatement The prepared statement after execution.
     * @throws PDOException If the query fails to execute.
     */
    public static function where(string $table, array $conditions): PDOStatement
    {
        // Construct the WHERE clause from the conditions.
        $whereClauses = array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($conditions));

        // Join the individual conditions with 'AND'.
        $query = "SELECT * FROM $table WHERE " . implode(' AND ', $whereClauses);

        // Utilize the existing query method to prepare, bind, and execute.
        return self::query($query, $conditions);
    }

    /**
     * Constructs a SELECT query with a WHERE LIKE clause based on provided conditions.
     *
     * @param string $table The name of the table to select from.
     * @param array $conditions An associative array where the key is the column name and the value is the search pattern.
     * @return PDOStatement The prepared statement after execution.
     * @throws PDOException If the query fails to execute.
     */
    public static function whereLike(string $table, array $conditions): PDOStatement
    {

        $whereClauses = array_map(function ($key) {
            return "$key LIKE :$key";
        }, array_keys($conditions));

        $query = "SELECT * FROM $table WHERE " . implode(' AND ', $whereClauses);

        // Prepare and execute the query with the provided conditions.
        return self::query($query, $conditions);
    }

    /**
     * Fetches all records from a query as instances of a specified class.
     *
     * @param string $query The SQL query to execute.
     * @param array $params Parameters to bind to the query.
     * @param string $className The name of the class to map the results to.
     * @return array An array of instances of the specified class.
     * @throws PDOException If the query fails to execute.
     */
    public static function fetchAll(string $query, array $params = [], string $className = 'stdClass'): array
    {
        try {
            $sth = self::$conn->prepare($query);
            foreach ($params as $key => $value) {
                $sth->bindValue(":$key", $value);
            }
            $sth->execute();

            return $sth->fetchAll(PDO::FETCH_CLASS, $className);
        } catch (PDOException $e) {
            throw new PDOException("Query failed to execute: " . $e->getMessage());
        }
    }


}