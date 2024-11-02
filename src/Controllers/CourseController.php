<?php


namespace App\Controllers;

use App\Models\Course;
use App\Models\CourseEnrolment;
use App\Controllers\BaseController;
use Fpdf\Fpdf; 

class CourseController extends BaseController
{
    // List all courses with enrollee count
    public function list()
    {
        $courseObj = new Course();
        $courses = $courseObj->all();

      
        $enrolmentObj = new CourseEnrolment();
        foreach ($courses as $course) {
            $course->enrollee_count = count($enrolmentObj->getEnrolees($course->course_code));
        }

        $template = 'courses';
        $data = [
            'items' => $courses
        ];

        $output = $this->render($template, $data);

        return $output;
    }


    public function viewCourse($course_code)
    {
        $courseObj = new Course();
        $course = $courseObj->find($course_code);

        $enrolmentObj = new CourseEnrolment();
        $enrollees = $enrolmentObj->getEnrolees($course_code);

        $template = 'single-course';
        $data = [
            'course' => $course,
            'enrollees' => $enrollees
        ];

        $output = $this->render($template, $data);

        return $output;
    }

    
    public function exportCourseEnrollees($course_code)
{
    $courseObj = new Course();
    $course = $courseObj->find($course_code);

    $enrolmentObj = new CourseEnrolment();
    $enrollees = $enrolmentObj->getEnrolees($course_code);

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);


    $pdf->Cell(0, 10, "Course: " . $course->course_name, 0, 1);  // Use course_name
    $pdf->Cell(0, 10, "Description: " . $course->description, 0, 1);
    $pdf->Cell(0, 10, "Credits: " . $course->credits, 0, 1);
    $pdf->Ln(10);


    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 10, "Student Code", 1);
    $pdf->Cell(70, 10, "Student Name", 1);
    $pdf->Cell(50, 10, "Enrollment Date", 1);
    $pdf->Ln();


    $pdf->SetFont('Arial', '', 10);
    foreach ($enrollees as $enrollee) {
        $pdf->Cell(40, 10, $enrollee->student_code, 1);
        $pdf->Cell(70, 10, $enrollee->name, 1);  
        $pdf->Cell(50, 10, $enrollee->enrolment_date, 1); 
        $pdf->Ln();
    }

    $pdf->Output("D", "Course_{$course_code}_Enrollees.pdf");
}

}
