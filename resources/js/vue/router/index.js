import { createRouter, createWebHistory } from 'vue-router' 
import Home from '../views/Home.vue'
import Loads from '../components/admin/Loads.vue'
import Groups from '../components/admin/Groups.vue'

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
    }
  ]
})