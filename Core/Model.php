<?php

/**
 * MIT License
 * Copyright (c) 2020 Vaibhav Kubre
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Core;

class Model
{
    /** @var string Table Name */
    protected $table = null;


    /** @var string Primary Key Column */
    protected $key = "id";


    public function __construct()
    {
        if (is_null($this->table)) {
            $this->table = explode("\\", get_called_class());
            $this->table = end($this->table);
            $this->table = substr($this->table, -1) === 'y' ?
                rtrim($this->table, 'y') . 'ies' : $this->table . 's';
            $this->table = lcfirst($this->table);
        }
    }


    /**
     * Get row from db table with id
     *
     * @param int $id Id value
     * @param array $columns Columns to be retirved
     * @param int $fetchStyle PDO fetch style constatnt
     * @return mixed
     */
    public function find($id, $columns = ['*'], $fetchStyle = \PDO::FETCH_BOTH)
    {
        $columns = implode(",", $columns);
        $stmt = Database::getConnection()
            ->prepare("SELECT $columns FROM $this->table WHERE $this->key=?");
        $stmt->execute([$id]);
        return $stmt->fetch($fetchStyle);
    }


    /**
     * Get all row from db table
     *
     * @param array $columns Columns to be retirved
     * @param int $fetchStyle PDO fetch style constatnt
     * @return array
     */
    public function all($columns = ['*'], $fetchStyle = \PDO::FETCH_BOTH)
    {
        $columns = implode(",", $columns);
        $stmt = Database::getConnection()
            ->prepare("SELECT $columns FROM $this->table");
        $stmt->execute();
        return $stmt->fetchAll($fetchStyle);
    }


    /**
     * Update db row with $id with given values
     *
     * @param int $id
     * @param array $data associative array containing columns and values
     * @return boolean
     */
    public function update($id, $data)
    {
        $columns = implode('=?, ', array_keys($data)) . '=?';
        return Database::getConnection()
            ->prepare("UPDATE $this->table SET $columns WHERE $this->key=?")
            ->execute(array_merge(array_values($data), [$id]));
    }


    /**
     * Delete row from fb table witn given id
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        return Database::getConnection()
            ->prepare("DELETE FROM $this->table WHERE $this->key=?")
            ->execute([$id]);
    }

    /**
     * Create a row in db table
     *
     * @param array $data associative array containing columns and values
     * @return boolean
     */
    public function create($data)
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));
        return Database::getConnection()
            ->prepare("INSERT INTO $this->table ($columns) VALUES ($values)")
            ->execute(array_values($data));
    }
}
