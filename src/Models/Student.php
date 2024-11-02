<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class Student extends BaseModel
{
    // Retrieve all students
    public function all()
    {
        $sql = "SELECT * FROM students";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
        return $result;
    }

 
    public function find($id)
    {
        $sql = "SELECT * FROM students WHERE id = :id LIMIT 1";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchObject('\App\Models\Student');
        return $result;
    }
}
