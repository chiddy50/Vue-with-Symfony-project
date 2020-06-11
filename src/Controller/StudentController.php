<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Parents;
use App\Entity\Section;
use App\Entity\StudentGroup;
use App\Entity\Gender;
use DateTimeImmutable;
use App\Entity\StudentInfo;
use App\Entity\Subjects;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentInfoRepository;
use App\Service\DataSerializer;
use Symfony\Component\HttpFoundation\Request;

class StudentController extends AbstractController
{
    /**
     * @Route("/allstudents", name="all_students", methods="POST")
     */
    public function all(StudentInfoRepository $strepo)
    {
        $students = $this->getDoctrine()->getRepository(StudentInfo::class)->findAll();
        $dataserializer = new DataSerializer;

        if (!$students) {
            $return = ['error' => true, 'message' => "No student found"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }


        $return = ['error' => false, 'students' => $students];
        $groups = ['groups' => ['student:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/student/create", name="new_student", methods="POST")
     */
    public function create(Request $request, StudentInfoRepository $studentRepository)
    {

        $em = $this->getDoctrine()->getManager();
        $student = new StudentInfo;

        $firstname = $request->request->get('firstname');
        $lastname = $request->request->get('lastname');
        $email = $request->request->get('email');
        $roll_no = $request->request->get('roll_no');
        $class_id = $request->request->get('class_id');
        $dob = $request->request->get('dob');
        $admission_date = $request->request->get('admission_date');
        $student_group = $request->request->get('student_group');
        $parent_id = $request->request->get('parent_id');
        $gender_id = $request->request->get('gender_id');
        $section_id = $request->request->get('section_id');

        $stmt = $studentRepository->findIfRollExists($roll_no);

        if ($stmt->rowCount() == 1) {
            $message = "This Roll No exists already.";
            $error = true;
            $return = ['error' => $error, 'message' => $message];
            return new JsonResponse($return);
            exit;
        }

        $classEntity = $this->getDoctrine()->getRepository(Classes::class)->find($class_id);
        $sectionEntity = $this->getDoctrine()->getRepository(Section::class)->find($section_id);
        $parentEntity = $this->getDoctrine()->getRepository(Parents::class)->find($parent_id);
        $studentGroupEntity = $this->getDoctrine()->getRepository(StudentGroup::class)->find($student_group);
        $genderEntity = $this->getDoctrine()->getRepository(Gender::class)->find($gender_id);

        $student->setFirstname($firstname);
        $student->setLastname($lastname);
        $student->setEmail($email);
        $student->setDob(new DateTimeImmutable($dob));
        $student->setAdmissionDate(new DateTimeImmutable($admission_date));
        $student->setRollNo($roll_no);
        $student->setStudentGroup($studentGroupEntity);
        $student->setClasses($classEntity);
        $student->setParent($parentEntity);
        $student->setGender($genderEntity);
        $student->setSection($sectionEntity);

        $result = [];
        $em->persist($student);

        $em->flush();
        $error = false;
        $message = "Inserted successfully";
        $result = ['error' => $error, 'message' => $message];
        return new JsonResponse($result);
    }

    /**
     * @Route("/student-info", name="student_info", methods="POST")
     */
    public function studentInfo(Request $request)
    {
        $student_id = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository(StudentInfo::class)->find($student_id);

        $dataserializer = new DataSerializer;
        $return = ['error' => false, 'student' => $student];
        $groups = ['groups' => ['student:add']];
        $data = $dataserializer->serializeData($return, $groups);

        return new JsonResponse($data);
    }

    /**
     * @Route("/getstudentid", name="get_id_for_edit", methods="POST")
     */
    public function getStudentId(Request $request)
    {
        $student_id = $request->request->get('id');

        $student = new StudentInfo;
        $student = $this->getDoctrine()->getRepository(StudentInfo::class)->find($student_id);

        $gender_id = $student->getGender();
        $parent = $student->getParent();
        $classes = $student->getClasses();
        $section = $student->getSection();
        $student_group = $student->getStudentGroup();

        $class_entity = $this->getDoctrine()->getRepository(Classes::class)->find($classes);
        $parent_entity = $this->getDoctrine()->getRepository(Parents::class)->find($parent);
        $section_entity = $this->getDoctrine()->getRepository(Section::class)->find($section);
        $group_entity = $this->getDoctrine()->getRepository(StudentGroup::class)->find($student_group);
        $gender_entity =  $this->getDoctrine()->getRepository(Gender::class)->find($gender_id);

        return new JsonResponse([
            'id' => $student->getId(),
            'firstname' => $student->getFirstname(),
            'lastname' => $student->getLastname(),
            'email' => $student->getEmail(),
            'dob' => $student->getDob(),
            'admission_date' => $student->getAdmissionDate(),
            'gender' => $gender_entity->getGender(),
            'roll_no' => $student->getRollNo(),
            'parent_name' => $parent_entity->getFullname(),
            'class_name' => $class_entity->getClassName(),
            'section_name' => $section_entity->getSectionName(),
            'group_name' => $group_entity->getGroupName(),
            'parent_id' => $parent_entity->getId(),
            'class_id' => $class_entity->getId(),
            'section_id' => $section_entity->getId(),
            'group_id' => $group_entity->getId(),
            'gender_id' => $gender_entity->getId()
        ]);
    }

    // EDIT
    /**
     * @Route("/edit-student", name="edit_student", methods="POST")
     */
    public function edit(Request $request)
    {
        $student_id = $request->request->get('id');
        $firstname = $request->request->get('firstname');
        $lastname = $request->request->get('lastname');
        $email = $request->request->get('email');
        $roll_no = $request->request->get('roll_no');
        $class_id = $request->request->get('class_name');
        $student_group = $request->request->get('student_group');
        $parent_id = $request->request->get('parent');
        $gender_id = $request->request->get('gender');
        $section_id = $request->request->get('section');
        $dob = $request->request->get('dob');
        $admission_date = $request->request->get('admission_date');

        $dateDob = strstr($dob, " (", true);
        $dateDoa = strstr($admission_date, " (", true);


        $classEntity = $this->getDoctrine()->getRepository(Classes::class)->find($class_id);
        $sectionEntity = $this->getDoctrine()->getRepository(Section::class)->find($section_id);
        $parentEntity = $this->getDoctrine()->getRepository(Parents::class)->find($parent_id);
        $studentGroupEntity = $this->getDoctrine()->getRepository(StudentGroup::class)->find($student_group);
        $genderEntity = $this->getDoctrine()->getRepository(Gender::class)->find($gender_id);

        $student = new StudentInfo();
        $student = $this->getDoctrine()->getRepository(StudentInfo::class)->find($student_id);

        $student->setFirstname($firstname);
        $student->setLastname($lastname);
        $student->setEmail($email);
        $student->setStudentGroup($studentGroupEntity);
        $student->setRollNo($roll_no);
        $student->setClasses($classEntity);
        $student->setParent($parentEntity);
        $student->setGender($genderEntity);
        $student->setSection($sectionEntity);
        $student->setDob(new DateTimeImmutable($dateDob));
        $student->setAdmissionDate(new DateTimeImmutable($dateDoa));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $message = "Well done! You successfully edited " . $firstname . ' ' . $lastname;
        return new JsonResponse(['error' => false, 'message' => $message]);
    }

    /**
     * @Route("/deletestudent", name="delete_student", methods="POST")
     */
    public function delete(Request $request, StudentInfoRepository $repo)
    {

        $student_id = $request->request->get('id');
        // $student = $this->getDoctrine()->getRepository(StudentInfo::class)->find($student_id);
        $repo->removeStudent($student_id);
        // if (!$student) {
        //     return new JsonResponse(['error' => false, 'message' => 'Error']);
        // }

        // $em = $this->getDoctrine()->getManager();
        // $em->remove($student);
        // $em->flush();
        return new JsonResponse(['error' => true, 'message' => 'Deleted',]);
    }


    /**
     * @Route("/countstudents", name="student_count", methods="POST")
     */
    public function studentCount(StudentInfoRepository $studentRepo)
    {
        $count = $studentRepo->studentCount();
        return new JsonResponse(['count' => $count]);
    }

    /**
     * @Route("/searchstudent", name="student_search", methods="POST")
     */
    public function searchStudent(Request $request)
    {
        $class_id = $request->request->get('class_id');
        $section_id = $request->request->get('section_id');
        $student_group = $request->request->get('student_group');

        $dataserializer = new DataSerializer;

        if (empty($class_id) or empty($section_id)) {
            $return = ['error' => true, 'message' => "Provide a class and section"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $students = $this->getDoctrine()->getRepository(StudentInfo::class)->findBy(['section' => $section_id, "classes" => $class_id]);

        if (!$students) {
            $return = ['error' => true, 'message' => "No student found"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }
        $subjects = '';
        //Get subjects 
        if (!empty($student_group)) {
            $subjects = $this->getDoctrine()->getRepository(Subjects::class)->getGroupSubjects($student_group);
        }

        $classes = $this->getDoctrine()->getRepository(Classes::class)->find($class_id);
        $sections = $this->getDoctrine()->getRepository(Section::class)->find($section_id);
        $class_name = $classes->getClassName();
        $section_name = $sections->getSectionName();

        $return = [
            'error' => false, 
            'students' => $students, 
            'class_name' => $class_name, 
            'section_name' => $section_name, 
            'subjects' => $subjects
        ];
        $groups = ['groups' => ['student:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/live-search", name="live_searches", methods="POST")
     */
    public function liveSearch(Request $request)
    {
        $name = $request->request->get('name');
        $students = $this->getDoctrine()->getRepository(StudentInfo::class)->liveSearch($name);
        $dataserializer = new DataSerializer;
        if ($name === '') {
            $return = ['error' => false, 'students' => []];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $return = ['error' => false, 'students' => $students];
        $groups = ['groups' => ['student:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/generate-number", name="generate_number", methods="POST")
     */
    public function generateNumber(Request $request)
    {
        $roll_no = $request->request->get('roll_no');
        $number = $this->getDoctrine()->getRepository(StudentInfo::class)->generateNumber($roll_no);


        $dataserializer = new DataSerializer;
        if ($roll_no === '') {
            $return = ['error' => false, 'students' => []];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }
        $return = ['error' => false, 'students' => $number];
        $groups = ['groups' => ['student:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }
    
}
