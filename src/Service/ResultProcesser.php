<?php

namespace App\Service;

use App\Entity\Classes;
use App\Entity\ExamResult;
use App\Entity\Grade;
use App\Entity\Section;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Session;
use App\Entity\StudentInfo;
use App\Entity\SubjectResult;
use App\Entity\Subjects;
use App\Entity\Term;
use App\Repository\SubjectResultRepository;
use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResultProcesser
{
    public function record($results, $date, $session, $term, $subject, $section, $class, EntityManagerInterface $em)
    {
        $subject_entity = $em->getRepository(Subjects::class)->find($subject);
        $session_entity = $em->getRepository(Session::class)->find($session);
        $term_entity = $em->getRepository(Term::class)->find($term);
        $section_entity = $em->getRepository(Section::class)->find($section);
        $class_entity = $em->getRepository(Classes::class)->find($class);
        $dataserializer = new DataSerializer;

        foreach ($results as $result) {
            $stmt = $em->getRepository(ExamResult::class)->checkExamResultExists($session, $term, $result['student_id'], $subject, $class, $section);

            $grade_entity = $em->getRepository(Grade::class)->find($result['grade']);
            $student_entity = $em->getRepository(StudentInfo::class)->find($result['student_id']);

            if($stmt->rowCount() === 1){
                $single = $stmt->fetch();
                if (count($single)) {
                    $this->update($single['id'], $session_entity, $student_entity, $grade_entity, $result['exam'], $result['first_ca'], $result['second_ca'], $subject_entity, $result['total'], $date, $term_entity, $class_entity, $section_entity, $em);
                }else{                    
                    $data = $dataserializer->serializeWithoutGroup(['error' => true, 'message' => 'No Data']);
                    return new JsonResponse($data);
                    exit;
                }
            }else{
                $this->insert($session_entity, $student_entity, $grade_entity, $result['exam'], $result['first_ca'], $result['second_ca'], $subject_entity, $result['total'], $date, $term_entity, $class_entity, $section_entity, $em);
            }            
        }
    }

    public function insert($session, $student, $grade, $exam, $first_ca, $second_ca, $subject, $total, $date, $term, $class, $section, EntityManagerInterface $em)
    {
        $examResult = new ExamResult();
        $examResult->setGrade($grade);
        $examResult->setStudent($student);
        $examResult->setTotal(intval($total));
        $examResult->setExam($exam);
        $examResult->setSubject($subject);
        $examResult->setSession($session);
        $examResult->setFirstCa(intval($first_ca));
        $examResult->setSecondCa(intval($second_ca));
        $examResult->setTerm($term);
        $examResult->setClass($class);
        $examResult->setSection($section);
        $examResult->setDate(new DateTimeImmutable($date));
        $em->persist($examResult);
        $em->flush();

    }

    public function update($id, $session, $student, $grade, $exam, $first_ca, $second_ca, $subject, $total, $date, $term, $class, $section, EntityManagerInterface $em)
    {
        $examResult = new ExamResult();
        $examResult = $em->getRepository(ExamResult::class)->find($id);
        $examResult->setGrade($grade);
        $examResult->setStudent($student);
        $examResult->setTotal(intval($total));
        $examResult->setExam($exam);
        $examResult->setSubject($subject);
        $examResult->setSession($session);
        $examResult->setFirstCa(intval($first_ca));
        $examResult->setSecondCa(intval($second_ca));
        $examResult->setTerm($term);
        $examResult->setClass($class);
        $examResult->setSection($section);
        $examResult->setDate(new DateTimeImmutable($date));
        $em->flush();

    }

    public function process(array $exams, array $grades, array $second_cas, array $first_cas, array $totals)
    {
        $results = [];
        foreach($exams as $student_id => $exam){
            foreach ($grades as $student_id2 => $grade) {
                foreach ($second_cas as $student_id3 => $second_ca) {
                    foreach ($first_cas as $student_id4 => $first_ca) {
                        foreach ($totals as $student_id5 => $total) {
                            if ($student_id === $student_id2 && $student_id === $student_id3 && $student_id === $student_id4 && $student_id === $student_id5 && $student_id2 === $student_id3 && $student_id2 === $student_id4 && $student_id2 === $student_id5 && $student_id3 === $student_id4 && $student_id3 === $student_id5 && $student_id4 === $student_id5) {
                                array_push($results, ['student_id' => $student_id, 'grade' => $grade, 'exam' => $exam, 'total' => $total, 'first_ca' => $first_ca, 'second_ca' => $second_ca]);
                            }                                                
                        }
                    }
                }
            }
        }

        return $results;
    }

    public function recordSingleStudent($results, $date, $session, $term, $section, $class, $student, EntityManagerInterface $em)
    {
        $session_entity = $em->getRepository(Session::class)->find($session);
        $term_entity = $em->getRepository(Term::class)->find($term);
        $section_entity = $em->getRepository(Section::class)->find($section);
        $class_entity = $em->getRepository(Classes::class)->find($class);
        $student_entity = $em->getRepository(StudentInfo::class)->find($student);
        $dataserializer = new DataSerializer;

        foreach ($results as $result) {
            $stmt = $em->getRepository(ExamResult::class)->checkExamResultExists($session, $term, $student, $result['subject_id'], $class, $section);

            $grade_entity = $em->getRepository(Grade::class)->find($result['grade']);
            $subject_entity = $em->getRepository(Subjects::class)->find($result['subject_id']);

            if($stmt->rowCount() === 1){
                $single = $stmt->fetch();
                if (count($single)) {
                    $this->update($single['id'], $session_entity, $student_entity, $grade_entity, $result['exam'], $result['first_ca'], $result['second_ca'], $subject_entity, $result['total'], $date, $term_entity, $class_entity, $section_entity, $em);
                }else{                    
                    $data = $dataserializer->serializeWithoutGroup(['error' => true, 'message' => 'No Data']);
                    return new JsonResponse($data);
                    exit;
                }
            }else{
                $this->insert($session_entity, $student_entity, $grade_entity, $result['exam'], $result['first_ca'], $result['second_ca'], $subject_entity, $result['total'], $date, $term_entity, $class_entity, $section_entity, $em);
            }            
        }
    }

    public function updateRecords($results, $date, $session, $term, $section, $class, $student, EntityManagerInterface $em)
    {
        $session_entity = $em->getRepository(Session::class)->find($session);
        $term_entity = $em->getRepository(Term::class)->find($term);
        $section_entity = $em->getRepository(Section::class)->find($section);
        $class_entity = $em->getRepository(Classes::class)->find($class);
        $student_entity = $em->getRepository(StudentInfo::class)->find($student);
        $dataserializer = new DataSerializer;

        foreach ($results as $result) {
            $examResult = $em->getRepository(ExamResult::class)->findOneBy(['session' => $session, 'student' => $student, 'subject' => $result['subject_id'], 'term' => $term]);
            $grade_entity = $em->getRepository(Grade::class)->find($result['grade']);
            $subject_entity = $em->getRepository(Subjects::class)->find($result['subject_id']);
            
            $id = $examResult->getId();
            // dd($id);
            $this->update($id, $session_entity, $student_entity, $grade_entity, $result['exam'], $result['first_ca'], $result['second_ca'], $subject_entity, $result['total'], $date, $term_entity, $class_entity, $section_entity, $em);
        }
    }

    public function formatter($results, EntityManagerInterface $em)
    {   
        $record = [];

        foreach ($results as $result) {
            $subject_entity = $em->getRepository(Subjects::class)->find($result['subject_id']);
            $grade_entity = $em->getRepository(Grade::class)->find($result['grade']);

            $subject = $subject_entity->getSubject();
            $grade = $grade_entity->getGrade();
            $comment = $grade_entity->getComment();
            $record[] = ['subject' => $subject, 'grade' => $grade, 'comment' => $comment, 'first_ca' => $result['first_ca'], 'second_ca' => $result['second_ca'], 'exam' => $result['exam'], 'total' => $result['total']];
        }
        return $record;
    }

}