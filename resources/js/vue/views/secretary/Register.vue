<script>
import { useVuelidate } from '@vuelidate/core'
import { required, minLength, helpers, requiredIf, alphaNum } from '@vuelidate/validators'
import UserInfoCard from '../../components/UserInfoCard.vue';
import { handleErrors } from '../../js/handle_error';
export default {
    mounted() {
        document.title = "IBBACH | Registrar usuario";
    },
    data() {
        return {
            success: false,
            loading: false,
            v$: useVuelidate(),
            user: {},
            name: "",
            last_name: "",
            password: "",
            confirmPassword: "",
            personalizedPass: true,
            roles: [
                { id: 1, name: "Admin" },
                { id: 2, name: "Secretaria" },
                { id: 3, name: "Docente" },
            ],
            roleSelected: "",
        };
    },
    validations() {
        const alpha = helpers.regex(/^[ a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/)
        return {
            name: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras', alpha) },
            last_name: { required: helpers.withMessage('Llenar este campo es obligatorio', required), alpha: helpers.withMessage('Este campo solo admite letras', alpha) },
            roleSelected: { required: helpers.withMessage('Llenar este campo es obligatorio', required) },
            password : {requiredIf:  helpers.withMessage('Llenar este campo es obligatorio', requiredIf(!this.personalizedPass)), minLength: helpers.withMessage('Ingresa la contraseña con un formato válido', minLength(6)), alphaNum:helpers.withMessage('Ingresa la contraseña con un formato válido', alphaNum )},
            confirmPassword: {requiredIf:  helpers.withMessage('Llenar este campo es obligatorio', requiredIf(!this.personalizedPass))}
        }
    },
    methods: {
        clearInputs() {
            this.name = ''
            this.last_name = ''
            this.roleSelected = ''
            this.password = ''
            this.confirmPassword = ''
        }
        ,
        async handleSubmit() {
            this.loading = true
            this.v$.$validate()
            if (!this.v$.$error) {
                try {
                    let payload = {}

                    if (!this.personalizedPass) {
                        payload = {
                            personalized_pass: this.personalizedPass,
                            name: this.name,
                            last_name: this.last_name,
                            password: this.password,
                            password_confirmation: this.confirmPassword,
                            role: this.roleSelected
                        }
                    }
                    else {
                        payload = {
                            personalized_pass: this.personalizedPass,
                            name: this.name,
                            last_name: this.last_name,
                            role: this.roleSelected
                        }
                    }

                    const response = await this.axios.post("/api/register", payload);
                    if (response.status === 201) {
                        this.user = { ...response.data },
                            this.success = true
                        this.clearInputs()
                    }
                    else {
                        this.$swal.fire("Error", "Ocurrió un error, intentalo de nuevo", "error");
                    }
                }
                catch (error) {
                    console.log(error)
                    handleErrors(error)
                    this.$swal.fire("Error", "Ocurrió un error, intentalo de nuevo", "error");
                }
            }
            this.loading = false
        }
    },
    components: { UserInfoCard }
};
</script>

<template>
    <section class="p-3">
        <form @submit.prevent="handleSubmit" class="form">
            <h3>Registrar usuario</h3>
            <div class="row">
                <div class="col col-lg-3">
                    <label class="form-label mt-1">Nombres</label>
                    <input type="text" class="form-control inputs" v-model="name" placeholder="Nombres"/>
                    <span class="text-danger" v-if="v$.name.$error">{{ v$.name.$errors[0].$message}}</span>
                </div>
                <div class="col col-lg-3">
                    <label class="form-label mt-1">Apellidos</label>
                    <input type="text" class="form-control inputs" v-model="last_name" placeholder="Apellidos"/>
                    <span class="text-danger" v-if="v$.last_name.$error">{{ v$.last_name.$errors[0].$message}}</span>

                </div>
            </div>
            <div class="row">
                <div class="col col-lg-3">
                    <label class="form-label mt-1" for="roles">Tipo de usuario</label>
                    <select class="form-select inputs" id="roles" v-model="roleSelected">
                        <option v-for="role in roles" :key="role.id" :value="role.name.toLowerCase()">{{ role.name }}
                        </option>
                    </select>
                    <span class="text-danger" v-if="v$.roleSelected.$error">{{
                    v$.roleSelected.$errors[0].$message}}</span>
                </div>
                <div class="col col-lg-3">
                    <div class="form-check form-switch d-flex align-items-center">
                        <input v-model="personalizedPass" class="form-check-input switch" type="checkbox" role="switch"
                            id="flexSwitchCheckChecked">
                        <label class="form-check-label ms-3" for="flexSwitchCheckChecked">Contraseña
                            autogenerada</label>
                    </div>
                </div>
            </div>
            <div class="row" v-if="!personalizedPass">
                <div class="col col-lg-3">
                    <label class="form-label mt-1">Contraseña</label>
                    <input type="password" class="form-control inputs" v-model="password" />
                    <span class="text-danger" v-if="v$.password.$error">{{ v$.password.$errors[0].$message}}</span>
                </div>
                <div class="col col-lg-3">
                    <label class="form-label mt-1">Confirmar contraseña</label>
                    <input type="password" class="form-control inputs mb-3" v-model="confirmPassword"/>
                    <span class="text-danger" v-if="v$.confirmPassword.$error">{{ v$.confirmPassword.$errors[0].$message}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col col-lg-3">
                    <div v-if="!loading">
                        <label class="form-label mt-4"></label>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                    <span class="ms-1 mb-4 px-5" v-else>
                        <div class="mt-3 dot-pulse">
                            <div class="dot-pulse__dot"></div>
                        </div>
                    </span>
                </div>
            </div>
        </form>
    </section>
    <div>
        <UserInfoCard :userinfo="user" v-if="success"></UserInfoCard>
    </div>
</template>

<style scoped>
.inputs {
    max-width: 300px;
    min-width: 200px;
}

.form-check {
    margin-top: 2.3rem;
}

.switch {
    min-width: 40px;
    height: 20px;
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

@media (max-width: 667px) {
    .form-check {
        margin-bottom: 1.6rem;
    }
}
</style>