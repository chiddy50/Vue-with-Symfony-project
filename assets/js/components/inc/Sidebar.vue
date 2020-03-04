<template>
    <div class="sidebar-main sidebar-menu-one sidebar-expand-md sidebar-color">
               <div class="mobile-sidebar-header d-md-none">
                    <div class="header-logo">
                        <a href="index.html"><img src="img/logo1.png" alt="logo"></a>
                    </div>
               </div>
                <div class="sidebar-menu-content">
                    <ul class="nav nav-sidebar-menu sidebar-toggle-view">
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-dashboard"></i><span>Dashboard</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <router-link class="nav-link" to="/" tag="a">
                                    <i class="fas fa-angle-right"></i>Admin</router-link>
                                </li>   
                                <li class="nav-item">
                                    <router-link class="nav-link" to="/term" tag="a">
                                    <i class="fas fa-angle-right"></i>Term</router-link>
                                </li>                                
                            </ul>
                        </li>
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-classmates"></i><span>Students</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <router-link to="/students" tag="a" class="nav-link">
                                    <i class="fas fa-angle-right"></i>All Students
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/studentgroup" tag="a" class="nav-link">
                                    <i class="fas fa-angle-right"></i>Student Group
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/newstudent" tag="a" class="nav-link">
                                    <i class="fas fa-angle-right"></i>Admission Form
                                    </router-link>
                                </li>
                                
                            </ul>
                        </li>
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i
                                    class="flaticon-multiple-users-silhouette"></i><span>Teachers</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <router-link to="/staff" tag="a" class="nav-link">
                                    <i class="fas fa-angle-right"></i>All Teachers
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <a href="teacher-details.html" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Teacher Details</a>
                                </li>
                                <li class="nav-item">
                                    <a href="add-teacher.html" class="nav-link"><i class="fas fa-angle-right"></i>Add
                                        Teacher</a>
                                </li>
                                <li class="nav-item">
                                    <a href="teacher-payment.html" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Payment</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-couple"></i><span>Parents</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <router-link to="/allparents" tag="a" class="nav-link">
                                        <i class="fas fa-angle-right"></i>All Parents
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <a href="parents-details.html" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Parents Details</a>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/parent" tag="a" class="nav-link"><i class="fas fa-angle-right"></i>Add
                                        Parent</router-link>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-checklist"></i><span>Attendence</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <router-link to="/school-attendance" tag="a" class="nav-link">
                                        <i class="fas fa-angle-right"></i>Take School Attendence
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/subject-attendance" tag="a" class="nav-link">
                                        <i class="fas fa-angle-right"></i>Take Subject Attendence
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/check-class-attendance" tag="a" class="nav-link"><i class="fas fa-angle-right"></i>Add
                                        Class Attendence</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/check-subject-attendance" tag="a" class="nav-link"><i class="fas fa-angle-right"></i>
                                    Subject Attendence</router-link>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i
                                    class="flaticon-maths-class-materials-cross-of-a-pencil-and-a-ruler"></i><span>Class</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <router-link to="/classes" tag="a" class="nav-link"><i class="fas fa-angle-right">
                                        </i>Classes
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/section" tag="a" class="nav-link">
                                    <i class="fas fa-angle-right"></i>
                                        Sections</router-link>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <router-link to="/subject" tag="a" class="nav-link">
                                <i class="flaticon-open-book"></i>
                                <span>Subject</span>
                            </router-link>
                        </li>
    
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-shopping-list"></i><span>Exam</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <router-link to="/exams" tag="a" class="nav-link"><i class="fas fa-angle-right"></i>Exam
                                        Schedule</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/exam-grades" tag="a" class="nav-link"><i class="fas fa-angle-right"></i>Exam
                                        Grades</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/mark-sheet" tag="a" class="nav-link"><i class="fas fa-angle-right"></i>Student Mark Sheet</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/class-mark-sheet" tag="a" class="nav-link"><i class="fas fa-angle-right"></i>Class Mark Sheet</router-link>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="nav-item">
                            <a href="class-routine.html" class="nav-link"><i class="flaticon-calendar"></i><span>Class
                                    Routine</span></a>
                        </li>                        
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-books"></i><span>Library</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <a href="all-book.html" class="nav-link"><i class="fas fa-angle-right"></i>All
                                        Book</a>
                                </li>
                                <li class="nav-item">
                                    <a href="add-book.html" class="nav-link"><i class="fas fa-angle-right"></i>Add New
                                        Book</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-technological"></i><span>Account</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <a href="all-fees.html" class="nav-link"><i class="fas fa-angle-right"></i>All Fees
                                        Collection</a>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/expenses" tag="a" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Expenses</router-link>
                                </li>
                                <li class="nav-item">
                                    <a href="add-expense.html" class="nav-link"><i class="fas fa-angle-right"></i>Add
                                        Expenses</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="transport.html" class="nav-link"><i
                                    class="flaticon-bus-side-view"></i><span>Transport</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="hostel.html" class="nav-link"><i class="flaticon-bed"></i><span>Hostel</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="notice-board.html" class="nav-link"><i
                                    class="flaticon-script"></i><span>Notice</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="messaging.html" class="nav-link"><i
                                    class="flaticon-chat"></i><span>Messeage</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="account-settings.html" class="nav-link">
                            <i class="flaticon-settings"></i><span>Account</span></a>
                        </li>
                    </ul>
                </div>
            </div>
</template>

<script>
export default {
    name: 'Sidebar'
}
</script>

<style scoped>

</style>