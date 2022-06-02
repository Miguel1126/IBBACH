import { createRouter, createWebHistory } from 'vue-router' 
import Home from '../views/Home.vue'
import Loads from '../components/admin/Loads.vue'
import Groups from '../components/admin/Groups.vue'
import Subjects from '../components/admin/Subjects.vue'
import Cycles from '../components/admin/Cycles.vue'

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
			path: '/',
			component: Home
		},
		{
      path: '/cargas',
      name: 'Loads',
      component: Loads
    },
    {
      path: '/grupos',
      name: 'Groups',
      component: Groups
    },
    {
      path: '/materias',
      name: 'Subject',
      component: Subjects
    },
    {
      path: '/ciclos',
      name: 'Cycle',
      component: Cycles
    },
    { path: '/docentes',
      name: 'Teachers',
      component: Teachers
    }
  ]
})