<script>
    export default {
        data() {
            return {
                edate: [],
                sdate: [],
                start_dates: [
                {id: 1, sdate: '2022-06-01'},
                {id: 2, sdate: '2022-06-03'}
                ],
                end_dates: [
                {id: 1, edate: '2022-06-02'},
                {id: 2, edate: '2022-06-03'}
                ],
                cycle: [
                    {id:1, cycle:'01/2022'},
                    { id: 2, cycle: '02/2022' }
                ],
                groups: [
                    { id: 1, group: 'Diurno' },
                    { id: 1, group: 'Sabatino' }
                ],
                  cys: [
                    { id: 1, cycle: '01/2022', sdate: '2022-06-01', edate: '2022-06-02', group:'Diurno' },
                    { id: 1, cycle: '02/2022', sdate: '2022-06-03', edate: '2022-06-03', group:'Sabatino' }
                ],
                cyc:null,
                groSelected: [],
                cyTyped: [],
                sdSelected: [],
                edSelected: [],
                editing: false
            }
        },
        methods: {
            selectEnd(event, edate) {
            this.edSelected = []
            this.edSelected.push(edate)
            },
            selectSd(event, sdate) {
                this.sdSelected = []
                this.sdSelected.push(sdate)
            },
            selectGro(event, group) {
                this.groSelected = []
                this.groSelected.push(group)
            },
            typeCy(event, cycle) {
                this.cyTyped = []
                this.cyTyped.push(cycle)
            },
            
            updateTable() {
                const app = this
                    app.cys.push({ id: app.cys.length + 1, cycle: app.cyc, sdate: app.sdSelected[0], edate: app.edSelected[0], group: app.groSelected[0] })
                
            },
            selectCycle(event, cycle, sdate, edate, group) {
                const app = this
                app.editing = true
                app.cyTyped.push(cycle)
                app.sdSelected.push(sdate)
                app.edSelected.push(edate)
                app.groSelected.push(group)
            },
            saveEdit() {
                this.editing = false
                this.clearDropdown()
                this.$swal.fire(
                        'Listo',
                        'Se editó el ciclo',
                        'success'
                    )
            },
            deleteCycle(id){
                this.cys = this.cys.filter(cy => cy.id != id);
                this.cys = [... this.cys];
            },
            confirmDelete(event, id) {
                this.$swal.fire({
                    title: '¿Estas seguro de querer borrar este ciclo?',
                    text: "Si la borras, no podrás recuperarla",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Borrar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteCycle(id)
                    this.$swal.fire(
                        'Listo',
                        'El ciclo ha sido eliminada',
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
        <!--usando clases de boostrap-->
         <h1 class="h1 fs-1 fw-bold">Registro de ciclos</h1>
         <p>{{ cyc }}</p>
        <br />
          <!--creado contenedor para los botones-->
        <section class="p-3">
            <h3 class="h3 fw-semibold">Crear nuevo ciclo</h3>
            <div class="d-flex">
                <div class="input-group input-group-lg w-25">
                    <span class="input-group-text" id="inputGroup-sizing-lg"><i class="material-icons">autorenew</i></span>
               <input type="text" class="form-control" v-model="cyc" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="Nuevo ciclo">
                </div>
                <div class="dropdown m-4">
                   <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!sdSelected.length">fecha de inicio</span>
                        <span v-else>{{ sdSelected[0] }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                          <div><input type="date" v-model="sdate"><p>Fecha: {{ sdate }}</p></div>
                            <li v-for="start_date in start_dates" :key="start_date.id" class="dropdown-item"><button class="text-light" @click="selectSd($event, start_date.sdate)">{{ start_date.sdate }}</button></li> 
                    </ul>
                </div>
                <div class="dropdown m-4">
                   <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!edSelected.length">fecha de finalización</span>
                        <span v-else>{{ edSelected[0] }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                          <div><input type="date" v-model="edate"><p>Fecha: {{ edate }}</p></div>
                            <li v-for="end_date in end_dates" :key="end_date.id" class="dropdown-item"><button class="text-light" @click="selectEnd($event, end_date.edate)">{{ end_date.edate }}</button></li> 
                    </ul>
                </div>
                 <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!groSelected.length">Grupo</span>
                        <span v-else>{{ groSelected[0] }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="group in groups" :key="group.id" class="dropdown-item"><button class="text-light" @click="selectGro($event, group.group)">{{ group.group }}</button></li>
                    </ul>
                </div>
                <div class="m-4">
                    <button type="button" class="btn btn-primary btn-lg" @click="updateTable">Agregar <i class="material-icons m-auto">add_box</i></button>
                    <button type="button" class="btn btn-warning btn-lg ms-4" @click="clearDropdown">Limpiar <i class="material-icons m-auto">backspace</i></button>
                </div>
            </div>
        </section>
        <hr class="separator"/>
        <section class="p-3">
            <div class="table-container p-3 mb-5 bg-body rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Listado de ciclos</h3>
                <table class="table table-bordered border-dark">
                    <thead class="table-info table-bordered border-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ciclo</th>
                            <th scope="col">Fecha de inicio</th>
                            <th scope="col">Fecha de finalización</th>
                            <th scope="col">Grupo</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="cy in cys" :key="cy.id">
                            <th scope="row">{{ cycle.id }}</th>
                            <td>{{ cy.cycle }}</td>
                            <td>{{ cy.sdate }}</td>
                            <td>{{ cy.edate }}</td>
                            <td>{{ cy.group }}</td>
                            <td class="d-flex justify-content-center"><button type="button" class="btn btn-primary me-2">Modificar</button><button type="button" class="btn btn-danger">Eliminar</button></td>
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