<script>
    export default {
        data() {
            return {
                schedules: [
                    { id: 1, time: '08:00 AM - 10:00 AM', description: 'Test', uv: '10', teacher: 'Juan Perez' }
                ],
                startTime: null,
                endTime: null,
                uv: null,
                teachers: [
                    { id: 1, name: 'Juan Perez' },
                    { id: 2, name: 'Jose Ramos' },
                    { id: 3, name: 'manolo perez' }
                ],
                subjects: [
                    { id: 1, subject: 'Amor' },
                    { id: 2, subject: 'Respeto' },
                    { id: 3, subject: 'Cariño' }
                ],
                subSelected: [],
                teaSelected: [],
                editing: false
            }
        },
        methods: {
            selectTea(event, teacher) {
                this.teaSelected = []
                this.teaSelected.push(teacher)
            },
            selectSub(event, subject) {
                this.subSelected = []
                this.subSelected.push(subject)
            },
            clearDropdown() {
                const app = this
                app.teaSelected = []
                app.editing = false
            },
            validateDropdowns() {
                const app = this;
                const valid = app.teaSelected.length ? true : false
                return valid
            },
            updateTable() {
                const app = this
                if (app.validateDropdowns()) {
                    app.loads.push({ id: app.loads.length + 1, teacher: app.teaSelected[0] })
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
                        title: 'Debes rellenar el campo'
                    })
                }
            },
            selectLoad(event, cycle, subject, teacher) {
                const app = this
                app.editing = true
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
        }
    }
</script>
<template>
    <main>
        <h1 class="h1 fs-1 fw-bold">SABATINO NIVEL BASICO I</h1>
        <br />
        <section class=" p-3 ">
            <h3 class="h3 fw-semibold">Asignar un maestro</h3>
            <div class="d-flex">
                    <div class="input-group-lg w-25">
                        <span class="input-group-text" id="inputGroup-sizing-lg">Hora inicio</span>
                        <input type="text" class="form-control" v-model="startTime" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="08:00 AM">
                    </div>
                    <div class="input-group-lg w-25">
                        <span class="input-group-text" id="inputGroup-sizing-lg">Hora fin</span>
                        <input type="text" class="form-control" v-model="endTime" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="08:00 AM">
                    </div>
                    <div class="dropdown m-4">
                        <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                            <span v-if="!subSelected.length">Materia</span>
                            <span v-else>{{ subSelected[0] }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                            <li v-for="subject in subjects" :key="subject.id" class="dropdown-item"><button class="text-light" @click="selectSub($event, subject.subject)">{{ subject.subject }}</button></li>
                        </ul>
                    </div>
                    <div class="input-group-lg w-25">
                        <span class="input-group-text" id="inputGroup-sizing-lg">UV</span>
                        <input type="text" class="form-control" v-model="uv" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="UV">
                    </div>
                    <div class="dropdown m-4">
                        <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                            <span v-if="!teaSelected.length">Docente</span>
                            <span v-else>{{ teaSelected[0] }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                            <li v-for="teacher in teachers" :key="teacher.id" class="dropdown-item"><button class="text-light" @click="selectTea($event, teacher.name)">{{ teacher.name }}</button></li>
                        </ul>
                    </div>
                <div class="m-4">
                    <button v-if="!editing" type="button" class="d-inline-flex btn btn-primary btn-lg" @click="updateTable">Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                    <button v-if="!editing" type="button" class="d-inline-flex btn btn-warning btn-lg ms-3" @click="clearDropdown">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
                    <button v-else type="button" class="d-inline-flex btn btn-danger btn-lg ms-3" @click="clearDropdown">Cancelar <i class="material-icons m-auto ms-1">cancel</i></button>
                </div>
            </div>
        </section>
        
        <section class=" p-3 ">
            <table class="table table-bordered border-dark">
                <thead class="table-info table-bordered border-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Horario</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">UV</th>
                        <th scope="col">Docente</th>
                        <th scope="col" class="w-25">Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr v-for="schedule in schedules" :key="schedule.id">
                        <th scope="row">{{ schedule.id }}</th>
                        <td>{{ schedule.time }}</td>
                        <td>{{ schedule.description }}</td>
                        <td>{{ schedule.uv }}</td>
                        <td>{{ schedule.teacher }}</td>
                        <td class="d-flex justify-content-center">
                            <button type="button" class="btn btn-primary me-2" @click="selectGroup($event, group.group )">Modificar</button>
                            <button type="button" class="btn btn-danger" @click="confirmDelete($event, group.id)">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>    
</template>

<style scoped>
    .load {
        border-radius: 15px !important;
    }
</style>