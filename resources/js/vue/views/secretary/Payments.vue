<script>
    export default{
          mounted() {
            this.getPayments();
            this.getRates();
            this.getStudents();
        },
        data(){
            return {
               rates: '',
               rateSelected: [],
               payment_date: '',
               sourcharge: '',
               last_pay_date: '',
               students: [],
               studentSelected: [],
               payments: [],
               editing: false

            }
        },
        methods:{
            async handleSubmit(){
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
            async getPayments() {
                try {
                    const response = await this.axios.get('/api/pagos/get')
                    if (response.status === 200) {
                        if (typeof(response.data) === 'object') {
                            this.payments = response.data
                            console.log(response)
                        }
                        else {
                            this.payments[0] = 'error'
                            console.log(response)
                        }
                    }
                }
                catch {
                    (error) => console.error(error) 
                }
            },
            async getStudents() {
                try {
                    const response = await this.axios.get('/api/students')
                    if (response.status === 200) {
                        if (typeof(response.data) === 'object') {
                            this.students = response.data
                        }
                        else {
                            console.log(response)
                            this.students[0] = 'error'
                        }
                    }
                }
                catch {
                    (error) => console.error(error) 
                }
            },
            async getRates() {
                try {
                    const response = await this.axios.get('/api/tarifas/get')
                    if (response.status === 200) {
                        if (typeof(response.data) === 'object') {
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
        }
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
                        <input type="date" class="form-control" v-model="payment_date"/>
                    </div>
                    <div class="form-group mb-3">
                        <label>Ultima fecha de pago</label>
                        <input type="date" class="form-control" v-model="last_pay_date"/>
                    </div>
                    <div class="form-group mb-3">
                        <label>Sobrecargo</label>
                        <input type="number" class="form-control" v-model="sourcharge"/>
                    </div>
                    <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!rateSelected.length">Cuota</span>
                        <span v-else>{{ rateSelected[0].price }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="price in rates" :key="price.id" class="dropdown-item text-light list-click" @click="selectRate($event, price)">{{ price.price }}</li>
                    </ul>
                    </div>
                    <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!studentSelected.length">Alumno</span>
                        <span v-else>{{ studentSelected[0].student }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="student in students" :key="student.id" class="dropdown-item text-light list-click" @click="selectStudent($event, student)">{{ student.student }}</li>
                    </ul>
                    </div>
                    <button v-if="!editing" type="button" class="d-inline-flex btn btn-primary btn-lg ms-4" @click="handleSubmit">Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                    <button v-if="!editing" type="button" class="d-inline-flex btn btn-warning btn-lg ms-3" @click="clearInput">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
                </form>
        </section>
        <hr class="separator"/>
        <section class="p-3">
            <div class="table-container p-3 mb-5 bg-body rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Listado </h3>
                <table class="table table-bordered border-dark">
                    <thead class="table-info table-bordered border-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Fecha de pago</th>
                            <th scope="col">Ultima fecha de pago</th>
                            <th scope="col">Sobrecargo</th>
                            <th scope="col">Cuota</th>
                            <th scope="col">Alumno</th>
                            <th scope="col" class="w-25">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="payment in payments" :key="payment.id">
                            <th scope="row">{{ payment.id }}</th>
                            <td>{{ payment.payment_date }}</td>
                            <td>{{ payment.last_pay_date }}</td>
                            <td>{{ payment.sourcharge }}</td>
                            <td>{{ payment.price }}</td>
                            <td>{{ payment.student }}</td>
                            <td class="d-flex justify-content-center">
                                <button type="button" class="btn btn-primary me-2" @click="selectGroup($event, payment.payment )">Modificar</button>
                                <button type="button" class="btn btn-danger" @click="confirmDelete($event, payment.id)">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</template>