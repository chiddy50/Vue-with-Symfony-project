<?php

namespace App\Controller;

use App\Entity\Parents;
use App\Repository\ParentsRepository;
use App\Service\DataSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ParentController extends AbstractController
{
    /**
     * @Route("/parents", name="show_parents", methods="POST")
     */
    public function all()
    {
        $parents = $this->getDoctrine()->getRepository(Parents::class)->findAll();
        $dataserializer = new DataSerializer;

        if (!$parents) {
            $return = ['error' => true, 'message' => "No section found"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $return = ['error' => false, 'parents' => $parents];
        $data = $dataserializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
    }

    /**
     * @Route("/newparent", name="new_parent", methods="POST")
     */
    public function create(Request $request)
    {
        $dataserializer = new DataSerializer;
        $parent = new Parents;
        $fullname = $request->request->get('fullname');
        $phone = $request->request->get('phone');
        $address = $request->request->get('address');
        $email = $request->request->get('email');
        $gender = $request->request->get('gender');
        if (empty($fullname) or empty($phone) or empty($address) or empty($gender)) {
            $return = ['error' => true, 'message' => "All fields are required"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $parent->setFullName($fullname);
        $parent->setAddress($address);
        $parent->setPhone($phone);
        $parent->setEmail($email);
        $parent->setGender($gender);

        $em = $this->getDoctrine()->getManager();
        $em->persist($parent);
        $em->flush();

        $return = ['error' => false, 'parent' => $parent];
        $data = $dataserializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
    }

    /**
     * @Route("/delete-parent", name="delete_parent", methods="POST")
     */
    public function delete(Request $request)
    {

        $parent_id = $request->request->get('id');
        $parent = $this->getDoctrine()->getRepository(Parents::class)->find($parent_id);
        $dataserializer = new DataSerializer;

        if (!$parent) {
            $return = ['error' => true, 'message' => "This parent does not exist"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($parent);
        $em->flush();
        $return = ['error' => false, 'parent' => $parent];
        $data = $dataserializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
    }

    /**
     * @Route("/edit-parent", name="edit_parent", methods="POST")
     */
    public function edit(Request $request)
    {
        $id = $request->request->get('id');
        $fullname = $request->request->get('fullname');
        $phone = $request->request->get('phone');
        $address = $request->request->get('address');
        $email = $request->request->get('email');
        $gender = $request->request->get('gender');

        $dataserializer = new DataSerializer;
        if (empty($fullname) or empty($phone) or empty($address) or empty($gender)) {
            $return = ['error' => true, 'message' => "All fields are required"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $parent = new Parents();
        $parent = $this->getDoctrine()->getRepository(Parents::class)->find($id);

        $parent->setFullName($fullname);
        $parent->setAddress($address);
        $parent->setPhone($phone);
        $parent->setEmail($email);
        $parent->setGender($gender);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $parents = $this->getDoctrine()->getRepository(Parents::class)->findAll();

        $return = ['error' => false, 'parents' => $parents];
        $data = $dataserializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
    }

    /**
     * @Route("/parentview", name="parent_view_id", methods="POST")
     */
    public function getId(Request $request)
    {
        $id = $request->request->get('id');
        $parent = new Parents();
        $parent = $this->getDoctrine()->getRepository(Parents::class)->find($id);

        $dataserializer = new DataSerializer;
        $return = ['error' => false, 'parent' => $parent];
        $data = $dataserializer->serializeWithoutGroup($return);

        return new JsonResponse($data);
    }



    /**
     * @Route("/countparents", name="parent_count", methods="POST")
     */
    public function parentCount(ParentsRepository $parentsRepository)
    {
        $count = $parentsRepository->countParents();
        return new JsonResponse(['count' => $count]);
    }
}
