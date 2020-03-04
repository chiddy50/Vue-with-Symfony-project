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

    public function takeAllAttendance($month, $date, $session, $attendance, EntityManagerInterface $em)
    {
        $dataserializer = new DataSerializer;

        foreach ($attendance as $student_id => $status) {
            $stmt = $em->getRepository(StudentAttendance::class)->checkAttendanceTaken($session, $student_id, $date);
            
            $student_entity = $em->getRepository(StudentInfo::class)->find($student_id);
            $session_entity = $em->getRepository(Session::class)->find($session);
            $month_entity = $em->getRepository(Month::class)->find($month);
            if($stmt->rowCount() === 1){
                $single = $stmt->fetch();
                if (count($single)) {
                    if ($status === 'Present') {
                        $this->updateAttendance('1' , $date, $single['id'], $student_entity, $session_entity, $month_entity, $em);
                    }else{
                        $this->updateAttendance('0' , $date, $single['id'], $student_entity, $session_entity, $month_entity, $em);
                    }                    
                }else{               
                    $return = ['message' => 'No value', 'error' => true];
                    $data = $dataserializer->serializeWithoutGroup($return);
                    return new JsonResponse($data);
                    exit();
                }
            }else{
                if ($status == 'Present') {
                    $this->insertAttendance('1' ,$date,  $student_entity, $session_entity, $month_entity, $em);
                }else{
                    $this->insertAttendance('0' ,$date,  $student_entity, $session_entity, $month_entity, $em);
                }
            }
        }
    }

    public function takeSingleAttendance($student_id, $session, $month, $date, $status, EntityManagerInterface $em)
    {
        $student_entity = $em->getRepository(StudentInfo::class)->find($student_id);
        $session_entity = $em->getRepository(Session::class)->find($session);
        $month_entity = $em->getRepository(Month::class)->find($month);

        $stmt = $em->getRepository(StudentAttendance::class)->checkAttendanceTaken($session, $student_id, $date);
   
        if($stmt->rowCount() === 1){
            $single = $stmt->fetch();
            if (count($single)) {
                if ($status === 'Present') {
                    $this->updateAttendance(true , $date, $single['id'], $student_entity, $session_entity, $month_entity, $em);
                }else{
                    $this->updateAttendance(false , $date, $single['id'], $student_entity, $session_entity, $month_entity, $em);
                }                    
            }
        }else{
            if ($status == 'Present') {
                $this->insertAttendance(true ,$date, $student_entity, $session_entity, $month_entity, $em);
            }else{
                $this->insertAttendance(false ,$date, $student_entity, $session_entity, $month_entity, $em);
            }
        }
    }

    public function updateAttendance($status, $date, $id, $student_entity, $session_entity, $month_entity, EntityManagerInterface $em){
        $studentAttendance = new StudentAttendance();
        $studentAttendance = $em->getRepository(StudentAttendance::class)->find($id);
        $studentAttendance->setDate(new DateTimeImmutable($date));
        $studentAttendance->setStudents($student_entity);
        $studentAttendance->setSession($session_entity);
        $studentAttendance->setMonth($month_entity);
        $studentAttendance->setPresent($status);
        $em->flush();
    }

    public function insertAttendance($status, $date, $student_entity, $session_entity, $month_entity, EntityManagerInterface $em){
        $studentAttendance = new StudentAttendance();
        $studentAttendance->setDate(new DateTimeImmutable($date));
        $studentAttendance->setStudents($student_entity);
        $studentAttendance->setSession($session_entity);
        $studentAttendance->setMonth($month_entity);
        $studentAttendance->setPresent($status);
        $em->persist($studentAttendance);
        $em->flush();
    }

}