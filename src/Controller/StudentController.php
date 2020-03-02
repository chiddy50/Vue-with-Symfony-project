<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Parents;
use App\Entity\Section;
use App\Entity\StudentGroup;
use App\Entity\Gender;
use DateTimeImmutable;
use App\Entity\StudentInfo;
use App\Repository\StudentGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentInfoRepository;
use App\Repository\SubjectsRepository;
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

        if($stmt->rowCount() == 1){
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
     * @Route("/studentinfo", name="student_info", methods="POST")
     */
    public function studentInfo(Request $request, SubjectsRepository $subjectRepository)
    {

        $student_id = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository(StudentInfo::class)->find($student_id);

        $result = [];

        $id = $student->getStudentGroup();
        $firstname = $student->getFirstname();
        $lastname = $student->getLastname();
        $email = $student->getEmail();
        $roll_no = $student->getRollNo();
        $dob = $student->getDob();
        $gender_id = $student->getGender();
        $admission_date = $student->getAdmissionDate();
        $parent_id = $student->getParent();
        $class_id = $student->getClasses();
        $student_group_id = $student->getStudentGroup();
        $section_id = $student->getSection();

        $parent_entity = $em->getRepository(Parents::class)->find($parent_id);
        $class_entity = $em->getRepository(Classes::class)->find($class_id);
        $student_group_entity = $em->getRepository(StudentGroup::class)->find($student_group_id);
        $section_entity = $em->getRepository(Section::class)->find($section_id);
        $gender_entity = $em->getRepository(Gender::class)->find($gender_id);

        $parent_name = $parent_entity->getFullname();
        $class_name = $class_entity->getClassName();
        $section_name = $section_entity->getSectionName();
        $student_group_name = $student_group_entity->getGroupName();
        $gender = $gender_entity->getGender();
        
        $error = false;
        $message = 'Successfully retrieved';
        $result = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'fullname' => $firstname.' '.$lastname,
            'email' => $email,
            'roll_no' => $roll_no,
            'dob' => $dob,
            'gender' => $gender,
            'admission_date' => $admission_date,
            'parent' => $parent_name,
            'class_name' => $class_name,
            'section' => $section_name,
            'group_name' => $student_group_name,
            'group_id' => $student_group_entity->getId(),
            'error' => $error,
            'message' => $message,
            'id' => $student_id,
        ];
        return new JsonResponse($result);
    }
    
    /**
     * @Route("/getstudentid", name="get_id_for_edit", methods="POST")
     */
    public function getStudentId(Request $request)
    {
        $student_id = $request->request->get('id');

        $student = new StudentInfo;

        $student = $this->getDoctrine()->getRepository(StudentInfo::class)->find($student_id);

        $id = $student->getId();
        $firstname = $student->getFirstname();
        $lastname = $student->getLastname();
        $email = $student->getEmail();
        $roll_no = $student->getRollNo();
        $dob = $student->getDob();
        $admission_date = $student->getAdmissionDate();
        $gender_idd = $student->getGender();
        $parent = $student->getParent();
        $classes = $student->getClasses();
        $section = $student->getSection();
        $student_group = $student->getStudentGroup();

        $class_entity = $this->getDoctrine()->getRepository(Classes::class)->find($classes);
        $parent_entity = $this->getDoctrine()->getRepository(Parents::class)->find($parent);
        $section_entity = $this->getDoctrine()->getRepository(Section::class)->find($section);
        $group_entity = $this->getDoctrine()->getRepository(StudentGroup::class)->find($student_group);
        $gender_entity =  $this->getDoctrine()->getRepository(Gender::class)->find($gender_idd);

        $parent_name = $parent_entity->getFullname();
        $class_name = $class_entity->getClassName();
        $section_name = $section_entity->getSectionName();
        $group_name = $group_entity->getGroupName();
        $gender = $gender_entity->getGender();

        $parent_id = $parent_entity->getId();
        $class_id = $class_entity->getId();
        $section_id = $section_entity->getId();
        $group_id = $group_entity->getId();
        $gender_id = $gender_entity->getId();

        return new JsonResponse([
            'id' => $id, 
            'firstname' => $firstname,
            'lastname' => $lastname, 
            'email' => $email, 
            'dob' => $dob, 
            'admission_date' => $admission_date, 
            'gender' => $gender, 
            'roll_no' => $roll_no,
            'parent_name' => $parent_name, 
            'parent_id' => $parent_id, 
            'class_name' => $class_name, 
            'class_id' => $class_id,
            'section_name' => $section_name, 
            'section_id' => $section_id,
            'group_name' => $group_name,
            'group_id' => $group_id,
            'gender_id' => $gender_id
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
        // dump($dateDob);
        // exit;

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

        $message = "Well done! You successfully edited ".$firstname.' '.$lastname;
        return new JsonResponse(['error' => false, 'message' => $message]);
    }
    
    /**
     * @Route("/deletestudent", name="delete_student", methods="POST")
     */
    public function delete(Request $request, StudentInfoRepository $repo){
        
        $student_id = $request->request->get('id');
        // $student = $this->getDoctrine()->getRepository(StudentInfo::class)->find($student_id);
        $repo->removeStudent($student_id);
        // if (!$student) {
        //     return new JsonResponse(['error' => false, 'message' => 'Error']);
        // }
        
        // $em = $this->getDoctrine()->getManager();
        // $em->remove($student);
        // $em->flush();
        return new JsonResponse(['error' => true, 'message' => 'Deleted', ]);
    }


    //---------------------------- student group routes-----------------------------///

    /**
     * @Route("/new-student-group", name="new_student_group", methods="POST")
     */
    public function newStudentGroup(Request $request)
    {
        $group_name = $request->request->get('group_name');
        $dataserializer = new DataSerializer;

        if(empty($group_name)){
            $return = ['error' => true, 'message' => 'Please provide a group name'];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $student_group = new StudentGroup;
        $student_group->setGroupName($group_name);
        $em = $this->getDoctrine()->getManager();
        $em->persist($student_group);
        $em->flush();
        
        $return = ['error' => false, 'student_group' => $student_group];
        $groups = ['groups' => ['student_group:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/student-groups", name="all_group", methods="POST")
     */
    public function getGroups()
    {
        $student_groups = $this->getDoctrine()->getRepository(StudentGroup::class)->findAll();
        $dataserializer = new DataSerializer;

        if (!$student_groups) {            
            $return = ['error' => true, 'message' => 'No group found'];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $return = ['error' => false, 'student_groups' => $student_groups];
        $groups = ['groups' => ['student_group:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/edit-student-group", name="edit_student_group", methods="POST")
     */
    public function editStudentGroup(Request $request, StudentGroupRepository $repo)
    {   
        $id = $request->request->get('id');
        $group_name = $request->request->get('group_name');
        $dataserializer = new DataSerializer;

        if (!$group_name) {            
            $return = ['error' => true, 'message' => 'Please provide a group name'];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }

        $group = new StudentGroup();
        $group = $this->getDoctrine()->getRepository(StudentGroup::class)->find($id);        
        $group->setGroupName($group_name);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        $groups = $this->getDoctrine()->getRepository(StudentGroup::class)->findAll();

        $return = ['error' => false, 'student_groups' => $groups];
        $groups = ['groups' => ['student_group:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/delete-student-group", name="delete_student_group", methods="POST")
     */
    public function deleteStudentGroup(Request $request){
        
        $group_id = $request->request->get('id');
        $group = $this->getDoctrine()->getRepository(StudentGroup::class)->find($group_id);
        $dataserializer = new DataSerializer;

        if (!$group) {
            $return = ['error' => true, 'message' => "This student group does not exist"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;
        }
        // $repo->deleteClass($group_id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($group);
        $em->flush();

        $return = ['error' => false, 'stduent_group' => $group];
        $data = $dataserializer->serializeWithoutGroup($return);
        return new JsonResponse($data);
    }

    //----------------student group end----------------------//

    /**
     * @Route("/countstudents", name="student_count", methods="POST")
     */
    public function studentCount(StudentInfoRepository $studentRepo){
        $count = $studentRepo->studentCount();
        return new JsonResponse(['count' => $count]);
    }
    
    /**
     * @Route("/searchstudent", name="student_search", methods="POST")
     */
    public function searchStudent(StudentInfoRepository $studentRepo, Request $request)
    {
        $class_id = $request->request->get('class_id');
        $section_id = $request->request->get('section_id');
        $students = $this->getDoctrine()->getRepository(StudentInfo::class)->findBy(['section' => $section_id, "classes" => $class_id]);
        $dataserializer = new DataSerializer;

        if (!$students) {
            $return = ['error' => true, 'message' => "No student found"];
            $data = $dataserializer->serializeWithoutGroup($return);
            return new JsonResponse($data);
            exit;         
        }
        $classes = $this->getDoctrine()->getRepository(Classes::class)->find($class_id);
        $sections = $this->getDoctrine()->getRepository(Section::class)->find($section_id);
        $class_name = $classes->getClassName();
        $section_name = $sections->getSectionName();

        $return = ['error' => false, 'students' => $students, 'class_name' => $class_name, 'section_name' => $section_name];
        $groups = ['groups' => ['student:add']];
        $data = $dataserializer->serializeData($return, $groups);
        return new JsonResponse($data);
    }

    /**
     * @Route("/live-search", name="live_search")
     */
    public function liveSearch(Request $request)
    {
        $name = $request->request->get('name');
        $students = $this->getDoctrine()->getRepository(StudentInfo::class)->liveSearch($name);
        $dataserializer = new DataSerializer;
        if($name === ''){
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

    
    
}
