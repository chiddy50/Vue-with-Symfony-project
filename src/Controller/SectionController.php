<?php

namespace App\Controller;

use App\Entity\Section;
use App\Entity\Exam;
use App\Repository\SectionRepository;
use App\Service\DataSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\IsTrueValidator;

class SectionController extends AbstractController
{
    
    /**
     * @Route("/new-section", name="new_section", methods="POST")
     */
    public function create(Request $request, SectionRepository $sectionRepository)
    {
        $section = new Section;
        $section_name = $request->request->get('section_name');
        $section_code = $request->request->get('section_code');
        $entryBy = 2;
        $dataserializer = new DataSerializer;

        if (!$section_name || !$section_code) {            
            $return = ['error' => true, 'message' => 'Fill all fields'];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }
        $stmt = $sectionRepository->findIfSectionNameExists($section_name);
        $stmt2 = $sectionRepository->findIfSectionCodeExists($section_code);

        if($stmt->rowCount() == 1){
            $return = ['error' => true, 'message' => "This section name exists already."];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }elseif($stmt2->rowCount() == 1){
            $return = ['error' => true, 'message' => "This section code exists already."];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $section->setSectionName($section_name);
        $section->setSectionCode($section_code);
        $section->setEntryBy($entryBy);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($section);
        $em->flush();

        $return = ['error' => false, 'section' => $section];
        $groups = ['groups' => ['section:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/all-section", name="all_section", methods="POST")
     */
    public function all()
    {   
        $sections = $this->getDoctrine()->getRepository(Section::class)->findAll();
        $dataserializer = new DataSerializer;
        
        if (!$sections) {
            $return = ['error' => true, 'message' => "No section found"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $return = ['error' => false, 'sections' => $sections];
        $groups = ['groups' => ['section:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/edit-section", name="edit_section", methods="POST")
     */
    public function edit(Request $request, SectionRepository $repo)
    {   
        $id = $request->request->get('id');
        $section_name = $request->request->get('section_name');
        $section_code = $request->request->get('section_code');
        $entryBy = 2;

        $dataserializer = new DataSerializer;
        if (!$section_name || !$section_code) {            
            $return = ['error' => true, 'message' => 'Fill all fields'];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }
        $section = new Section();
        $section = $this->getDoctrine()->getRepository(Section::class)->find($id);
     
        $section->setSectionName($section_name);
        $section->setSectionCode($section_code);
        $section->setEntryBy($entryBy);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        $sections = $this->getDoctrine()->getRepository(Section::class)->findAll();

        $return = ['error' => false, 'sections' => $sections];
        $groups = ['groups' => ['section:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/delete-section", name="delete_section", methods="POST")
     */
    public function delete(Request $request, SectionRepository $repo){
        
        $section_id = $request->request->get('id');
        $section = $this->getDoctrine()->getRepository(Section::class)->find($section_id);
        $dataserializer = new DataSerializer;

        if (!$section) {
            $return = ['error' => true, 'message' => "This section does not exist"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }
        // $repo->deleteClass($section_id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($section);
        $em->flush();

        $return = ['error' => false, 'section' => $section];
        $data = $dataserializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
    }



}
