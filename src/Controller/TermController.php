<?php

namespace App\Controller;


use App\Entity\Term;
use App\Repository\TermRepository;
use App\Service\DataSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TermController extends AbstractController
{


     /**
     * @Route("/terms", name="all_terms", methods="POST")
     */
    public function getTerms()
    {
        $terms = $this->getDoctrine()->getRepository(Term::class)->findAll();
        $dataserializer = new DataSerializer;
        if (!$terms) {
            $return = ['error' => true, 'message' => 'No Term found'];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }
        
        $return = ['error' => false, 'terms' => $terms];
        $groups = ['groups' => ['term:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

     /**
     * @Route("/new-term", name="new_term", methods="POST")
     */
    public function new(Request $request, TermRepository $repo)
    {
        $return = [];
        $term_code = $request->request->get('code');
        $term_description = $request->request->get('description');

        $stmt = $repo->findIfCodeExists($term_code);
        $stmt2 = $repo->findIfDescriptionExists($term_description);
        $dataserializer = new DataSerializer;
        
        if($stmt->rowCount() == 1){
            $return = ['error' => true, 'message' => 'This term code exists already.'];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }elseif($stmt2->rowCount() == 1){
            $return = ['error' => true, 'message' => 'This description exists already.'];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $term = new Term;
        $term->setTermCode($term_code);
        $term->setTermDescription($term_description);
        
        $em = $this->getDoctrine()->getManager();

        $em->persist($term);
        
        $em->flush();
        $return = ['error' => false, 'term' => $term];
        $groups = ['groups' => ['term:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/edit-term", name="edit_term", methods="POST")
     */
    public function edit(Request $request)
    {   
        $id = $request->request->get('id');
        $term_code = $request->request->get('code');
        $term_description = $request->request->get('description');
        
        $dataserializer = new DataSerializer;
        if (!$term_code || !$term_description) {            
            $return = ['error' => true, 'message' => 'Fill all fields'];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }
        $term = new Term();
        $term = $this->getDoctrine()->getRepository(Term::class)->find($id);
     
        $term->setTermCode($term_code);
        $term->setTermDescription($term_description);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        $terms = $this->getDoctrine()->getRepository(Term::class)->findAll();

        $return = ['error' => false, 'terms' => $terms];
        $groups = ['groups' => ['term:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/delete-term", name="delete_term", methods="POST")
     */
    public function delete(Request $request){
        
        $term_id = $request->request->get('id');
        $term = $this->getDoctrine()->getRepository(Term::class)->find($term_id);
        $dataserializer = new DataSerializer;

        if (!$term) {
            $return = ['error' => true, 'message' => "This term does not exist"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($term);
        $em->flush();

        $return = ['error' => false, 'term' => $term];
        $data = $dataserializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
    }

    
}
