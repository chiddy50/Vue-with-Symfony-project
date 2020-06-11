<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Entity\Session;
use App\Entity\StudentInfo;
use App\Entity\Term;
use App\Entity\ExamResult;
use App\Service\DataSerializer;
use App\Service\ResultProcesser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ExamResultsController extends AbstractController
{
    /**
     * @Route("/record-class-results", name=" record_class_results", methods="POST")
     */
    public function processClassResults(Request $request)
    {
        $subject = $request->request->get('subject');
        $grades = $request->request->get('grade');
        $exams = $request->request->get('exam');
        $second_cas = $request->request->get('second_ca');
        $first_cas = $request->request->get('first_ca');
        $totals = $request->request->get('total');
        $date = $request->request->get('date');
        $session = $request->request->get('session');
        $term = $request->request->get('term');
        $class = $request->request->get('class_id');
        $section = $request->request->get('section_id');

        $dataserializer = new DataSerializer;

        $resultProcesser = new ResultProcesser;
        $results = $resultProcesser->process($exams, $grades, $second_cas, $first_cas, $totals);
        
        $em = $this->getDoctrine()->getManager();

        $resultProcesser->record($results, $date, $session, $term, $subject, $section, $class, $em);

        $return = ['error' => false];
        $groups = ['groups' => ['exam_result:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/record-student-results", name="record_student_results", methods="POST")
     */
    public function create(Request $request)
    {
        $subjects = $request->request->get('subject');
        $grades = $request->request->get('grade');
        $exams = $request->request->get('exam');
        $second_cas = $request->request->get('second_ca');
        $first_cas = $request->request->get('first_ca');
        $totals = $request->request->get('total');
        $date = $request->request->get('date');
        $session = $request->request->get('session');
        $term = $request->request->get('term');
        $class = $request->request->get('class_id');
        $section = $request->request->get('section_id');
        $student = $request->request->get('student_id');

        $dataserializer = new DataSerializer;
        $results = [];
        foreach($exams as $subject_id => $exam){
            foreach ($grades as $subject_id2 => $grade) {
                foreach ($second_cas as $subject_id3 => $second_ca) {
                    foreach ($first_cas as $subject_id4 => $first_ca) {
                        foreach ($totals as $subject_id5 => $total) {
                            if ($subject_id === $subject_id2 && $subject_id === $subject_id3 && $subject_id === $subject_id4 && $subject_id === $subject_id5 && $subject_id2 === $subject_id3 && $subject_id2 === $subject_id4 && $subject_id2 === $subject_id5 && $subject_id3 === $subject_id4 && $subject_id3 === $subject_id5 && $subject_id4 === $subject_id5) {
                                array_push($results, ['subject_id' => $subject_id, 'grade' => $grade, 'exam' => $exam, 'total' => $total, 'first_ca' => $first_ca, 'second_ca' => $second_ca]);
                            }                                                
                        }
                    }
                }
            }
        }

        $em = $this->getDoctrine()->getManager();        
        $resultProcesser = new ResultProcesser;
        $resultProcesser->recordSingleStudent($results, $date, $session, $term, $section, $class, $student, $em);

        $session_entity = $em->getRepository(Session::class)->find($session);
        $term_entity = $em->getRepository(Term::class)->find($term);
        $formatedRecord = $resultProcesser->formatter($results, $em);

        $return = ['error' => false, 'results' => $formatedRecord, 'session' => $session_entity->getSession(), 'term' => $term_entity->getTermCode()];
        $groups = ['groups' => ['exam_result:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);        
    }

    /**
     * @Route("/check-exam-records", name="check_exam_records", methods="POST")
     */
    public function checkExamRecord(Request $request)
    {
        $session = $request->request->get('session');
        $term = $request->request->get('term');
        $student_id = $request->request->get('student_id');
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository(ExamResult::class)->findBy(['session' => $session, 'term' => $term, 'student' => $student_id]);

        $dataserializer = new DataSerializer;

        if (!$results) {
            $return = ['error' => true, 'message' => "No exam records"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $student = $em->getRepository(StudentInfo::class)->find($student_id);
        
        // $record = new TakeSubjectResults();
        // $allRecords = $record->checkExamRecords($results, $em);
        $return = ['error' => false, 'records' => $results, 'firstname' => $student->getFirstname(), 'lastname' => $student->getLastname()];
        $groups = ['groups' => ['exam_result:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/update-exam-results", name="edit_exam_results", methods="POST")
     */
    public function update(Request $request)
    {
        $grades = $request->request->get('grade');
        $exams = $request->request->get('exam');
        $second_cas = $request->request->get('second_ca');
        $first_cas = $request->request->get('first_ca');
        $totals = $request->request->get('total');
        $date = $request->request->get('date');
        $session = $request->request->get('session');
        $term = $request->request->get('term');
        $class = $request->request->get('class_id');
        $section = $request->request->get('section_id');
        $student = $request->request->get('student_id');

        $dataserializer = new DataSerializer;
                
        $results = [];
        foreach($exams as $subject_id => $exam){
            foreach ($grades as $subject_id2 => $grade) {
                foreach ($second_cas as $subject_id3 => $second_ca) {
                    foreach ($first_cas as $subject_id4 => $first_ca) {
                        foreach ($totals as $subject_id5 => $total) {
                            if ($subject_id === $subject_id2 && $subject_id === $subject_id3 && $subject_id === $subject_id4 && $subject_id === $subject_id5 && $subject_id2 === $subject_id3 && $subject_id2 === $subject_id4 && $subject_id2 === $subject_id5 && $subject_id3 === $subject_id4 && $subject_id3 === $subject_id5 && $subject_id4 === $subject_id5) {
                                array_push($results, ['subject_id' => $subject_id, 'grade' => $grade, 'exam' => $exam, 'total' => $total, 'first_ca' => $first_ca, 'second_ca' => $second_ca]);
                            }                                                
                        }
                    }
                }
            }
        }
        $em = $this->getDoctrine()->getManager();

        $resultProcesser = new ResultProcesser;
        $resultProcesser->updateRecords($results, $date, $session, $term, $section, $class, $student, $em);
        
        $return = ['error' => false, 'message' => "Successfully Updated"];
        $data = $dataserializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
        
    }
}