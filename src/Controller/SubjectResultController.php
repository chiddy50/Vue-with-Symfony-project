<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Entity\Session;
use App\Entity\StudentInfo;
use App\Entity\SubjectResult;
use App\Entity\Subjects;
use App\Entity\Term;
use App\Repository\SubjectResultRepository;
use App\Service\DataSerializer;
use App\Service\TakeSubjectResults;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SubjectResultController extends AbstractController
{

    /**
     * @Route("/record-exam-scores", name="score_subjects", methods="POST")
     */
    public function scoreSubjects(Request $request){
        $subjects = $request->request->get('subject');
        $grades = $request->request->get('grade');
        $student_score = $request->request->get('student_score');
        $student_id = $request->request->get('student_id');
        $date = $request->request->get('date');
        $session = $request->request->get('session');
        $term = $request->request->get('term');
        $dataserializer = new DataSerializer;
        
        $results = [];
        foreach($subjects as $subject_id => $value){
            foreach ($grades as $subject_id2 => $grade) {
                foreach ($student_score as $subject_id3 => $score) {
                    if ($subject_id === $subject_id3 && $subject_id === $subject_id2 && $subject_id3 === $subject_id2) {
                        array_push($results, ['subject' => $subject_id, 'term' => $term, 'grade' => $grade, 'score' => $score, 'session' => $session, 'date' => $date, 'student_id' => $student_id]);
                    }                    
                }
            }
        }
        $em = $this->getDoctrine()->getManager();
        $session_entity = $em->getRepository(Session::class)->find($session);
        $term_entity = $em->getRepository(Term::class)->find($term);

        $record = new TakeSubjectResults();
        $record->recordSubject($results, $student_id, $session, $date, $term, $em);
        $formatedRecord = $record->formatter($results, $em);
        
        $return = ['error' => false, 'results' => $formatedRecord, 'session' => $session_entity->getSession(), 'term' => $term_entity->getTermCode()];
        $groups = ['groups' => ['subject_result:add']];
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
        $results = $em->getRepository(SubjectResult::class)->getStudentsExamResults($session, $student_id, $term);
        $dataserializer = new DataSerializer;

        if (!$results) {
            $return = ['error' => true, 'message' => "No exam records"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        // dd($results);
        
        // $em = $this->getDoctrine()->getManager();        
        // $record = new TakeSubjectResults();
        // $allRecords = $record->checkExamRecords($results, $em);

        // return new JsonResponse(['error' => false, 'records' => $results]);
        $return = ['error' => false, 'records' => $results];
        $groups = ['groups' => ['subject_result:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }
    
}
