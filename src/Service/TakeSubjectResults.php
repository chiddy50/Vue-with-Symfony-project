<?php

namespace App\Service;

use App\Entity\Grade;
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

class TakeSubjectResults
{
    public function recordSubject($results, $student_id, $session, $date, $term, EntityManagerInterface $em, SubjectResultRepository $repo)
    {   
        $val = [];
        $student_entity = $em->getRepository(StudentInfo::class)->find($student_id);
        $session_entity = $em->getRepository(Session::class)->find($session);
        $term_entity = $em->getRepository(Term::class)->find($term);
        foreach ($results as $result) {
            $stmt = $repo->checkSubjectResultExists($session, $student_id, $result['subject'], $term);

            $grade_entity = $em->getRepository(Grade::class)->find($result['grade']);
            $subject_entity = $em->getRepository(Subjects::class)->find($result['subject']);
            if($stmt->rowCount() === 1){
                $single = $stmt->fetch();
                if (count($single)) {
                    $this->update($single['id'], $session_entity, $student_entity, $grade_entity, $subject_entity, $result['score'], $date, $term_entity, $em);
                }else{
                    $error = true;
                    $message = "No value";
                    return new JsonResponse(['error' => $error, 'message' => $message]);
                    exit;
                }

            }else{
                $this->insert($session_entity, $student_entity, $grade_entity, $subject_entity, $result['score'], $date, $term_entity, $em);
            }
        }
    }

    public function insert($session, $student, $grade, $subject, $score, $date, $term, EntityManagerInterface $em)
    {
        $subjectResult = new SubjectResult();
        $subjectResult->setGrade($grade);
        $subjectResult->setSubject($subject);
        $subjectResult->setSession($session);
        $subjectResult->setStudent($student);
        $subjectResult->setScore(intval($score));
        $subjectResult->setTerm($term);
        $subjectResult->setDate(new DateTimeImmutable($date));
        $em->persist($subjectResult);
        $em->flush();
    }

    public function update($id, $session, $student, $grade, $subject, $score, $date, $term, EntityManagerInterface $em)
    {
        $subjectResult = new SubjectResult();
        $subjectResult = $em->getRepository(SubjectResult::class)->find($id);
        $subjectResult->setGrade($grade);
        $subjectResult->setSubject($subject);
        $subjectResult->setSession($session);
        $subjectResult->setStudent($student);
        $subjectResult->setScore(intval($score));
        $subjectResult->setTerm($term);
        $subjectResult->setDate(new DateTimeImmutable($date));
        $em->flush();
    }

    public function formatter($results, EntityManagerInterface $em)
    {   
        $object = array();

        foreach ($results as $result) {
            $subject_entity = $em->getRepository(Subjects::class)->find($result['subject']);
            $grade_entity = $em->getRepository(Grade::class)->find($result['grade']);

            $subject = $subject_entity->getSubject();
            $grade = $grade_entity->getGrade();
            $comment = $grade_entity->getComment();
            $object[] = ['subject' => $subject, 'grade' => $grade, 'comment' => $comment, 'score' => $result['score']];
        }
        return $object;
    }

    public function checkExamRecords($results, EntityManagerInterface $em){
        $object = [];
        
        foreach ($results as $value) {
 
            $subject_entity = $em->getRepository(Subjects::class)->find($value->subject->id);
            $grade_entity = $em->getRepository(Grade::class)->find($value->grade->id);
            $subject = $subject_entity->getSubject();
            $grade = $grade_entity->getGrade();
            $comment = $grade_entity->getComment();
            $object[] = ['subject' => $subject, 'grade' => $grade, 'comment' => $comment, 'score' => $value->score];
        }

        return $object;
    }
}