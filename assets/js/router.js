import VueRouter from 'vue-router';
import Vue from 'vue';

import Home from './components/Home.vue';
import AllStudents from './components/student/AllStudents.vue';
import SingleStudent from './components/student/SingleStudent.vue';

import CreateStudent from './components/student/CreateStudent.vue';
import EditStudent from './components/student/EditStudent.vue';
import StudentGroup from './components/student/StudentGroup.vue';
import StudentSubject from './components/student/StudentSubject.vue';

import AllParent from './components/parent/AllParent.vue';
import Parent from './components/parent/Parent.vue';
import EditParent from './components/parent/EditParent.vue';

import AllStaff from './components/staff/AllStaff.vue';
//Attendance routes
import StudentAttendance from './components/attendance/StudentAttendance.vue';
import SubjectAttendance from './components/attendance/SubjectAttendance.vue';

import Exam from './components/exams/Exam.vue';
import StudentMarkSheet from './components/exams/StudentMarkSheet.vue';
import SingleMarksheet from './components/exams/SingleMarksheet.vue';

import Grade from './components/academics/Grade.vue';
import Classes from './components/academics/Classes.vue';
import Sections from './components/academics/Sections.vue';

import Subject from './components/academics/Subject.vue';
import Term from './components/other/Term.vue';
import Expenses from './components/other/Expenses.vue';


import Login from './components/auth/Login.vue';

import NotFound from './components/NotFound.vue';


Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
   
    routes:[
        {
            path: '/',
            component: Home
        },
        {
            path: '/studentgroup',
            component: StudentGroup
        },
        {
            path: '/students',
            component: AllStudents,
            name: 'students'
        },
        {
            path: '/edit-student',
            component: EditStudent,
            name: 'EditStudent',
            props: true
        },
        {
            path: '/mark-sheet',
            component: StudentMarkSheet,
            name: 'StudentMarkSheet'
        },
        {
            path: '/student',
            component: SingleStudent,
            name: 'SingleStudent',
            props: true
        },
        {
            path: '/newstudent',
            component: CreateStudent
        },
        {
            path: '/term',
            component: Term
        },
        {
            path: '/expenses',
            component: Expenses
        },
        {
            path: '/classes',
            component: Classes,
            name: 'classes'
        }, 
        {
            path: '/single-marksheet',
            component: SingleMarksheet,
            name: 'SingleMarksheet',
            props: true
        }, 
        {
            path: '/section',
            component: Sections,
            name: 'sections'
        },
         
        {
            path: '/subjects/:id',
            component: StudentSubject,
            name: 'student_subject'
        },        
        
        {
            path: '/subject',
            component: Subject
        }, 
        {
            path: '/exams',
            component: Exam
        }, 
        {
            path: '/exam-grades',
            component: Grade
        },   
            
        {
            path: '/allparents',
            component: AllParent
        },
        {
            path: '/parent',
            component: Parent
        },
        {
            path: '/edit-parent',
            component: EditParent,
            name: 'EditParent',
            props: true
        },
        
        {
            path: '/staff',
            component: AllStaff
        },
        {
            path: '/class-attendance',
            component: StudentAttendance
        },
        {
            path: '/subject-attendance',
            component: SubjectAttendance
        },
        {
            path: '/login',
            component: Login
        },
        // {
        //     path: '/allparents',
        //     component: AllParent,
        //     meta: { requiresAuth: true }
        // },
        
        {
            path: '*',
            component: NotFound
        }

    ]
});

export default router;