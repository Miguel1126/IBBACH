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
                teaSelected: []
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
            },
            updateTable() {
                const app = this
                this.loads.push({ id: app.loads.length + 1, cycle: app.cySelected[0], subject: app.subSelected[0], teacher: app.teaSelected[0] })
                app.clearDropdown()
            }
        }
    }
</script>

<template>
    <main>
        <h1 class="h1 fs-1 fw-bold">Administrador de carga académica</h1>
        <br />
        <section class="load border border-success p-3 border-5 rounded">
            <h3 class="h3 fw-semibold">Asignar una nueva carga</h3>
            <div class="d-flex">
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!cySelected.length">Ciclo</span>
                        <span v-else>{{ cySelected[0] }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="cycle in cycles" :key="cycle.id" class="dropdown-item"><button class="text-light" @click="selectCy($event, cycle.cycle)">{{ cycle.cycle }}</button></li>
                    </ul>
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
                    <button type="button" class="btn btn-primary btn-lg" @click="updateTable">Agregar <i class="material-icons m-auto">add_box</i></button>
                    <button type="button" class="btn btn-warning btn-lg ms-4" @click="clearDropdown">Limpiar <i class="material-icons m-auto">backspace</i></button>
                </div>
            </div>
        </section>
        <section class="load border mt-4 border-primary p-3 border-5 rounded">
            <h3 class="h3 fw-semibold mb-3">Listado de cargas</h3>
            <table class="table table-bordered border-dark">
                <thead class="table-info table-bordered border-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Ciclo</th>
                        <th scope="col">Materia</th>
                        <th scope="col">Docente</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr v-for="load in loads" :key="load.id">
                        <th scope="row">{{ load.id }}</th>
                        <td>{{ load.cycle }}</td>
                        <td>{{ load.subject }}</td>
                        <td>{{ load.teacher }}</td>
                        <td class="d-flex justify-content-center"><button type="button" class="btn btn-primary me-2">Modificar</button><button type="button" class="btn btn-danger">Eliminar</button></td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>    
</template>

<style scoped>
    .load {
        border-radius: 20px !important;
    }
</style>