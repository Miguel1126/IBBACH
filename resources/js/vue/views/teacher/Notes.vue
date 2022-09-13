<script>
    import DataTable from '../../components/DataTable.vue';
export default {
    mounted() {
        this.getNotes();
        this.getInscriptions()
    },
    data() {
        return {
            ev1: '',
            ev2: '',
            ev3: '',
            ev4: '',
            ev5: '',
            percentege1: '',
            percentege2: '',
            percentege3: '',
            percentege4: '',
            percentege5: '',
            finalAverage: '',
            statuses: [
                { id: 1, status: 'Aprobado' },
                { id: 2, status: 'Reprobado' }
            ],
            statusSelected: [],
            inscriptions: [],
            inscriptionSelected: [],
            notes: [],
            editing: false
        }
    },
    methods: {
        async handleSubmit() {
            const response = await this.axios.post('/api/notas', {
                ev1: this.ev1,
                percentege1: this.percentege1,
                ev2: this.ev2,
                percentege2: this.percentege2,
                ev3: this.ev3,
                percentege3: this.percentege3,
                ev4: this.ev4,
                percentege4: this.percentege4,
                ev5: this.ev5,
                percentege5: this.percentege5,
                finalAverage: this.finalAverage,
                status: this.statusSelected[0],
                inscription_id: this.inscriptionSelected[0].id
            });
            console.log(response);
            if (response.status === 201) {
                this.$swal.fire(
                    'Listo',
                    'Se registró el usuario',
                    'success'
                )
                this.getNotes()
            }
        },
        async getNotes() {
            try {
                const response = await this.axios.get('/api/getNota')
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.notes = response.data
                    }
                    else {
                        console.log(response)
                    }
                }
            }
            catch (error) {
                console.error(error)
            }
        },
        async getInscriptions() {
            try {
                const response = await this.axios.get('/api/getInscriptions')
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.inscriptions = response.data
                    }
                    else {
                        console.log(response)
                    }
                }
            }
            catch (error) {
                console.error(error)
            }
        },
        selectInscription(event, inscription) {
            this.inscriptionSelected = [];
            this.inscriptionSelected.push(inscription);
        },
        selectStatus(event, statuses) {
            this.statusSelected = [];
            this.statusSelected.push(statuses);
        }
    }, 
    
    components: { DataTable}
}
</script>
<template>
    <main>
        <h1 class="h1 fs-1 fw-bold mb-3">Registro de notas</h1>
        <section class="p-3">
            <h3 class="h3 fw-semibold">registrar una nueva nota</h3>
            <form @submit.prevent="handleSubmit">
                <div class="d-flex mb-3 w-25">
                    <div class="form-group mb-3">
                        <label>Evalucion #1</label>
                        <input type="number" class="form-control" v-model="ev1" />
                    </div>
                    <div class="form-group mb-3">
                        <label>Porcentaje #1</label>
                        <input type="number" class="form-control" v-model="percentege1" />
                    </div>
                </div>
                <div class="d-flex mb-3 w-25">
                    <div class="form-group mb-3">
                        <label>Evalucion #2</label>
                        <input type="number" class="form-control" v-model="ev2" />
                    </div>
                    <div class="form-group mb-3">
                        <label>Porcentaje #2</label>
                        <input type="number" class="form-control" v-model="percentege2" />
                    </div>
                </div>
                <div class="d-flex mb-3 w-25">
                    <div class="form-group mb-3">
                        <label>Evalucion #3</label>
                        <input type="number" class="form-control" v-model="ev3" />
                    </div>
                    <div class="form-group mb-3">
                        <label>Porcentaje #3</label>
                        <input type="number" class="form-control" v-model="percentege3" />
                    </div>
                </div>
                <div class="d-flex mb-3 w-25">
                    <div class="form-group mb-3">
                        <label>Evalucion #4</label>
                        <input type="number" class="form-control" v-model="ev4" />
                    </div>
                    <div class="form-group mb-3">
                        <label>Porcentaje #4</label>
                        <input type="number" class="form-control" v-model="percentege4" />
                    </div>
                </div>
                <div class="d-flex mb-3 w-25">
                    <div class="form-group mb-3">
                        <label>Evalucion #5</label>
                        <input type="number" class="form-control" v-model="ev5" />
                    </div>
                    <div class="form-group mb-3">
                        <label>Porcentaje #5</label>
                        <input type="number" class="form-control" v-model="percentege5" />
                    </div>
                </div>
                <div class="form-group mb-3 w-25">
                    <label>Resultado final</label>
                    <input type="number" class="form-control" v-model="finalAverage" />
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!statusSelected.length">Estado</span>
                        <span v-else>{{ statusSelected[0] }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="status in statuses" :key="status.id" class="dropdown-item text-light list-click"
                            @click="selectStatus($event, status.status)">{{ status.status }}</li>
                    </ul>
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!inscriptionSelected.length">Inscripcion</span>
                        <span v-else>
                            Fecha de registro: {{ inscriptionSelected[0].registration_date }} |
                            Alumno: {{ inscriptionSelected[0].name }} {{ inscriptionSelected[0].last_name }} |
                            Código: {{ inscriptionSelected[0].code }} |
                            Materia: {{ inscriptionSelected[0].subject }} </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="inscription in inscriptions" :key="inscription.id"
                            class="dropdown-item text-light list-click" @click="selectInscription($event, inscription)">
                            Fecha de registro: {{ inscription.registration_date }} |
                            Alumno: {{ inscription.name }} {{ inscription.last_name }} |
                            Código: {{ inscription.code }} |
                            Materia: {{ inscription.subject }}
                        </li>
                    </ul>
                </div>
                <button v-if="!editing" type="submit" class="d-inline-flex btn btn-primary btn-lg ms-4">Agregar <i
                        class="material-icons m-auto ms-1">add_box</i></button>
                <button v-if="!editing" type="button" class="d-inline-flex btn btn-warning btn-lg ms-3"
                    @click="clearInput">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
            </form>
        </section>
        <section class=" p-3 ">
        </section>
        <section class="p-3">
            <DataTable title="Listado de notas" :headers="[
                {title:'Id'},
                {title:'Ciclo'},
                {title:'Asignatura'},
                {title:'Nombre'},
                {title:'Apellido'},
                {title:'Codigo'},
                {title:'Grupo'},
                {title:'Evalucion #1'},
                {title:'Porcentaje'},
                {title:'Evalucion #2'},
                {title:'Porcentaje'},
                {title:'Evalucion #3'},
                {title:'Porcentaje'},
                {title:'Evalucion #4'},
                {title:'Porcentaje'},
                {title:'Evalucion #5'},
                {title:'Porcentaje'},
                {title:'Resultado Final'},
                {title:'Estado'},
            ]" :items="notes">
            </DataTable>
        </section>
    </main>
</template>