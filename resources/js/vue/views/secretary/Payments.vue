<script>
    import DataTable from '../../components/DataTable.vue';
export default {
    mounted() {
        this.getPayments(1, true);
        this.getRates(1, true);
        this.getStudents(1, true);
    },
    data() {
        return {
            rates: '',
            rateSelected: [],
            payment_date: '',
            sourcharge: '',
            last_pay_date: '',
            students: [],
            studentSelected: [],
            payments: [],
            paginationLinks: [],
            editing: false

        }
    },
    methods: {
        async handleSubmit() {
            if (this.validateInput()) {
                const response = await this.axios.post('/api/pagos', {
                    payment_date: this.payment_date,
                    last_pay_date: this.last_pay_date,
                    sourcharge: this.sourcharge,
                    rate_id: this.rateSelected[0].id,
                    user_id: this.studentSelected[0].id
                });
                console.log(response);
                if (response.status === 201) {
                    this.clearInput()
                    this.getPayments();
                    this.$swal.fire(
                        'Listo',
                        'Se registró el pago',
                        'success'
                    )
                }
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
        async getPayments(pageNumber, firstPayments = false) {
            if(firstPayments) this.payments[0] = 'loading'
            if(typeof (pageNumber) == 'string'){
                pageNumber = new URL(pageNumber).searchParams.getAll('page') [0]
            }
            try {
                const response = await this.axios.get('/api/getPagos?page=' + pageNumber)
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.payments = response.data.data;
                        this.paginationLinks = response.data.links
                    }
                    else {
                        this.payments[0] = 'error'
                    }
                }
            }
            catch(error) {
                console.log(error);
                this.payments[0] = 'error'
            }
        },
        async getStudents() {
            try {
                const response = await this.axios.get('/api/getStudent')
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.students = response.data
                    }
                    else {
                        console.log(response)
                        this.students[0] = 'error'
                    }
                }
            }
            catch(error) {
                console.log(error)
            }
        },
        async getRates() {
            try {
                const response = await this.axios.get('/api/getTarifas')
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.rates = response.data
                        console.log(response)
                    }
                    else {
                        this.rates[0] = 'error'
                    }
                }
            }
            catch {
                (error) => console.error(error)
            }
        },
        clearInput() {
            this.payment_date = null
            this.sourcharge = null
            this.last_pay_date = null
            this.rateSelected = []
            this.studentSelected = []
        },
        validateInput() {
            let valid = this.payment_date && this.sourcharge && this.last_pay_date && this.studentSelected && this.rateSelected ? true : false
            return valid
        },
        selectStudent(event, students) {
            this.studentSelected = [];
            this.studentSelected.push(students);
        },
        selectRate(event, rates) {
            this.rateSelected = [];
            this.rateSelected.push(rates);
        },
    },
    components: {DataTable}
}
</script>
<template>
    <main>
        <h1 class="h1 fs-1 fw-bold mb-3">Registro de pagos</h1>
        <section class="p-3">
            <h3 class="h3 fw-semibold">Registrar nuevo pago</h3>
            <form class="w-25" @submit.prevent="handleSubmit">
                <div class="form-group mb-3">
                    <label>Fecha de pago</label>
                    <input type="date" class="form-control" v-model="payment_date" />
                </div>
                <div class="form-group mb-3">
                    <label>Ultima fecha de pago</label>
                    <input type="date" class="form-control" v-model="last_pay_date" />
                </div>
                <div class="form-group mb-3">
                    <label>Sobrecargo</label>
                    <input type="number" class="form-control" v-model="sourcharge" />
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!rateSelected.length">Cuota</span>
                        <span v-else>{{ rateSelected[0].price }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <!--<li v-for="price in rates" :key="price.id" class="dropdown-item text-light list-click"
                        @click="selectRate($event, price)">{{ price.price }}</li>-->
                    </ul>
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!studentSelected.length">Alumno</span>
                        <span v-else>{{ studentSelected[0].student }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="student in students" :key="student.id" class="dropdown-item text-light list-click"
                            @click="selectStudent($event, student)">{{ student.student }}</li>
                    </ul>
                </div>
                <button v-if="!editing" type="button" class="d-inline-flex btn btn-primary btn-lg ms-4"
                    @click="handleSubmit">Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                <button v-if="!editing" type="button" class="d-inline-flex btn btn-warning btn-lg ms-3"
                    @click="clearInput">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
            </form>
        </section>
        <section class="p-3">
            <DataTable title="Listado de pagos" :headers="[
                {title:'Id'},
                {title:'Fecha de pago'},
                {title:'Ultima fecha de pago'},
                {title:'Estado'},
                {title:'Sobrecargo'},
                {title:'Alumno'},
                {title:'Cuota'},
                {title: 'Acciones'}
            ]" :items="payments">
            <template #actions>
                    <button type="button" class="btn btn-primary me-2">Modificar</button>
                    <button type="button" class="btn btn-danger">Eliminar</button>
                </template>
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                    <ul class="pagination">
                        <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                            v-for="page in paginationLinks" :key="page">
                            <span class="page-link" @click="getPayments(page.url)">{{ page.label == 'pagination.previous'
                                    ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                            }}</span>
                         </li>
                    </ul>
                </nav>
        </section>
    </main>
</template>