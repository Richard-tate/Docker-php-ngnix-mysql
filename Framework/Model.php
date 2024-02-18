<?php

namespace Framework;

use Exception;

class Model
{
    /**
     *  Base model class for all models to extend
     *  - to reduce code duplication (DRY)
     *
     *  @category Base Model Class
     *  @return void
     *
     **/

    protected static string $table = '';
    protected static array $fillable = [];
    private string $primaryKey = 'id';

    /**
     *  Get all records from a database table
     *  @return array
     */
    public static function all(): array
    {
        $className = static::class;
        return Database::fetchAll('SELECT * FROM ' . static::$table, [], $className);
    }

    /**
     * Get a specific amount of records from a database table
     * @param int $limit
     * @return array
     */

    public static function fetchWithLimit(int $limit): array
    {
        $className = static::class;
        return Database::fetchAll('SELECT * FROM ' . static::$table . ' LIMIT ' . $limit, [], $className);
    }


    /**
     *  Find a record by its ID
     *  @param int $id
     *  @return object|null
     */

    public static function find(int $id): ?object
    {
        $className = static::class;
        $result = Database::fetchAll('SELECT * FROM ' . static::$table . ' WHERE id = :id', ['id' => $id], $className);
        return $result ? $result[0] : null;
    }

    /**
     *  Method to create or update a record, based on the presence of an ID
     *
     * @param string $query
     * @param array $data
     * @return void
     * @throws Exception
     */

    public static function updateOrCreate(string $query, array $data): void
    {
        // Assume $data includes 'user_id' when necessary, especially for creation.
        if (isset($data['id']) && $data['id']) {
            // Update scenario
            $id = $data['id'];
            unset($data['id']); // Remove ID from data to prevent attempts to update the ID itself.
            static::update($id, $data);
        } else {
            // Create scenario - ensure 'user_id' is included for the creation
            if (!isset($data['user_id'])) {
                // Handle error or set 'user_id' if you have a default/fallback value.
                throw new Exception("user_id is required for creating a new record.");
            }
            static::create($query, $data);
        }
    }


    /**
     *  Method to create a new record
     *
     *  @param array $data
     *  @param string $query
     *  @return void
     */

    public static function create(string $query, array $data): void
    {
        Database::query($query, $data);
    }

    /**
     *  Method to update a record
     *
     *  @param int $id
     *  @param array $data
     *  @return void
     */

    public static function update(int $id, array $data): void
    {
        // Filter $data based on $fillable array
        $filteredData = array_filter(
            $data,
            function ($key) {
                return in_array($key, static::$fillable);
            },
            ARRAY_FILTER_USE_KEY
        );

        // Construct the SQL query for update
        $setParts = [];
        foreach ($filteredData as $key => $value) {
            $setParts[] = "$key = :$key";
        }
        $setClause = implode(', ', $setParts);
        $query = "UPDATE " . static::$table . " SET $setClause WHERE id = :id";

        // Add the ID to the parameters
        $filteredData['id'] = $id;

        // Execute the query
        Database::query($query, $filteredData);
    }

    /**
     *  Method to delete a record
     *
     *  @param int $id
     *  @return void
     */
    public static function destroy(int $id): void
    {
        Database::query('DELETE FROM ' . static::$table . ' WHERE id = ' . $id);
    }

    /**
     *  Method to retrieve a record's related data
     *
     *  @param  $relatedClass
     *  @param  $foreignKey
     *  @return array
     */

    protected function hasMany($relatedClass, $foreignKey): array
    {
        $relatedTable = $relatedClass::$table;
        $localKeyValue = $this->{$this->primaryKey};

        $query = "SELECT * FROM {$relatedTable} WHERE {$foreignKey} = :value";
        return Database::fetchAll($query, ['value' => $localKeyValue], $relatedClass);
    }


}