<script>
import { useVuelidate } from '@vuelidate/core'
import { required, alphaNum, helpers  } from '@vuelidate/validators'
export default {
  data() {
    return {
      v$: useVuelidate(),
      credentials: {
        code: '',
        password: ''
      },
      typeText: {
        type: 'text',
        icon: 'visibility',
        title: 'Ocultar contraseña'
      },
      typePasswd: {
        type: 'password',
        icon: 'visibility_off',
        title: 'Mostrar contraseña'
      },
      showPass: false,
      type: 'password',
      icon: 'visibility_off',
      title: 'Mostrar contraseña',
      loading: false
    }
  },
  validations () {
    const alpha4 = helpers.regex(/^[ A-ZÑ0-9]/)
    return {
      credentials: {
        code: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha4: helpers.withMessage('Ingresa el código con un formato válido', alpha4) },
        password: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alphaNum: helpers.withMessage('Ingresa la contraseña con un formato válido', alphaNum) }
      },
    }
  },
  methods: {
    toggleVisibility() {
      switch (this.showPass) {
        case false:
          this.type = this.typeText.type
          this.icon = this.typeText.icon
          this.title = this.typeText.title
          this.showPass = true
          break;
        case true:
          this.type = this.typePasswd.type
          this.icon = this.typePasswd.icon
          this.title = this.typePasswd.title
          this.showPass = false
        default:
          break;
      }
    },
    async handleSubmit() {
      this.loading = true
      this.v$.$validate()
      if(!this.v$.$error) {
        try {
          const response = await this.axios.post('/api/login', this.credentials)
          this.statusActions(response.data.status, response.data)
  
        }
        catch (error) {
          this.$swal.fire(
              'Error',
              'Ocurrió un error, inténtalo de nuevo',
              'error'
            )
          console.log(error)
        }
      }
      this.loading = false
    },
    statusActions(status, data) {
      switch (status) {
        case "logged":
          this.axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.token
          let role = data.role
          if (role === "admin") {
            localStorage.setItem('auth', data.token)
            this.$router.push('/admin')
          }
          if (role === "secretaria") {
            localStorage.setItem('access', data.token)
            this.$router.push('/secretaria')
          }
          if (role === "docente") {
            localStorage.setItem('permission', data.token)
            this.$router.push('/docente')
          }
          if (role === "alumno") {
            localStorage.setItem('token', data.token)
            this.$router.push('/alumno')
          }
          break;
        case "notlogged":
          const Toast = this.$swal.mixin({
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', this.$swal.stopTimer)
              toast.addEventListener('mouseleave', this.$swal.resumeTimer)
            }
          })
          Toast.fire({
            icon: 'warning',
            title: data.message
          })
          break;
        default:
          Toast.fire({
            icon: 'error',
            title: 'Hubo un error, intentalo de nuevo'
          })
          break;
      }
    }
  },
  watch: {
    /**
     * 
     * @param {String} code 
     */
    'credentials.code'(code) {
      this.credentials.code = code.toUpperCase()
    }
  },
  setup() {
    document.title = 'IBBACH | Iniciar Sesión'
  }
}
</script>
<template>
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark mt-5 text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center card-login">
            <form @submit.prevent="handleSubmit" class="mb-md-2 mt-md-4 pb-5">
              <h2 class="fw-bold fs-2 mb-5 text-uppercase">Iniciar Sesión</h2>
              <div class="form-outline form-white mb-4">
                <input type="text" id="code" class="form-control form-control-lg" maxlength="15" placeholder="Código"
                  v-model="credentials.code"  />
                  <span class="text-danger" v-if="v$.credentials.code.$error">{{ v$.credentials.code.$errors[0].$message}}</span>
              </div>
              <div class="form-outline form-white mb-4 d-flex justify-content-end align-items-center">
                <input :type="type" id="passwd" class="form-control form-control-lg" maxlength="15" placeholder="Contraseña"
                  v-model="credentials.password"  />
                  <span class="text-black visibility-btn me-3" :title="title" @click="toggleVisibility"><i
                    class="material-icons d-flex align-items-center justify-content-center">{{ icon }}</i></span>
                  </div>
                  <div>
                    <span class="text-danger d-flex justify-content-center" v-if="v$.credentials.password.$error">{{ v$.credentials.password.$errors[0].$message}}</span>
                  </div>
              <button class="mt-3 btn btn-outline-light btn-lg px-5" type="submit" v-if="!loading">Ingresar</button>
              <span class="d-flex justify-content-center mt-3 px-5" v-else>
                <div class="mt-3 dot-pulse">
                  <div class="dot-pulse__dot"></div>
                </div>
              </span>
            </form>
          </div>
          <div class="d-flex justify-content-center text-center text-secondary">
            <p>Instituto Bíblico Betel Anexo Chalatenango • <router-link class="text-secondary" to="/">IBBACH
              </router-link>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.visibility-btn {
  cursor: pointer;
  user-select: none;
  position: absolute;
}

@media (max-width: 450px) {
  .card-login {
    padding: 2rem !important;
}
}

@media (max-width: 320px) {
  .card-login {
    padding: 2rem 1rem 2rem 1rem !important;
}
}

.dot-pulse {
  --uib-size: 40px;
  --uib-speed: 1.3s;
  --uib-color: #eee;

  position: relative;
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: var(--uib-size);
  height: calc(var(--uib-size) * 0.27);
}

.dot-pulse__dot,
.dot-pulse::before,
.dot-pulse::after {
  content: '';
  display: block;
  height: calc(var(--uib-size) * 0.18);
  width: calc(var(--uib-size) * 0.18);
  border-radius: 50%;
  background-color: var(--uib-color);
  transform: scale(0);
}

.dot-pulse::before {
  animation: pulse var(--uib-speed) ease-in-out infinite;
}

.dot-pulse__dot {
  animation: pulse var(--uib-speed) ease-in-out calc(var(--uib-speed) * 0.125) infinite both;
}

.dot-pulse::after {
  animation: pulse var(--uib-speed) ease-in-out calc(var(--uib-speed) * 0.25) infinite;
}

@keyframes pulse {

  0%,
  100% {
    transform: scale(0);
  }

  50% {
    transform: scale(1.5);
  }
}
</style>