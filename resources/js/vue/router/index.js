import { createRouter, createWebHistory } from 'vue-router' 

/**
 * Components for home & not found
 */
import Home from '../views/Home.vue'
import NotFound from '../views/NotFound.vue'

/**
 * Components for admin view
 */
import Admin from '../views/admin/base/Admin.vue'
import Loads from '../views/admin/Loads.vue'
import Groups from '../views/admin/Groups.vue'
import Subjects from '../views/admin/Subjects.vue'
import Cycles from '../views/admin/Cycles.vue'
import Teachers from '../views/admin/Teachers.vue'
import Schedules from '../views/admin/Schedules.vue'

/**
 * Components for secretary view
 */
import Secretary from '../views/secretary/base/Secretary.vue'
import TestSecretary from '../views/secretary/TestSecretary.vue'

/**
 * Components for teacher view
 */
import Teacher from '../views/teacher/base/Teacher.vue'
import TestTeacher from '../views/teacher/TestTeacher.vue'

/**
 * Components for student view
 */
import Student from '../views/student/base/Student.vue'
import TestStudent from '../views/student/TestStudent.vue'

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
			path: '/',
      name: 'Home',
			component: Home
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
          path: 'docentes',
          name: 'Teachers',
          component: Teachers
        },
        {
          path: 'horarios',
          name: 'Schedules',
          component: Schedules
        }
      ]
    },
    {
      path: '/secretaria',
      component: Secretary,
      children: [
        {
          path: '',
          name: 'Testsec',
          component: TestSecretary
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
        }
      ]
    },
    {
      path: '/estudiante',
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
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: NotFound
    },
  ]
})