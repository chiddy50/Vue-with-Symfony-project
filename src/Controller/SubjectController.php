<?php

namespace App\Controller;

use App\Entity\StudentGroup;
use App\Entity\StudentInfo;
use App\Entity\Subjects;
use App\Entity\SubjectType;
use App\Repository\SubjectsRepository;
use App\Repository\SubjectTypeRepository;
use App\Service\DataSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SubjectController extends AbstractController
{
    
    /**
     * @Route("/new-subject", name="new_subject", methods="POST")
     */
    public function create(Request $request, SubjectsRepository $subjectRepository)
    {
        $subject_name = $request->request->get('subject_name');
        $subject_code = $request->request->get('subject_code');
        $subject_type = $request->request->get('subject_type');
        $entryBy = 2;
        $dataserializer = new DataSerializer;

        if (!$subject_name || !$subject_code || !$subject_type) {            
            $return = ['error' => true, 'message' => "Fill all fields"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }
        $stmt = $this->getDoctrine()->getRepository(Subjects::class)->checkIfSubjectExist($subject_name, $subject_code);
        
        if($stmt->rowCount() === 1){
            $return = ['error' => true, 'message' => "This subject exists already."];           
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit();
        }
        
        
        $subject_type_entity = $this->getDoctrine()->getRepository(SubjectType::class)->find($subject_type);
        
        $subject = new Subjects;
        $subject->setSubject($subject_name);
        $subject->setSubjectCode($subject_code);
        $subject->setSubjectType($subject_type_entity);
        $subject->setEntryBy($entryBy);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($subject);
        $em->flush();

        $return = ['error' => false, "subject" => $subject];       
        $groups = ['groups' => ['subject:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/all-subjects", name="all_subject", methods="POST")
     */
    public function all()
    {   
        $subjects = $this->getDoctrine()->getRepository(Subjects::class)->findAll();
        $dataserializer = new DataSerializer;
        if (!$subjects) {
            $return = ['error' => true, 'message' => "No Subject found"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $return = ['error' => false, 'subjects' => $subjects];
        $groups = ['groups' => ['subject:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/delete-subject", name="delete_subject", methods="POST")
     */
    public function delete(Request $request, SubjectsRepository $subjectRepository)
    {
        
        $subject_id = $request->request->get('id');
        $subject = $this->getDoctrine()->getRepository(Subjects::class)->find($subject_id);
        $dataserializer = new DataSerializer;

        if (!$subject) {
            $return = ['error' => true, 'message' => "This subject does not exist"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }
        $subjectRepository->deleteSubject($subject_id);

        // $em = $this->getDoctrine()->getManager();
        // $em->remove($subject);
        // $em->flush();

        $return = ['error' => false, 'type' => $subject];
        $data = $dataserializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
    }

    /**
     * @Route("/edit-subject", name="edit_subject", methods="POST")
     */
    public function edit(Request $request, SubjectsRepository $subjectRepository)
    {
        $id = $request->request->get('id');
        $subject_name = $request->request->get('subject_name');
        $subject_code = $request->request->get('subject_code');
        $subject_type = $request->request->get('subject_type');

        $subject = new Subjects();
        $subject = $this->getDoctrine()->getRepository(Subjects::class)->find($id);
        $subjectTypeEntity = $this->getDoctrine()->getRepository(SubjectType::class)->find($subject_type);
        
        // $stmt = $this->getDoctrine()->getRepository(Subjects::class)->checkIfSubjectExist($subject_name);
        // $stmt2 = $this->getDoctrine()->getRepository(Subjects::class)->checkIfSubjectCodeExist($subject_code);
        $dataserializer = new DataSerializer;


        $subject->setSubject($subject_name);
        $subject->setSubjectCode($subject_code);
        $subject->setSubjectType($subjectTypeEntity);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $subjects = $this->getDoctrine()->getRepository(Subjects::class)->findAll();

        $return = ['error' => false, 'subjects' => $subjects];
        $groups = ['groups' => ['subject:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    // Subject type routes

    /**
     * @Route("/new-subtype", name="new_subject_type", methods="POST")
     */
    public function newSubjectType(Request $request, SubjectTypeRepository $subTypeRepository)
    {
        $subject_type = $request->request->get('subject_type');
        $entryBy = 2;
        $dataserializer = new DataSerializer;

        if (!$subject_type) {
            $return = ['error' => true, 'message' => "Sorry, this field cannot be empty"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }
        $stmt = $subTypeRepository->findIfSubjectTypeExists($subject_type);
        if($stmt->rowCount() === 1){
            $return = ['error' => true, 'message' => "This subject type exists already."];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $subType = new SubjectType;
        $subType->setSubjectType($subject_type);
        $subType->setEntryBy($entryBy);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($subType);
        $em->flush();
        
        $return = ['error' => false, "type" => $subType];
        $groups = ['groups' => ['subject:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/all-subject-type", name="all_subject_type", methods="POST")
     */
    public function allSubjectType()
    {   
        $subjectTypes = $this->getDoctrine()->getRepository(SubjectType::class)->findAll();
        $dataserializer = new DataSerializer;
        if (!$subjectTypes) {
            $return = ['error' => true, 'message' => "No Subject Type found"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $return = ['error' => false, 'types' => $subjectTypes];
        $groups = ['groups' => ['subject:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/delete-type", name="delete_type", methods="POST")
     */
    public function deleteSubjectType(Request $request)
    {
        
        $type_id = $request->request->get('id');
        $subType = $this->getDoctrine()->getRepository(SubjectType::class)->find($type_id);
        $dataserializer = new DataSerializer;

        if (!$subType) {
            $return = ['error' => true, 'message' => "This subject type does not exist"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($subType);
        $em->flush();

        $return = ['error' => false, 'type' => $subType];
        $data = $dataserializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
    }

    /**
     * @Route("/edit-type", name="edit_type", methods="POST")
     */
    public function editSubjectType(Request $request, SubjectTypeRepository $repo)
    {
        $id = $request->request->get('id');
        $subject_type = $request->request->get('subject_type');
        $entryBy = 2;
        $dataserializer = new DataSerializer;

        if (!$subject_type) {
            $return = ['error' => true, 'message' => "Sorry, this field cannot be empty"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $stmt = $repo->checkSubjectTypeExists($subject_type);
        if($stmt->rowCount() === 1){
            $return = ['error' => true, 'message' => "This subject type exists already."];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }
        
        $subType = new SubjectType();
        $subType = $this->getDoctrine()->getRepository(SubjectType::class)->find($id);
        $subType->setSubjectType($subject_type);
        $subType->setEntryBy($entryBy);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $subjectTypes = $this->getDoctrine()->getRepository(SubjectType::class)->findAll();

        $return = ['error' => false, 'types' => $subjectTypes];
        $groups = ['groups' => ['subject:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

   
}
