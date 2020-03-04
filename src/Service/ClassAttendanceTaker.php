<?php

namespace App\Service;

use App\Entity\ClassAttendance;
use App\Entity\StudentAttendance;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Month;
use App\Entity\Session;
use App\Entity\StudentInfo;
use App\Entity\Subjects;
use App\Repository\ClassAttendanceRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class ClassAttendanceTaker 
{
    public function takeAllAttendance($subject ,$month, $my_date, $session, $attendance, ClassAttendanceRepository $repo, EntityManagerInterface $em)
    {
        foreach ($attendance as $student_id => $status) {
            $stmt = $repo->checkAttendanceTaken($session, $student_id, $my_date, $subject);
            $student_entity = $em->getRepository(StudentInfo::class)->find($student_id);
            $session_entity = $em->getRepository(Session::class)->find($session);
            $month_entity = $em->getRepository(Month::class)->find($month);
            $subject_entity = $em->getRepository(Subjects::class)->find($subject);

            
            if($stmt->rowCount() === 1){
                $single = $stmt->fetch();
                if (count($single)) {
                    if ($status === 'Present') {
                        $this->updateAttendance($subject_entity, true , $my_date, $single['id'], $student_entity, $session_entity, $month_entity, $em);
                    }else{
                        $this->updateAttendance($subject_entity, false , $my_date, $single['id'], $student_entity, $session_entity, $month_entity, $em);
                    }                    
                }else{     
                    $dataserializer = new DataSerializer;
                    $return = ['error' => true, 'message' => "No value"];
                    $data = $dataserializer->serializeWithoutGroup($return);
                    return new JsonResponse($data);
                    exit;
                }
            }else{
                if ($status == 'Present') {
                    $this->insertAttendance($subject_entity, true ,$my_date, $student_entity, $session_entity, $month_entity, $em);
                }else{
                    $this->insertAttendance($subject_entity, false ,$my_date, $student_entity, $session_entity, $month_entity, $em);
                }
            }
        }
    }
    
    public function takeSingleAttendance($subject, $student_id, $session, $month, $date, $status, EntityManagerInterface $em, ClassAttendanceRepository $repo)
    {
        $student_entity = $em->getRepository(StudentInfo::class)->find($student_id);
        $session_entity = $em->getRepository(Session::class)->find($session);
        $month_entity = $em->getRepository(Month::class)->find($month);
        $subject_entity = $em->getRepository(Subjects::class)->find($subject);
        
        $stmt = $repo->checkAttendanceTaken($session, $student_id, $date, $subject);
   
        if($stmt->rowCount() === 1){
            $single = $stmt->fetch();
            if (count($single)) {
                if ($status === 'Present') {
                    $this->updateAttendance($subject_entity, true , $date, $single['id'], $student_entity, $session_entity, $month_entity, $em);
                }else{
                    $this->updateAttendance($subject_entity, false , $date, $single['id'], $student_entity, $session_entity, $month_entity, $em);
                }                    
            }
        }else{
            if ($status == 'Present') {
                $this->insertAttendance($subject_entity, true ,$date, $student_entity, $session_entity, $month_entity, $em);
            }else{
                $this->insertAttendance($subject_entity, false ,$date, $student_entity, $session_entity, $month_entity, $em);
            }
        }
        

    }
    
    public function updateAttendance($subject_entity, $value, $my_date, $id, $student_entity, $session_entity, $month_entity, EntityManagerInterface $em){
        $classAttendance = new ClassAttendance();
        $classAttendance = $em->getRepository(ClassAttendance::class)->find($id);
        $classAttendance->setDate(new DateTimeImmutable($my_date));
        $classAttendance->setStudent($student_entity);
        $classAttendance->setSession($session_entity);
        $classAttendance->setMonth($month_entity);
        $classAttendance->setSubject($subject_entity);
        $classAttendance->setPresent($value);
        $em->flush();
    }

    public function insertAttendance($subject_entity, $value, $my_date, $student_entity, $session_entity, $month_entity, EntityManagerInterface $em){
        $classAttendance = new ClassAttendance();
        $classAttendance->setDate(new DateTimeImmutable($my_date));
        $classAttendance->setStudent($student_entity);
        $classAttendance->setSession($session_entity);
        $classAttendance->setMonth($month_entity);
        $classAttendance->setSubject($subject_entity);
        $classAttendance->setPresent($value);
        $em->persist($classAttendance);
        $em->flush();
    }


}