<?php

namespace App\Controller;

use App\Entity\Gender;
use App\Entity\Month;
use App\Entity\Session;
use App\Repository\StudentInfoRepository;
use App\Service\DataSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/{vueRoute}/{slug}", name="home_app", methods="GET")
     */
    public function home($vueRoute = "", $slug = "")
    {
        return $this->render('home/index.html.twig');
    }


    /**
     * @Route("/genders", name="all_class", methods="POST")
     */
    public function getGenders()
    {
        $genders = $this->getDoctrine()->getRepository(Gender::class)->findAll();
        if (!$genders) {
            $return = ['error' => true, 'message' => "No gender found"];
            $dataserializer = new DataSerializer;
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $return = ['error' => false, 'genders' => $genders];
        $dataserializer = new DataSerializer;
        $groups = ['groups' => ['gender:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/months", name="all_month", methods="POST")
     */
    public function getMonths()
    {
        $months = $this->getDoctrine()->getRepository(Month::class)->findAll();
        if (!$months) {
            $return = ['error' => true, 'message' => "No month found"];
            $dataserializer = new DataSerializer;
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $return = ['error' => false, 'months' => $months];
        $dataserializer = new DataSerializer;
        $groups = ['groups' => ['month:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/sessions", name="all_session", methods="POST")
     */
    public function getSessions()
    {
        $sessions = $this->getDoctrine()->getRepository(Session::class)->findAll();
        $return = [];
        if (!$sessions) {
            $return = ['error' => true, 'message' => "No session found"];
            $dataserializer = new DataSerializer;
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $return = ['error' => false, 'sessions' => $sessions];
        $dataserializer = new DataSerializer;
        $groups = ['groups' => ['session:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/gendercount", name="student_gender", methods="POST")
     */
    public function selectGender(StudentInfoRepository $studentRepo)
    {
        $males = $this->getDoctrine()->getRepository(Gender::class)->findOneBy(['gender' => 'male']);
        $females = $this->getDoctrine()->getRepository(Gender::class)->findOneBy(['gender' => 'female']);

        $male_count = $studentRepo->maleGender($males->getId());
        $female_count = $studentRepo->femaleGender($females->getId());

        return new JsonResponse(['male_count' => count($male_count), 'female_count' => count($female_count)]);
    }
}
