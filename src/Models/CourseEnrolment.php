<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class CourseEnrolment extends BaseModel
{

    public function enroll($course_code, $student_code, $enrollment_date)
    {
        $sql = "INSERT INTO course_enrollments SET 
                    course_code = :course_code,
                    student_code = :student_code,
                    enrolment_date = :enrollment_date";
                    
        $statement = $this->db->prepare($sql);
        $success = $statement->execute([
            'course_code' => $course_code,
            'student_code' => $student_code,
            'enrollment_date' => $enrollment_date
        ]);

        return $success;
    }


    public function getEnrolees($course_code)
    {
        $sql = "SELECT s.student_code, CONCAT(s.first_name, ' ', s.last_name) AS name, ce.enrolment_date, ce.grade
                FROM course_enrollments AS ce
                LEFT JOIN students AS s ON s.student_code = ce.student_code
                WHERE ce.course_code = :course_code";
                
        $statement = $this->db->prepare($sql);
        $statement->execute(['course_code' => $course_code]);
        
        $result = $statement->fetchAll(PDO::FETCH_CLASS);
        return $result;
    }
}
