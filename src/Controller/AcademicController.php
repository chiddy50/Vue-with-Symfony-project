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
     * @Route("/newgroupsubject", name="new_group_subject", methods="POST")
     */
    public function newgroupSubject(EntityManagerInterface $em, Request $request, StudentGroupRepository $stRepo)
    {
        $subject_id = $request->request->get('subject_id');
        $group_id = $request->request->get('group_id');
        $stmt = $stRepo->findIfClassCodeExists($group_id, $subject_id);
        if($stmt->rowCount() == 1){
            $message = "This exists already.";
            $error = true;
            $return = ['error' => $error, 'message' => $message];
            return new JsonResponse($return);
            exit;
        }

        $group = $em->getRepository(StudentGroup::class)->find($group_id);
        $subject = $em->getRepository(Subjects::class)->find($subject_id);
        $group->addSubject($subject);

        $em->persist($group);
        $em->flush();

        $message = "Successfully Added.";
        $error = false;
        $return = ['error' => $error, 'message' => $message];
        return new JsonResponse($return);
    }

    /**
     * @Route("/allgroupsubjects", name="all_subject_group", methods="POST")
     */
    public function allGroupSubjects(StudentGroupRepository $groupRepo){

        $groupSubjects = $groupRepo->getGroupSubjects();

        return new JsonResponse(['group_subject' => $groupSubjects]);
    }

    

}
