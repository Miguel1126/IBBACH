<script>
    export default{
        mounted(){
            this.getApplicant();
        },
        data(){
        return{
            name: '',
            last_name: '',
            code: '',
            password: '',
            password_confirmation: '',
            roles: [
                {id: 1, role: 'admin'},
                {id: 2, role: 'secretaria'},
                {id: 3, role: 'docente'},
                {id: 1, role: 'alumno'}
            ],
            roleSelected: [],
            applicants:[],
            applicantSelected:[]
        }
    },
        methods: {
           async handleSubmit(){
           const response = await this.axios.post('/api/register', {
                name: this.name,
                last_name: this.last_name,
                code: this.code,
                password: this.password,
                password_confirmation: this.password_confirmation,
                role: this.roleSelected[0],
                applicant_id: this.applicantSelected[0].id 
            });
            console.log(response);
            console.log(this.applicantSelected[0].id)
            if (response.status === 200) {
                this.$swal.fire(
                        'Listo',
                        'Se registró el usuario',
                        'success'
                    )
                }
            },
            async getApplicant() {
            try {
                const response = await this.axios.get('/api/getAplicante')
                if (response.status === 200) {
                    if (typeof(response.data) === 'object') {
                        this.applicants = response.data
                        console.log(response)
                    }
                    else {
                        this.applicants[0] = 'error'
                        console.log(response)
                    }
                }
            }
            catch {
                (error) => console.error(error) 
            }
        },
        selectRole(event, roles) {
            this.roleSelected = [];
            this.roleSelected.push(roles);
        },
        selectApplicant(event, applicants) {
            this.applicantSelected = [];
            this.applicantSelected.push(applicants);
        }
        }
    }
</script>

<template>
    <form @submit.prevent="handleSubmit" class="form">
        <h3>Registrar usuario</h3>
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control" v-model="name" placeholder="Nombre"/>
        </div>
        <div class="form-group">
            <label>Apellido</label>
            <input type="text" class="form-control" v-model="last_name" placeholder="Apellido"/>
        </div>
        <div class="form-group">
            <label>Código</label>
            <input type="text" class="form-control" v-model="code" placeholder="codigo"/>
        </div>
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" class="form-control" v-model="password" placeholder="Contraseña"/>
        </div>
        <div class="form-group">
            <label>Confirmar contraseña</label>
            <input type="password" class="form-control" v-model="password_confirmation" placeholder="Confirmar contraseña"/>
        </div>
        <div class="dropdown m-4">
            <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span v-if="!roleSelected.length">Tipo de usuario</span>
                <span v-else>{{ roleSelected[0] }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                <li v-for="role in roles" :key="role.id" class="dropdown-item text-light list-click" @click="selectRole($event, role.role)">{{ role.role }}</li>
            </ul>
        </div>
        <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!applicantSelected.length">Applicante</span>
                        <span v-else>{{ applicantSelected[0].registration_date || applicants.name || applicants.last_name }} - {{ applicantSelected[0].registration_date || applicants.name ||
                                applicants.last_name
                        }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="applicant in applicants" :key="applicant.id" class="dropdown-item text-light list-click"
                            @click="selectApplicant($event, applicant)">{{ applicant.registration_date }} - {{ applicant.name }} - {{ applicant.last_name }}
                        </li>
                    </ul>
                </div>
        <button class="btn btn-primary btn-block">Registrar</button>
    </form>
</template>

<style scoped> 
    .form {
        width: 20rem;
        margin-left: 5rem;
    }
</style>