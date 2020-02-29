<?php

namespace App\Service;

use App\Entity\StudentAttendance;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Month;
use App\Entity\Session;
use App\Entity\StudentInfo;
use App\Repository\StudentAttendanceRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class AttendanceTaker 
{

    public function takeAllAttendance($month, $my_date, $session, $attendance, StudentAttendanceRepository $studentAttendanceRepository, EntityManagerInterface $em)
    {
        foreach ($attendance as $student_id => $value) {
            $stmt = $studentAttendanceRepository->checkAttendanceTaken($session, $student_id, $my_date);
            $student_entity = $em->getRepository(StudentInfo::class)->find($student_id);
            $session_entity = $em->getRepository(Session::class)->find($session);
            $month_entity = $em->getRepository(Month::class)->find($month);
            if($stmt->rowCount() === 1){
                $single = $stmt->fetch();
                if (count($single)) {
                    if ($value === 'Present') {
                        $this->updateAttendance('1' , $my_date, $single['id'], $student_entity, $session_entity, $month_entity, $em);
                    }else{
                        $this->updateAttendance('0' , $my_date, $single['id'], $student_entity, $session_entity, $month_entity, $em);
                    }                    
                }else{
                    $error = true;
                    $message = "No value";
                    $return = ['error' => $error, 'message' => $message];
                    return new JsonResponse($return);
                    exit;
                }
            }else{
                if ($value == 'Present') {
                    $this->insertAttendance('1' ,$my_date,  $student_entity, $session_entity, $month_entity, $em);
                }else{
                    $this->insertAttendance('0' ,$my_date,  $student_entity, $session_entity, $month_entity, $em);
                }
            }
        }
    } 

    public function updateAttendance($value, $my_date, $id, $student_entity, $session_entity, $month_entity, EntityManagerInterface $em){
        $studentAttendance = new StudentAttendance();
        $studentAttendance = $em->getRepository(StudentAttendance::class)->find($id);
        $studentAttendance->setDate(new DateTimeImmutable($my_date));
        $studentAttendance->setStudents($student_entity);
        $studentAttendance->setSession($session_entity);
        $studentAttendance->setMonth($month_entity);
        $studentAttendance->setPresent($value);
        $em->flush();
    }

    public function insertAttendance($value, $my_date, $student_entity, $session_entity, $month_entity, EntityManagerInterface $em){
        $studentAttendance = new StudentAttendance();
        $studentAttendance->setDate(new DateTimeImmutable($my_date));
        $studentAttendance->setStudents($student_entity);
        $studentAttendance->setSession($session_entity);
        $studentAttendance->setMonth($month_entity);
        $studentAttendance->setPresent($value);
        $em->persist($studentAttendance);
        $em->flush();
    }

    public function takeSingleAttendance($student_id, $session, $month, $my_date, $status, EntityManagerInterface $em, StudentAttendanceRepository $studentAttendanceRepository)
    {
        $student_entity = $em->getRepository(StudentInfo::class)->find($student_id);
        $session_entity = $em->getRepository(Session::class)->find($session);
        $month_entity = $em->getRepository(Month::class)->find($month);

        $stmt = $studentAttendanceRepository->checkAttendanceTaken($session, $student_id, $my_date);
   
        if($stmt->rowCount() === 1){
            $single = $stmt->fetch();
            if (count($single)) {
                if ($status === 'Present') {
                    $this->updateAttendance(true , $my_date, $single['id'], $student_entity, $session_entity, $month_entity, $em);
                }else{
                    $this->updateAttendance(false , $my_date, $single['id'], $student_entity, $session_entity, $month_entity, $em);
                }                    
            }
        }else{
            if ($status == 'Present') {
                $this->insertAttendance(true ,$my_date, $student_entity, $session_entity, $month_entity, $em);
            }else{
                $this->insertAttendance(false ,$my_date, $student_entity, $session_entity, $month_entity, $em);
            }
        }
        
        
    

    }
}