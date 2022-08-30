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

/**
 * Components for secretary view
 */
import Secretary from '../views/secretary/base/Secretary.vue'
import Payments from '../views/secretary/Payments.vue'
import Rates from '../views/secretary/Rates.vue'
import RegisterStudent from '../views/secretary/RegisterStudent.vue'

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

/**
 * Administrator's reports
 */
import TeachersReport from '../views/admin/reports/TeachersReport.vue'
import LoadsReport from '../views/admin/reports/LoadsReport.vue'
import SubjectsReport from '../views/admin/reports/SubjectsReport.vue'
import CyclesReport from '../views/admin/reports/CyclesReport.vue'
import ApplicantsReport from '../views/admin/reports/ApplicantsReport.vue'
import NotesReport from '../views/admin/reports/NotesReport.vue'
import AssistancesReport from '../views/admin/reports/AssistancesReport.vue'
import NoteStatusReport from '../views/admin/reports/NoteStatusReport.vue' 
import UsersGroupReport from '../views/admin/reports/UsersGroupReport.vue' 
import InscriptionsReport from '../views/admin/reports/InscriptionsReport.vue'
import UsersReport from '../views/admin/reports/UsersReport.vue'
import PaymentsPReport from '../views/admin/reports/PaymentsReport.vue'
import RatesReport from '../views/admin/reports/RatesReport.vue'
import StudentsPerYear from '../views/admin/reports/StudentsPerYearReport.vue'


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
      beforeEnter: async (to, from) => {
        if (!localStorage.getItem('auth')) {
          router.push('/login')
        }
      },
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
          path: 'reporte_aplicantes',
          name: 'ApplicantsReport',
          component: ApplicantsReport
        },
        {
          path: 'reporte_cargas',
          name: 'LoadsReport',
          component: LoadsReport
        },
        {
          path: 'reporte_docentes',
          name: 'TeachersReport',
          component: TeachersReport
        },
        {
          path: 'reporte_asignaturas',
          name: 'SubjectsReport',
          component: SubjectsReport
        },
        {
          path: 'reporte_ciclos',
          name: 'CyclesReport',
          component: CyclesReport
        },
        {
          path: 'reporte_notas',
          name: 'NotesReport',
          component: NotesReport
        },
        {
          path: 'reporte_asistencias',
          name: 'AssistancesReport',
          component: AssistancesReport
        },
        {
          path: 'reporte_estado',
          name: 'NoteStatusReport',
          component: NoteStatusReport
        },
        {
          path: 'reporte_Usuario_Grupo',
          name: 'UsersGroupReport',
          component: UsersGroupReport
        },
        {
          path: 'reporte_inscripciones',
          name: 'InscriptionsReport',
          component: InscriptionsReport
        },
        {
          path: 'reporte_usuarios',
          name: 'UsersReport',
          component: UsersReport
        },
        {
          path: 'reporte_pagos',
          name: 'PaymentsPReport',
          component: PaymentsPReport
        },
        {
          path: 'reporte_Cuotas',
          name: 'RatesReport',
          component: RatesReport
        },
        {
          path: 'reporte-estudiantes-por-a%C3%B1o',
          name:  'StudentsPerYearReport',
          component: StudentsPerYear
        }
      ]
    },
    {
      path: '/secretaria',
      component: Secretary,
      beforeEnter: async (to, from) => {
        if (!localStorage.getItem('access')) {
          router.push('/login')
        }
      },
      children: [
        {
          path: 'pagos',
          name: 'Payments',
          component: Payments
        },
        {
          path:'register',
          name: 'Register',
          component: Register
        },
        {
          path: 'cuotas',
          name: 'Rate',
          component: Rates
        },
        {
          path: 'registro-de-estudiantes',
          name: 'RegisterStudent',
          component: RegisterStudent
        }
      ]
    },
    {
      path: '/docente',
      component: Teacher,
      beforeEnter: async (to, from) => {
        if (!localStorage.getItem('permission')) {
          router.push('/login')
        }
      },
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
      beforeEnter: async (to, from) => {
        if (!localStorage.getItem('token')) {
          router.push('/login')
        }
      },
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