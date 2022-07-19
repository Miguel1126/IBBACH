import { createRouter, createWebHistory } from 'vue-router' 

/**
 * Components for home & not found
 */
import Home from '../views/Home.vue'
import NotFound from '../views/NotFound.vue'


/**
 * compnents for applicant view
 */
 import PersonalInformation from '../views/applicant/PersonalInformation.vue'
 import EcclesiasticalInformation from '../views/applicant/EcclesiasticalInformation.vue'
 import MinisterialInformation from '../views/applicant/MinisterialInformation.vue'
 import ApplicantForm from '../views/applicant/ApplicantForm.vue' 

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
import Rates from '../views/secretary/Rates.vue'

/**
 * Components for teacher view
 */
import Teacher from '../views/teacher/base/Teacher.vue'
import TestTeacher from '../views/teacher/TestTeacher.vue'
import Assistances from '../views/teacher/Assistances.vue'
import Notes from '../views/teacher/Notes.vue'

/**
 * Components for student view
 */
import Student from '../views/student/base/Student.vue'
import TestStudent from '../views/student/TestStudent.vue'
import Inscriptions from '../views/student/Inscriptions.vue'

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
          name: 'Cycles',
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
          path:'/register',
          name: 'Register',
          component: Register
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
        },
        {
          path: 'notas',
          name: 'Notes',
          component: Notes
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
        },
        {
          path: 'inscripciones',
          name: 'Inscription',
          component: Inscriptions
        },
        
      ]
      
    },
    {
      path: '/informacion-personal',
      name: 'PersonalInformation',
      component: PersonalInformation
    },
    {
      path: '/informacion-eclesiastica',
      name: 'EcclesiasticalInformation',
      component: EcclesiasticalInformation
    },
    {
      path: '/informacion-ministerial',
      name: 'MinisterialInformation',
      component: MinisterialInformation
    },
    {
      path: '/aplicante/formulario',
      name: 'ApplicantForm',
      component: ApplicantForm
    },
    { 
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: NotFound
    },
  ]
})