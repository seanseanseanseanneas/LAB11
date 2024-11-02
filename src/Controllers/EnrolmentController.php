<?php

namespace App\Controllers;

use App\Models\Course;
use App\Models\CourseEnrolment;
use App\Models\Student;
use App\Controllers\BaseController;

class EnrolmentController extends BaseController
{
    public function enrollmentForm()
    {
        $courseObj = new Course();
        $studentObj = new Student();

        $template = 'enrollment-form';
        $data = [
            'courses' => $courseObj->all(),
            'students' => $studentObj->all()
        ];

        $output = $this->render($template, $data);

        return $output;
    }

    public function enroll()
    {
        $course_code = $_POST['course_code'];
        $student_code = $_POST['student_code'];
        $enrollment_date = $_POST['enrollment_date'];
        // Enroll Student to course
        // write code here
        $enrolmentObj = new CourseEnrolment();
    $enrolled = $enrolmentObj->enroll($course_code, $student_code, $enrollment_date);


    if ($enrolled) {
      
        header("Location: /courses/{$course_code}");
        exit;
    } else {
      
        echo "Failed to enroll student in the course.";
    }
        header("Location: /courses/{$course_code}");
    }
}