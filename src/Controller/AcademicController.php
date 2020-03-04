<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Section;
use App\Entity\StudentGroup;
use App\Entity\StudentInfo;
use App\Entity\Subjects;
use App\Repository\ClassesRepository;
use App\Repository\StudentGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AcademicController extends AbstractController
{
    

    /**
     * @Route("/return-students-by-class", name="return_class_student")
     */
    public function returnClassStudent(Request $request)
    {
        $id = $request->request->get('id');
        $students = $this->getDoctrine()->getRepository(StudentInfo::class)->findBy(['classes' => $id]);
        $class = $this->getDoctrine()->getRepository(Classes::class)->find($id);

        // return new JsonResponse(['students' => $students, 'class_name' => $class->getClassName()]);
        return $this->json(['students' => $students, 'class_name' => $class->getClassName()], 200, [], [
            'groups' => ['students', 'main'],
        ]);
    }

   

    /**
     * @Route("/allgroupsubjects", name="all_subject_group", methods="POST")
     */
    public function allGroupSubjects(StudentGroupRepository $groupRepo){

        $groupSubjects = $groupRepo->getGroupSubjects();

        return new JsonResponse(['group_subject' => $groupSubjects]);
    }

    

}
