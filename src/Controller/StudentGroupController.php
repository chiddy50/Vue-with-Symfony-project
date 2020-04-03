<?php

namespace App\Controller;

use App\Entity\StudentGroup;
use App\Entity\StudentInfo;
use App\Entity\Subjects;
use DateTimeImmutable;
use App\Repository\StudentGroupRepository;
use App\Repository\SubjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\DataSerializer;
use Symfony\Component\HttpFoundation\Request;


class StudentGroupController extends AbstractController
{
    
    /**
     * @Route("/new-student-group", name="new_student_group", methods="POST")
     */
    public function create(Request $request)
    {
        $group_name = $request->request->get('group_name');
        $dataserializer = new DataSerializer;

        if(empty($group_name)){
            $return = ['error' => true, 'message' => 'Please provide a group name'];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $student_group = new StudentGroup;
        $student_group->setGroupName($group_name);
        $em = $this->getDoctrine()->getManager();
        $em->persist($student_group);
        $em->flush();
        
        $return = ['error' => false, 'student_group' => $student_group];
        $groups = ['groups' => ['student_group:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/student-groups", name="all_group", methods="POST")
     */
    public function getGroups()
    {
        $student_groups = $this->getDoctrine()->getRepository(StudentGroup::class)->findAll();
        $dataserializer = new DataSerializer;

        if (!$student_groups) {            
            $return = ['error' => true, 'message' => 'No group found'];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $return = ['error' => false, 'student_groups' => $student_groups];
        $groups = ['groups' => ['student_group:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/edit-student-group", name="edit_student_group", methods="POST")
     */
    public function edit(Request $request, StudentGroupRepository $repo)
    {   
        $id = $request->request->get('id');
        $group_name = $request->request->get('group_name');
        $dataserializer = new DataSerializer;

        if (!$group_name) {            
            $return = ['error' => true, 'message' => 'Please provide a group name'];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $group = new StudentGroup();
        $group = $this->getDoctrine()->getRepository(StudentGroup::class)->find($id);        
        $group->setGroupName($group_name);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        $groups = $this->getDoctrine()->getRepository(StudentGroup::class)->findAll();

        $return = ['error' => false, 'student_groups' => $groups];
        $groups = ['groups' => ['student_group:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/delete-student-group", name="delete_student_group", methods="POST")
     */
    public function delete(Request $request){
        
        $group_id = $request->request->get('id');
        $group = $this->getDoctrine()->getRepository(StudentGroup::class)->find($group_id);
        $dataserializer = new DataSerializer;

        if (!$group) {
            $return = ['error' => true, 'message' => "This student group does not exist"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }
        // $repo->deleteClass($group_id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($group);
        $em->flush();

        $return = ['error' => false, 'stduent_group' => $group];
        $data = $dataserializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
    }

     /**
     * @Route("/new-subject-group", name="new_subject_group", methods="POST")
     */
    public function newGroupSubject(Request $request, StudentGroupRepository $repo)
    {
        $subjects = $request->request->get('subject');
        $group_id = $request->request->get('group_id');

        $dataserializer = new DataSerializer;
        $exists = [];
        $not_exist = [];
        foreach ($subjects as $subject_name => $subject) {
            $stmt = $repo->subjectGroupExistense($group_id, $subject);
            // dd($stmt->fetch());
            
            if($stmt->rowCount() === 1){
                array_push($exists, $subject_name);
            }else{
                array_push($not_exist, $subject_name);

                $group = $this->getDoctrine()->getRepository(StudentGroup::class)->find($group_id);
                $subject = $this->getDoctrine()->getRepository(Subjects::class)->find($subject);
                $group->addSubject($subject);
                $em = $this->getDoctrine()->getManager();
                $em->persist($group);
                $em->flush();
            }
        }
        
        $return = ['error' => false, 'message' => 'Successfully Added.', 'exists' => $exists, 'non' => $not_exist];
        $data = $dataserializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
        exit;
    }


     /**
     * @Route("/get-group-subjects", name="get_group_subjects", methods="POST")
     */
    public function getGroupSubjects(Request $request)
    {
        $group_id = $request->request->get('group_id');
        $subjects = $this->getDoctrine()->getRepository(Subjects::class)->getGroupSubjects($group_id);
        
        $subject_ids = [];
        foreach ($subjects as $key => $value) {
            array_push($subject_ids, $value['id']);
        }

        $dataserializer = new DataSerializer;
        if (!$subjects) {
            $return = ['error' => true, 'message' => "No subjects"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit();
        }


        $return = ['error' => false, 'subjects' => $subjects, 'subject_ids' => $subject_ids];
        $groups = ['groups' => ['subject:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

     /**
     * @Route("/get-student-subjects", name="get_student_subjects", methods="POST")
     */
    public function getStudentsSubjects(Request $request)
    {
        $student_id = $request->request->get('id');

        $student = $this->getDoctrine()->getRepository(StudentInfo::class)->find($student_id);
        $firstname = $student->getFirstname();
        $lastname = $student->getLastname();
        $classes = $student->getClasses()->getId();
        $section = $student->getSection()->getId();
        $group_id = $student->getStudentGroup()->getId();

        $subjects = $this->getDoctrine()->getRepository(Subjects::class)->getGroupSubjects($group_id);
        $dataserializer = new DataSerializer;
        
        $return = ['error' => false, 'subjects' => $subjects, 'firstname' => $firstname, 'lastname' => $lastname, 'class_id' => $classes, 'section_id' => $section];
        $groups = ['groups' => ['student_group:add', 'class:add', 'section:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }



}