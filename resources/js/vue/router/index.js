import { createRouter, createWebHistory } from 'vue-router' 

/**
 * Components for home & not found
 */
import Home from '../views/Home.vue'
import NotFound from '../views/NotFound.vue'
import Applicant from '../views/Applicant.vue'

/**
 * Components for admin view
 */
import Admin from '../views/admin/base/Admin.vue'
import Loads from '../views/admin/Loads.vue'
import Groups from '../views/admin/Groups.vue'
import Subjects from '../views/admin/Subjects.vue'
import Cycles from '../views/admin/Cycles.vue'
import Schedules from '../views/admin/Schedules.vue'
import LoadsReport from '../views/admin/reports/LoadsReport.vue'

/**
 * Components for secretary view
 */
import Secretary from '../views/secretary/base/Secretary.vue'
import Payments from '../views/secretary/Payments.vue'
import Users from '../views/secretary/Users.vue'
import Rates from '../views/secretary/Rates.vue'

/**
 * Components for teacher view
 */
import Teacher from '../views/teacher/base/Teacher.vue'
import TestTeacher from '../views/teacher/TestTeacher.vue'
import Assistances from '../views/teacher/Assistances.vue'

/**
 * Components for student view
 */
import Student from '../views/student/base/Student.vue'
import TestStudent from '../views/student/TestStudent.vue'

/**
 * Components for login
 */
import Login from '../components/Login.vue'
 import Register from '../views/secretary/Register.vue'


export const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
			path: '/',
      name: 'Home',
			component: Home
		},
    {
      path:'/login',
      name: 'Login',
      component: Login
    },
    {
      path:'/register',
      name: 'Register',
      component: Register
    },
    {
      path: '/admin',
      component: Admin,
      children: [
        {
          path: 'cargas',
          name: 'Loads',
          component: Loads
        },
        {
          path: 'grupos',
          name: 'Groups',
          component: Groups
        },
        {
          path: 'materias',
          name: 'Subject',
          component: Subjects
        },
        {
          path: 'ciclos',
          name: 'Cycle',
          component: Cycles
        },
        {
          path: 'horarios',
          name: 'Schedules',
          component: Schedules
        },
        {
          path: 'reporte-cargas',
          name: 'LoadsReport',
          component: LoadsReport
        }
      ]
    },
    {
      path: '/secretaria',
      component: Secretary,
      children: [
        {
          path: 'pagos',
          name: 'Payments',
          component: Payments
        },
        {
          path: 'Usuarios',
          name: 'Users',
          component: Users
        },
        {
          path: 'cuotas',
          name: 'Rate',
          component: Rates
        }
      ]
    },
    {
      path: '/docente',
      component: Teacher,
      children: [
        {
          path: '',
          name: 'Testtea',
          component: TestTeacher
        },
        { 
          path: 'asistencias',
          name: 'Assistances',
          component: Assistances
        }
      ]
    },
    {
      path: '/alumno',
      component: Student,
      children: [
        {
          path: '',
          name: 'Testest',
          component: TestStudent
        }
      ]
    },
    {
      path: '/solicitud-de-ingreso',
      name: 'Applicant',
      component: Applicant
    },
    { 
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: NotFound
    },
  ]
})