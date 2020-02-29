<?php
namespace App\Controller;

use App\Entity\Classes;
use App\Repository\ClassesRepository;
use App\Service\DataSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClassesController extends AbstractController
{
    
    /**
     * @Route("/newclass", name="new_class", methods="POST")
     */
    public function create(Request $request, ClassesRepository $classesRepository)
    {
        
        $return = [];
        $class_name = $request->request->get('class_name');
        $class_code = $request->request->get('class_code');
        $entryBy = 2;
        $stmt = $classesRepository->findIfClassNameExists($class_name);
        $stmt2 = $classesRepository->findIfClassCodeExists($class_code);
        $serializer = new DataSerializer;

        if($stmt->rowCount() === 1){
            $return = ['error' => true, 'message' => "This class name exists already."];
            $data = $serializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }elseif($stmt2->rowCount() === 1){
            $return = ['error' => true, 'message' => "This class code exists already."];
            $data = $serializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $class = new Classes;
        $class->setClassName($class_name);
        $class->setClassCode($class_code);
        $class->setEntryBy($entryBy);
        
        $em = $this->getDoctrine()->getManager();

        $em->persist($class);
        
        $em->flush();
    
        $return = ['error' => false, 'message' => "Successfully Created", 'created_class' => $class];
        $groups = ['groups' => ['class:add']];
        $data = $serializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }


    /**
     * @Route("/all-classes", name="our_class", methods="POST")
     */
    public function all()
    {   
        $classes = $this->getDoctrine()->getRepository(Classes::class)->findAll();
        $serializer = new DataSerializer;
        if (!$classes) {
            $return = ['error' => true, 'message' => "No class found"];
            $data = $serializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $return = ['error' => false, 'classes' => $classes];
        $groups = ['groups' => ['class:add']];
        $data = $serializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/edit-class", name="edit_class", methods="POST")
     */
    public function edit(Request $request)
    {   
        $id = $request->request->get('id');
        $class_name = $request->request->get('class_name');
        $class_code = $request->request->get('class_code');
        $entryBy = 2;

        $serializer = new DataSerializer;
        if (!$class_name || !$class_code) {            
            $return = ['error' => true, 'message' => 'Fill all fields'];
            $data = $serializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }
        $class = new Classes();
        $class = $this->getDoctrine()->getRepository(Classes::class)->find($id);

        $class->setClassName($class_name);
        $class->setClassCode($class_code);
        $class->setEntryBy($entryBy);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        $classes = $this->getDoctrine()->getRepository(Classes::class)->findAll();

        $return = ['error' => false, 'classes' => $classes];
        $groups = ['groups' => ['class:add']];
        $data = $serializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/delete-class", name="delete_class", methods="POST")
     */
    public function delete(Request $request, ClassesRepository $classesRepository){
        
        $class_id = $request->request->get('id');
        $class = $this->getDoctrine()->getRepository(Classes::class)->find($class_id);
        $serializer = new DataSerializer;

        if (!$class) {
            $return = ['error' => true, 'message' => "This class does not exist"];
            $data = $serializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }
        $classesRepository->deleteClass($class_id);

        $return = ['error' => false, 'class' => $class];
        $data = $serializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
    }
    
   
}
