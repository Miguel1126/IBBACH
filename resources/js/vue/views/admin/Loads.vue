<script>
    export default {
        data() {
            return {
                cycles: [
                    { id: 1, cycle: '01/2022' },
                    { id: 2, cycle: '02/2022' },
                    { id: 3, cycle: '01/2023' },
                    { id: 4, cycle: '02/2023' }
                ],
                subjects: [
                    { id: 1, subject: 'Introducción al Griego' },
                    { id: 2, subject: 'Amar al projimo' },
                    { id: 3, subject: 'Maneras de rezar' }
                ],
                teachers: [
                    { id: 1, name: 'Juan Perez' },
                    { id: 2, name: 'Jose Ramos' },
                    { id: 3, name: 'Juan Chavez' }
                ],
                loads: [
                    { id: 1, cycle: '01/2022', subject: 'Introducción al griego', teacher: 'Juan Perez' },
                    { id: 2, cycle: '02/2022', subject: 'Amar al projimo', teacher: 'Juan Chavez' },
                    { id: 3, cycle: '01/2023', subject: 'Maneras de rezar', teacher: 'Jose Ramos' }
                ],
                cySelected: [],
                subSelected: [],
                teaSelected: [],
                editing: false
            }
        },
        methods: {
            selectCy(event, cycle) {
                this.cySelected = []
                this.cySelected.push(cycle)
            },
            selectSub(event, subject) {
                this.subSelected = []
                this.subSelected.push(subject)
            },
            selectTea(event, teacher) {
                this.teaSelected = []
                this.teaSelected.push(teacher)
            },
            clearDropdown() {
                const app = this
                app.cySelected = []
                app.subSelected = []
                app.teaSelected = []
                app.editing = false
            },
            validateDropdowns() {
                const app = this;
                const valid = app.cySelected.length && app.subSelected.length && app.teaSelected.length ? true : false
                return valid
            },
            updateTable() {
                const app = this
                if (app.validateDropdowns()) {
                    app.loads.push({ id: app.loads.length + 1, cycle: app.cySelected[0], subject: app.subSelected[0], teacher: app.teaSelected[0] })
                    app.clearDropdown()
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
                        title: 'Debes rellenar todos los campos'
                    })
                }
            },
            selectLoad(event, cycle, subject, teacher) {
                const app = this
                app.editing = true
                app.cySelected.push(cycle)
                app.subSelected.push(subject)
                app.teaSelected.push(teacher)
            },
            saveEdit() {
                this.editing = false
                this.clearDropdown()
                this.$swal.fire(
                        'Listo',
                        'Se editó la carga',
                        'success'
                    )
            },
            deleteLoad(id){
                this.loads = this.loads.filter(load => load.id != id);
                this.loads = [... this.loads];
            },
            confirmDelete(event, id) {
                this.$swal.fire({
                    title: '¿Estas seguro de querer borrar esta carga?',
                    text: "Si la borras, no podrás recuperarla",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Borrar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteLoad(id)
                    this.$swal.fire(
                        'Listo',
                        'La carga ha sido eliminada',
                        'success'
                    )
                }
                })
            }
        },
        setup() {
            document.title = "IBBACH | Cargas"
        }
    }
</script>

<template>
    <main>
        <h1 class="h1 fs-1 fw-bold">Administrador de carga académica</h1>
        <br />
        <section class="p-3">
            <h3 class="h3 fw-semibold">Asignar una nueva carga</h3>
            <div class="d-flex">
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!cySelected.length">Ciclo</span>
                        <span v-else>{{ cySelected[0] }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="cycle in cycles" :key="cycle.id" class="dropdown-item text-light list-click" @click="selectCy($event, cycle.cycle)">{{ cycle.cycle }}</li>
                    </ul>
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!subSelected.length">Materia</span>
                        <span v-else>{{ subSelected[0] }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="subject in subjects" :key="subject.id" class="dropdown-item text-light list-click" @click="selectSub($event, subject.subject)">{{ subject.subject }}</li>
                    </ul>
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!teaSelected.length">Docente</span>
                        <span v-else>{{ teaSelected[0] }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="teacher in teachers" :key="teacher.id" class="dropdown-item text-light list-click" @click="selectTea($event, teacher.name)">{{ teacher.name }}</li>    
                    </ul>
                </div> 
                <div class="m-4">
                    <button v-if="!editing" type="button" class="d-inline-flex btn btn-primary btn-lg" @click="updateTable">Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                    <button v-else type="button" class="d-inline-flex btn btn-success btn-lg" @click="saveEdit">Guardar <i class="material-icons m-auto ms-1">edit</i></button>
                    <button v-if="!editing" type="button" class="d-inline-flex btn btn-warning btn-lg ms-3" @click="clearDropdown">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
                    <button v-else type="button" class="d-inline-flex btn btn-danger btn-lg ms-3" @click="clearDropdown">Cancelar <i class="material-icons m-auto ms-1">cancel</i></button>
                </div>
            </div>
        </section>
        <hr class="separator"/>
        <section class="p-3">
            <div class="table-container p-3 mb-5 bg-body rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Listado de cargas</h3>
                <table class="table table-bordered border-dark bg-light">
                    <thead class="table-success table-bordered border-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ciclo</th>
                            <th scope="col">Materia</th>
                            <th scope="col">Docente</th>
                            <th scope="col" class="w-25">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="load in loads" :key="load.id">
                            <th scope="row">{{ load.id }}</th>
                            <td>{{ load.cycle }}</td>
                            <td>{{ load.subject }}</td>
                            <td>{{ load.teacher }}</td>
                            <td class="d-flex justify-content-center">
                                <button type="button" class="btn btn-primary me-2" @click="selectLoad($event, load.cycle, load.subject, load.teacher)">Modificar</button>
                                <button type="button" class="btn btn-danger" @click="confirmDelete($event, load.id)">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>    
</template>

<style scoped>
    .list-click {
        cursor: pointer;
    }
</style>