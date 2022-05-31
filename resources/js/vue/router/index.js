import { createRouter, createWebHistory } from 'vue-router' 
import Hola from '../components/Hola.vue'
import Como from '../components/Como.vue'
import Estas from '../components/Estas.vue'

export const router = createRouter({
  history: createWebHistory(),
  routes: [
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
    }
  ]
})