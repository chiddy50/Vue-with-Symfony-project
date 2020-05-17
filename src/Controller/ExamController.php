<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Exam;
use App\Entity\Section;
use App\Entity\Session;
use App\Entity\StudentGroup;
use App\Entity\Subjects;
use App\Entity\Term;
use App\Service\DataSerializer;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;



class ExamController extends AbstractController
{
    /**
     * @Route("/exam/new", name="new_exam", methods="POST")
     */
    public function create(Request $request)
    {
        $exam_name = $request->request->get('exam_name');
        $subject = $request->request->get('subject');
        $class = $request->request->get('class');
        $section = $request->request->get('section');
        $group = $request->request->get('group');
        $session = $request->request->get('session');
        $term = $request->request->get('term');
        $time = $request->request->get('time');
        $date = $request->request->get('date');

        $dataserializer = new DataSerializer;

        if (empty($exam_name)) {
            $return = ['error' => true, 'message' => 'All fields cannot be empty'];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $subjectEntity = $this->getDoctrine()->getRepository(Subjects::class)->find($subject);
        $sectionEntity = $this->getDoctrine()->getRepository(Section::class)->find($section);
        $classEntity = $this->getDoctrine()->getRepository(Classes::class)->find($class);
        $studentGroupEntity = $this->getDoctrine()->getRepository(StudentGroup::class)->find($group);
        $sessionEntity = $this->getDoctrine()->getRepository(Session::class)->find($session);
        $termEntity = $this->getDoctrine()->getRepository(Term::class)->find($term);

        $em = $this->getDoctrine()->getManager();
        $exam = new Exam;

        $exam->setExamName($exam_name);
        $exam->setSubject($subjectEntity);
        $exam->setClasses($classEntity);
        $exam->setSection($sectionEntity);
        $exam->setStudentGroup($studentGroupEntity);
        $exam->setSession($sessionEntity);
        $exam->setTerm($termEntity);
        $exam->setTime($time);
        $exam->setDate(new DateTimeImmutable($date));

        $em->persist($exam);
        $em->flush();

        $return = ['error' => false, 'exam' => $exam];
        $groups = ['groups' => ['exam:add']];
        $data = $dataserializer->serializeData($return, $groups);

        return new JsonResponse($data);
    }

    /**
     * @Route("/examinations", name="all_exams", methods="POST")
     */
    public function getAllExams()
    {
        $exams = $this->getDoctrine()->getRepository(Exam::class)->findAll();
        $count = count($exams);
        $dataserializer = new DataSerializer;

        if (!$exams) {
            $return = ['error' => true, 'message' => "No Exam found"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $groups = ['groups' => ['exam:add']];
        $data = $dataserializer->serializeData($exams, $groups);
        return new JsonResponse(['error' => false, 'exams' => $data]);
    }

    /**
     * @Route("/live-exam-search", name="live_exam_search", methods="POST")
     */
    public function liveSearch(Request $request)
    {
        $name = $request->request->get('name');
        $exams = $this->getDoctrine()->getRepository(Exam::class)->liveSearch($name);
        $dataserializer = new DataSerializer;
        if ($name === '') {
            $return = ['error' => false, 'exams' => []];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $return = ['error' => false, 'exams' => $exams];
        $groups = ['groups' => ['exam:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/exam-search", name="exam_search", methods="POST")
     */
    public function examSearch(Request $request)
    {
        $subject = $request->request->get('subject');
        $session = $request->request->get('session');
        $term = $request->request->get('term');
        $class = $request->request->get('class');
        $section = $request->request->get('section');
        $student_group = $request->request->get('student_group');
        $exams = $this->getDoctrine()->getRepository(Exam::class)->examSearch($subject, $session, $term, $class, $section, $student_group);
        $dataserializer = new DataSerializer;
        if (empty($subject) or empty($session) or empty($term) or empty($class) or empty($section) or empty($student_group)) {
            $return = ['error' => true, 'message' => 'All fields cannot be empty'];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $return = ['error' => false, 'exams' => $exams];
        $groups = ['groups' => ['exam:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }
}
