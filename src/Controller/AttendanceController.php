<?php

namespace App\Controller;

use App\Entity\ClassAttendance;
use App\Entity\Classes;
use App\Entity\Section;
use App\Entity\StudentAttendance;
use App\Entity\StudentInfo;
use App\Repository\ClassAttendanceRepository;
use App\Repository\StudentAttendanceRepository;
use App\Service\AttendanceTaker;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ClassAttendanceTaker;

class AttendanceController extends AbstractController
{
    

    /**
     * @Route("/attendance/one", name="school_attendance", methods="POST")
     */
    public function oneAttendance(Request $request, StudentAttendanceRepository $studentAttendanceRepository, AttendanceTaker $attendanceTaker, EntityManagerInterface $em){
        $student_id = $request->request->get('student_id');
        $status = $request->request->get('status');
        $session = $request->request->get('session');
        $month = $request->request->get('month');
        $my_date = $request->request->get('my_date');

        
        $student = $em->getRepository(StudentInfo::class)->find($student_id);
        $firstname = $student->getFirstname();
        $lastname = $student->getLastname();

        $attendanceTaker->takeSingleAttendance($student_id, $session, $month, $my_date, $status, $em, $studentAttendanceRepository);
        // $date = substr($my_date, 0, 24);

        $message = 'Attendance was successfully taken for '.$firstname.' '.$lastname;
        $error = false;
        return new JsonResponse(['message' => $message, 'error' => $error, 'id' => $student_id, 'month' => $month, 'session' => $session, 'date' => $my_date, 'name' => $firstname.' '.$lastname ]);
    }

    /**
     * @Route("/attendance/all", name="record_all", methods="POST")
     */
    public function recordAllStudents(Request $request, AttendanceTaker $attendanceTaker, StudentAttendanceRepository $studentAttendanceRepository, EntityManagerInterface $em){
        $attendance = $request->request->get('attendance');
        $session = $request->request->get('session');
        $month = $request->request->get('month');
        $my_date = $request->request->get('my_date');
        
        if (!empty($attendance)) {
            $attendanceTaker->takeAllAttendance($month, $my_date, $session, $attendance, $studentAttendanceRepository, $em);
        }else{
            $message = 'No student marked';
            $error = true;
            return new JsonResponse(['message' => $message, 'error' =>  $error]);
        }
        $message = 'Attendance was successfully taken';
        $error = false;
        return new JsonResponse(['message' => $message, 'error' =>  $error]);
    }

    /**
     * @Route("/student-single/attendance", name="student_single_attendance", methods="POST")
     */
    public function getStudentClassAttendance(Request $request, AttendanceTaker $attendanceTaker, StudentAttendanceRepository $studentAttendanceRepository, EntityManagerInterface $em){
        $student_id = $request->request->get('id');
        $session = $request->request->get('session');
        $month = $request->request->get('month');
        $date = $request->request->get('date');
        
        $attendance = $em->getRepository(StudentAttendance::class)->findOneBy([
            'session'=>$session,
            'month' => $month,
            'date' => new DateTimeImmutable($date),
            'students' => $student_id
        ]);
        $error = '';
        $message = '';
        if (!$attendance) {
            $message = 'No attendance records';
            $error = true;
            return new JsonResponse(['message' => $message, 'error' => $error]);
            exit();
        }
        $message = 'Attendance was successfully taken';
        $error = false;
        
        return new JsonResponse(['message' => $message, 'error' => $error, 'attendance' => $attendance->getPresent()]);
    }


    // Class Attendance

     /**
     * @Route("/student-class-attendance", name="students_class_attendance", methods="POST")
     */
    public function recordClassAttendance(Request $request, ClassAttendanceTaker $taker, ClassAttendanceRepository $repo, EntityManagerInterface $em){
        $attendance = $request->request->get('attendance');
        $session = $request->request->get('session');
        $month = $request->request->get('month');
        $date = $request->request->get('date');
        $subject = $request->request->get('subject');

        if (!empty($attendance)) {
            $taker->takeAllAttendance($subject, $month, $date, $session, $attendance, $repo, $em);
        }else{
            $message = 'No student marked';
            $error = true;
            return new JsonResponse(['message' => $message, 'error' =>  $error]);
        }
        $message = 'Attendance was successfully taken';
        $error = false;
        return new JsonResponse(['message' => $message, 'error' =>  $error]);
    }

    /**
     * @Route("/single-class-attendance", name="single_class_attendance", methods="POST")
     */
    public function singleClassAttendance(Request $request, ClassAttendanceRepository $repo, ClassAttendanceTaker $attendanceTaker, EntityManagerInterface $em){
        $student_id = $request->request->get('student_id');
        $status = $request->request->get('status');
        $session = $request->request->get('session');
        $month = $request->request->get('month');
        $date = $request->request->get('date');
        $subject = $request->request->get('subject');

        $student = $em->getRepository(StudentInfo::class)->find($student_id);
        $firstname = $student->getFirstname();
        $lastname = $student->getLastname();

        $attendanceTaker->takeSingleAttendance($subject, $student_id, $session, $month, $date, $status, $em, $repo);

        $message = 'Attendance was successfully taken for '.$firstname.' '.$lastname;
        $error = false;
        return new JsonResponse(['message' => $message, 'error' => $error, 'id' => $student_id, 'month' => $month, 'session' => $session, 'date' => $date, 'name' => $firstname.' '.$lastname ]);
    }

    /**
     * @Route("/monthly-attendance", name="check_monthly_attendance", methods="POST")
     */
    public function checkMonthlyAttendance(Request $request, StudentAttendanceRepository $repo){
        $session = $request->request->get('session');
        $month = $request->request->get('month');
        $id = $request->request->get('id');

        $attendance = $repo->getMonthlyAttendance($session, $id, $month);

        if (!$attendance) {
            return new JsonResponse(['message' => 'No attendance records', 'error' => true]);
            exit();
        }
        
        return new JsonResponse(['error' => false, 'records' => $attendance]);
    }


} 
