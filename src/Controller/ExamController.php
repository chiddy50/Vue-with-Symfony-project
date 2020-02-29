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

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;

use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;


class ExamController extends AbstractController
{
    /**
     * @Route("/exam/new", name="new_exam", methods="POST")
     */
    public function create(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        $exam = new Exam;
    
        $exam_name = $request->request->get('exam_name');
        $subject = $request->request->get('subject');
        $class = $request->request->get('class');
        $section = $request->request->get('section');
        $group = $request->request->get('group');
        $session = $request->request->get('session');
        $term = $request->request->get('term');
        $time = $request->request->get('time');
        $date = $request->request->get('date');

        $subjectEntity = $this->getDoctrine()->getRepository(Subjects::class)->find($subject);
        $sectionEntity = $this->getDoctrine()->getRepository(Section::class)->find($section);
        $classEntity = $this->getDoctrine()->getRepository(Classes::class)->find($class);
        $studentGroupEntity = $this->getDoctrine()->getRepository(StudentGroup::class)->find($group);
        $sessionEntity = $this->getDoctrine()->getRepository(Session::class)->find($session);
        $termEntity = $this->getDoctrine()->getRepository(Term::class)->find($term);

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
        
        $dataserializer = new DataSerializer;
        $groups = ['groups' => ['exam:add']];
        $data = $dataserializer->serializeData($exam, $groups);
        
        return new JsonResponse(['error' => false, 'message' => "Exam Created", 'exam' => $data]);
        
    }

    /**
     * @Route("/examinations", name="all_exams", methods="POST")
     */
    public function getExams(){
        $exams = $this->getDoctrine()->getRepository(Exam::class)->findAll();
        $count = count($exams);
        if (!$exams) {
            return new JsonResponse(['error' => true, 'message' => "No Term found"]);
            exit;
        }

        $dataserializer = new DataSerializer;
        $groups = ['groups' => ['exam:add']];
        $data = $dataserializer->serializeData($exams, $groups);
        return new JsonResponse(['error' => false, 'exams' => $data]);
    }


} 
