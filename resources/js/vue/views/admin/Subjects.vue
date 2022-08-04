<script>
    export default {
         mounted() {
            this.getSubjects()
        },
        data() {
            return {
                subjects: [],
                subject: null,
                descriptions:[],
                description: null,
                statuses: [
                {id: 1, status: 'disponible'},
                {id: 2, status: 'ocupado'}
               ],
               statusSelected:[],
                editing: false
            }
        },
        methods: {
            async handleSumit(){
                const response = await this.axios.post('/api/asignaturas', {
                subject: this.subject,
                subject: this.subject,
                description: this.description,
                status: this.statusSelected[0],
                });
                if (this.validateInput()) {
                    this.clearInput()
                }
                else {
                    const Toast = this.$swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', this.$swal.stopTimer)
                            toast.addEventListener('mouseleave', this.$swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'error',
                        title: 'Debes rellenar el campo'
                    })
                }
                console.log(response);
                if (response.status === 201) {
                    this.clearInput()
                    this.getSubjects() 
                    this.$swal.fire(
                        'Listo',
                        'Se registró la materia',
                        'success'
                    )
                }
            },
            getSubjects(){
                this.axios.get('/api/asignaturas/show')
                .then(response => {
                    this.subjects = response.data
                })
                .catch(error => {
                    console.error(error)
                })
            },
            clearInput() {
                this.subject = null
                this.description = null
                this.status = null
                this.editing = false
            },
            validateInput() {
                let valid = this.subject && this.description && this.status  ? true : false
                return valid
            },
            selectStatus(event, statuses) {
                this.statusSelected = [];
                this.statusSelected.push(statuses);
            },
            selectGroup(event, subject, description) {
                const app = this
                app.editing = true
                app.subject = subject
                app.description = description
                
            },
            saveEdit() {
                this.editing = false
                this.clearInput()
                this.$swal.fire(
                        'Listo',
                        'Se editó la materia',
                        'success'
                    )
            },
            deleteSubject(id){
                this.subjects = this.subjects.filter(subject => subject.id != id)
                this.subjects = [... this.subjects]

            },
            deleteDescription(id){
                this.descriptions = this.descriptions.filter(description => description.id != id)
                this.descriptions = [... this.descriptions]

            },
            confirmDelete(event, id) {
                this.$swal.fire({
                    title: '¿Estas seguro de querer borrar esta materia?',
                    text: "Si lo borras, no podrás recuperarlo",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Borrar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteSubject(id)
                    this.deleteDescription(id)
                    this.$swal.fire(
                        'Listo',
                        'La materia ha sido eliminada',
                        'success'
                    )
                }
                })
            }
        },
        setup() {
            document.title = "IBBACH | Materias"
        }
    }
</script>

<template>
    <main>
        <h1 class="h1 fs-1 fw-bold">Administrador de Asignaturas</h1>
        <br />
        <section class=" p-3 ">
            <form @submit.prevent="handleSumit">
            <h3 class="h3 fw-semibold">Crea una nueva Asignatura</h3>
            <div>
                <div class="input-group input-group-lg w-50 mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-lg"><i class="material-icons">collections_bookmark</i></span>
                    <input type="text" class="form-control" v-model="subject" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="e.j Introducción al griego">
                </div>
                 <div class="input-group input-group-lg w-50 mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-lg"><i class="material-icons">collections_bookmark</i></span>
                    <input type="text" class="form-control" v-model="description" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="Introduce descripcion">
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!statusSelected.length">Estado</span>
                        <span v-else>{{ statusSelected[0] }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="status in statuses" :key="status.id" class="dropdown-item text-light list-click" @click="selectStatus($event, status.status)">{{ status.status }}</li>
                    </ul>
                    </div>
                <button v-if="!editing" type="submit" class="d-inline-flex btn btn-primary btn-lg ms-4">Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                <button v-else type="button" class="d-inline-flex btn btn-success btn-lg ms-4" @click="saveEdit">Guardar <i class="material-icons m-auto ms-1">edit</i></button>
                <button v-if="editing" type="button" class="d-inline-flex btn btn-danger btn-lg ms-3" @click="clearInput">Cancelar <i class="material-icons m-auto ms-1">cancel</i></button>
            </div>
            </form>
        </section>
        <hr class="separator"/>
        <section class="p-3">
            <div class="table-container p-3 mb-5 table-color rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Listado de asignaturas</h3>
                <table class="table table-bordered border-dark">
                    <thead class="table-info table-bordered border-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Asignaturas</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Estado</th>
                            <th scope="col" class="w-25">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="subject in subjects" :key="subject.id">
                            <th scope="row">{{ subject.id }}</th>
                            <td>{{ subject.subject }}</td>
                            <td>{{ subject.description }}</td>
                            <td>{{ subject.status }}</td>
                            <td class="d-flex justify-content-center">
                                <button type="button" class="btn btn-primary me-2" @click="selectGroup($event, subject.subject, subject.description)">Modificar</button>
                                <button type="button" class="btn btn-danger" @click="confirmDelete($event, subject.id)">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>    
</template>

<style scoped>
    .load {
        border-radius: 15px !important;
    }
</style>