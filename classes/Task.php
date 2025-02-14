<?php


class Task {
    private $conn;
    private $table_name = "tasks";
    public $id;
    public $task_name;
    public $completion;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createTask() {
        $query = "INSERT INTO " . $this->table_name . " (task) VALUES(?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s" , $this->task_name);
        return $stmt->execute();

    }

    public function readTasks() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_time ASC";
        $result = $this->conn->query($query);
        return $result;

    }

    public function completeTask($id) {
        $query = "UPDATE " . $this->table_name . " SET completion = 1 WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i" , $id);
        return $stmt->execute();

    }

    public function undoCompleteTask($id) {

        $query = "UPDATE " . $this->table_name . " SET completion = 0 WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i" , $id);
        return $stmt->execute();
    }

    public function deleteTask($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i" , $id);
        return $stmt->execute();
    }
}