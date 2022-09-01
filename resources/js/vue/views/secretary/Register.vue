<script>
export default {
    mounted() {
        document.title = 'IBBACH | Registrar usuario'
    },
    data() {
        return {
            name: "",
            last_name: "",
            code: "",
            password: "",
            password_confirmation: "",
            roles: [
                { id: 1, name: "Admin" },
                { id: 2, name: "Secretaria" },
                { id: 3, name: "Docente" },
            ],
            roleSelected: '',
        };
    },
    methods: {
        async handleSubmit() {
            const response = await this.axios.post("/api/register", {
                name: this.name,
                last_name: this.last_name,
                code: this.code,
                password: this.password,
                password_confirmation: this.password_confirmation,
                role: this.roleSelected
            });
            if (response.status === 200) {
                this.$swal.fire("Listo", "Se registró el usuario", "success");
            }
            else {
                this.$swal.fire("Error", "Ocurrió un error, intentalo de nuevo", "error");
                
            }
        },
    },
};
</script>

<template>
    <form @submit.prevent="handleSubmit" class="form">
        <h3>Registrar usuario</h3>
        <div class="row">
            <div class="col-6 col-lg-3">
                <label class="form-label mt-1">Nombres</label>
                <input type="text" class="form-control" v-model="name" placeholder="Nombre" />
            </div>
            <div class="col col-lg-3">
                <label class="form-label mt-1">Apellidos</label>
                <input type="text" class="form-control" v-model="last_name" placeholder="Apellido" />
            </div>
        </div>
        <div class="row">
            <div class="col col-lg-3">
                <label class="form-label mt-1">Código</label>
                <input type="text" class="form-control" v-model="code" placeholder="codigo" />
            </div>
            <div class="col col-lg-3">
                <label class="form-label mt-1">Contraseña</label>
                <input type="password" class="form-control" v-model="password" placeholder="Contraseña" />
            </div>
        </div>
        <div class="row">
            <div class="col col-lg-3">
                <label class="form-label mt-1">Confirmar contraseña</label>
                <input type="password" class="form-control" v-model="password_confirmation"
                    placeholder="Confirmar contraseña" />
            </div>
            <div class="col col-lg-3">
                <label class="form-label mt-1" for="roles">Tipo de usuario</label>
                <select class="form-select" id="roles" v-model="roleSelected">
                    <option v-for="role in roles" :key="role.id" :value="role.name.toLowerCase()">{{ role.name }}</option>
                </select>
            </div>
        </div>
        <button class="btn btn-primary btn-block mt-3">Registrar</button>
    </form>
</template>

<style scoped>
</style>