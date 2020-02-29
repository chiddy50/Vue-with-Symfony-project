<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Repository\GradeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GradeController extends AbstractController
{


     /**
     * @Route("/grades", name="all_grades", methods="POST")
     */
    public function getGrades()
    {
        $grades = $this->getDoctrine()->getRepository(Grade::class)->findAll();
        if (!$grades) {
            $message = "No grade found";
            $error = true;
            return new JsonResponse(['error' => $error, 'message' => $message]);
            exit;
        }

        $message = "Successfully retrieved data";
        $error = false;
        return new JsonResponse(['error' => $error, 'message' => $message, 'grades' => $grades]);
    }

    /**
     * @Route("/grade/new", name="new_grade", methods="POST")
     */
    public function newGrade(Request $request, GradeRepository $repo)
    {
        $name = $request->request->get('grade');
        $description = $request->request->get('description');
        $percent_from = $request->request->get('percent_from');
        $percent_upto = $request->request->get('percent_upto');
        $comment = $request->request->get('comment');

        $stmt = $repo->findIfGradeExists($name);

        if($stmt->rowCount() == 1){
            $message = "This grade name exists already.";
            $error = true;
            return new JsonResponse(['error' => $error, 'message' => $message]);
            exit;
        }

        $grade = new Grade;
        $grade->setGrade($name);
        $grade->setDescription($description);
        $grade->setPercentFrom($percent_from);
        $grade->setPercentUpto($percent_upto);
        $grade->setComment($comment);
        
        $em = $this->getDoctrine()->getManager();

        $em->persist($grade);
        
        $em->flush();
        $message = "Successfully Created";
        $error = false;
        return new JsonResponse(['error' => $error, 'message' => $message, 'grade' => $grade]);
    }



    
}
