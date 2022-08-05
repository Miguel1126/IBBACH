<script>
import DataTable from '../../components/DataTable.vue';
    export default {
    mounted() {
        this.getGroups();
    },
    data() {
        return {
            groups: [],
            group: null,
            editing: false,
            headers: [
                {title: 'Id'},
                {title: 'Grupo'},
                {title: 'Acciones'}
            ]
        };
    },
    methods: {
        async handleSumit() {
            if (this.validateInput()) {
                const response = await this.axios.post("/api/grupos", {
                    group: this.group,
                });
                console.log(response);
                if (response.status === 201) {
                    this.clearInput();
                    this.getGroups();
                    this.$swal.fire("Listo", "Se registró la materia", "success");
                }
            }
            else {
                const Toast = this.$swal.mixin({
                    toast: true,
                    position: "top",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", this.$swal.stopTimer);
                        toast.addEventListener("mouseleave", this.$swal.resumeTimer);
                    }
                });
                Toast.fire({
                    icon: "error",
                    title: "Debes rellenar el campo"
                });
            }
        },
        getGroups() {
            this.axios.get("/api/grupos/show")
                .then(response => {
                this.groups = response.data;
            })
                .catch(error => {
                console.error(error);
            });
        },
        clearInput() {
            this.group = null;
            this.editing = false;
        },
        validateInput() {
            let valid = this.group ? true : false;
            return valid;
        },
        selectGroup(event, group) {
            const app = this;
            app.editing = true;
            app.group = group;
        },
        saveEdit() {
            this.editing = false;
            this.clearInput();
            this.$swal.fire("Listo", "Se editó el grupo", "success");
        },
        deleteGroup(id) {
            this.groups = this.groups.filter(group => group.id != id);
            this.groups = [...this.groups];
        },
        confirmDelete(event, id) {
            this.$swal.fire({
                title: "¿Estas seguro de querer borrar este grupo?",
                text: "Si lo borras, no podrás recuperarlo",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Borrar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteGroup(id);
                    this.$swal.fire("Listo", "El grupo ha sido eliminado", "success");
                }
            });
        }
    },
    setup() {
        document.title = "IBBACH | Grupos";
    },
    components: { DataTable }
}
</script>

<template>
    <main>
        <h1 class="h1 fs-1 fw-bold">Administrador de Grupos</h1>
        <br />
        <section class=" p-3 ">
            <form @submit.prevent="handleSumit">
            <h3 class="h3 fw-semibold">Crea un nuevo grupo</h3>
            <div class="d-flex">
                <div class="input-group input-group-lg w-25">
                    <span class="input-group-text" id="inputGroup-sizing-lg"><i class="material-icons">workspaces</i></span>
                    <input type="text" class="form-control" v-model="group" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="e.j Diurno">
                </div>
                <button v-if="!editing" type="button" class="d-inline-flex btn btn-primary btn-lg ms-4" @click="handleSumit">Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                <button v-else type="button" class="d-inline-flex btn btn-success btn-lg ms-4" @click="postGroups">Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                <button v-if="editing" type="button" class="d-inline-flex btn btn-danger btn-lg ms-3" @click="clearInput">Cancelar <i class="material-icons m-auto ms-1">cancel</i></button>
            </div>
            </form>
        </section>
        <hr class="separator"/>
        <section class="p-3">
            <DataTable
            title="Listado de grupos"
            :headers="headers"
            :items="groups"
            >
                <template #actions>
                    <button type="button" class="btn btn-primary me-2">Modificar</button>
                    <button type="button" class="btn btn-danger">Eliminar</button>
                </template>
            </DataTable>
        </section>
    </main>    
</template>

<style scoped>
    .load {
        border-radius: 15px !important;
    }
</style>