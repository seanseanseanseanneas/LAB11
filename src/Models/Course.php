<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class Course extends BaseModel
{
    // Retrieve all courses
    public function all()
    {
        $sql = "SELECT * FROM courses"; // Replace with the correct table name if needed
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Course');
        return $result;
    }

    // Find a course by code
    public function find($code)
    {
        $sql = "SELECT * FROM courses WHERE course_code = ?";
        $statement = $this->db->prepare($sql);
        $statement->execute([$code]);
        $result = $statement->fetchObject('\App\Models\Course');
        return $result;
    }

    // Get enrollees for a specific course
    public function getEnrolees($course_code)
    {
        $sql = "SELECT s.* 
                FROM course_enrollments AS ce
                LEFT JOIN students AS s ON s.student_code = ce.student_code
                WHERE ce.course_code = :course_code";
                
        $statement = $this->db->prepare($sql);
        $statement->execute([
            'course_code' => $course_code
        ]);
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
        return $result;
    }
}
