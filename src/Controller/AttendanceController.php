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
use App\Service\DataSerializer;

class AttendanceController extends AbstractController
{
    

    /**
     * @Route("/attendance/one", name="record_one", methods="POST")
     */
    public function recordOneAttendance(Request $request, EntityManagerInterface $em){
        $student_id = $request->request->get('student_id');
        $status = $request->request->get('status');
        $session = $request->request->get('session');
        $month = $request->request->get('month');
        $date = $request->request->get('date');

        $dataserializer = new DataSerializer;

        if (empty($session) or empty($month) or empty($date)) {
            $return = ['message' => 'Please fill all fields', 'error' => true];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit();
        }
        
        $student = $em->getRepository(StudentInfo::class)->find($student_id);
        $firstname = $student->getFirstname();
        $lastname = $student->getLastname();


        $attendanceTaker = new AttendanceTaker();
        $attendanceTaker->takeSingleAttendance($student_id, $session, $month, $date, $status, $em);
        // $date = substr($date, 0, 24);

        $return = ['message' => 'Attendance was successfully taken for '.$firstname.' '.$lastname, 'error' => false];
        $data = $dataserializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
    }

    /**
     * @Route("/attendance/all", name="record_all", methods="POST")
     */
    public function recordAllStudents(Request $request, AttendanceTaker $attendanceTaker, EntityManagerInterface $em){
        $attendance = $request->request->get('attendance');
        $session = $request->request->get('session');
        $month = $request->request->get('month');
        $date = $request->request->get('date');
        dd($attendance);
        
        $dataserializer = new DataSerializer;
       
        if ($attendance === '' or $session === '' or $month === '' or $date === '') {
            $return = ['message' => 'Fill required entries', 'error' => true];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit();
        }else{
            
            $attendanceTaker->takeAllAttendance($month, $date, $session, $attendance, $em);
        }        

        $return = ['message' => 'Attendance was successfully taken', 'error' => false];
        $data = $dataserializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
    }

    // Check students attendance for a single day
    /**
     * @Route("/student/single-attendance", name="get_student_single_attendance", methods="POST")
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
        $dataserializer = new DataSerializer;

        if (!$attendance) {
            $return = ['error' => true, 'message' => 'No attendance records'];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit();
        }
        
        $return = ['message' => 'Attendance was successfully taken', 'error' => false, 'attendance' => $attendance->getPresent()];
        $data = $dataserializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
    }


    // Subject Attendance

     /**
     * @Route("/student-subject-attendance", name="students_subject_attendance", methods="POST")
     */
    public function recordAllSubjectAttendance(Request $request, ClassAttendanceTaker $taker, ClassAttendanceRepository $repo, EntityManagerInterface $em){
        $attendance = $request->request->get('attendance');
        $session = $request->request->get('session');
        $month = $request->request->get('month');
        $date = $request->request->get('date');
        $subject = $request->request->get('subject');
        $dataserializer = new DataSerializer;

        if (!empty($attendance) or !empty($session) or !empty($month) or !empty($date) or !empty($subject)) {
            $taker->takeAllAttendance($subject, $month, $date, $session, $attendance, $repo, $em);
        }else{
            $return = ['message' => 'Fill required fields', 'error' =>  true];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit();
        }
        
        $return = ['message' => 'Attendance was successfully taken', 'error' =>  false];
        $data = $dataserializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
    }

    /**
     * @Route("/single-subject-attendance", name="single_subject_attendance", methods="POST")
     */
    public function recordOneSubjectAttendance(Request $request, ClassAttendanceRepository $repo, ClassAttendanceTaker $attendanceTaker, EntityManagerInterface $em){
        $student_id = $request->request->get('student_id');
        $status = $request->request->get('status');
        $session = $request->request->get('session');
        $month = $request->request->get('month');
        $date = $request->request->get('date');
        $subject = $request->request->get('subject');

        $dataserializer = new DataSerializer;

        if (empty($student_id) or empty($status) or empty($session) or empty($month) or empty($date) or empty($subject)) {
            $return = ['message' => 'Fill required fields', 'error' =>  true];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit();            
        }

        $student = $em->getRepository(StudentInfo::class)->find($student_id);
        $firstname = $student->getFirstname();
        $lastname = $student->getLastname();

        $attendanceTaker->takeSingleAttendance($subject, $student_id, $session, $month, $date, $status, $em, $repo);


        $return = ['error' => false, 'message' => 'Attendance was successfully taken for '.$firstname.' '.$lastname];
        $data = $dataserializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
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
