import { createRouter, createWebHistory } from 'vue-router' 
import Hola from '../components/Hola.vue'
import Como from '../components/Como.vue'
import Estas from '../components/Estas.vue'
import Quetal from '../components/Quetal.vue'
import Home from '../views/Home.vue'
import About from '../views/About.vue'

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
			path: '/',
			component: Home
		},
		{
			path: '/about',
			component: About
		},
    {
      path: '/hola',
      name: 'Hola',
      component: Hola
    },
    {
      path: '/como',
      name: 'Como',
      component: Como
    },
    {
      path: '/estas',
      name: 'Estas',
      component: Estas
    },
    {
      path: '/quetal',
      name: 'Quetal',
      component: Quetal
    }
  ]
})