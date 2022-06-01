import { createRouter, createWebHistory } from 'vue-router' 
import Home from '../views/Home.vue'
import Loads from '../components/admin/Loads.vue'

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
    }
  ]
})