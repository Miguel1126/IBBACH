<script>
import DataTable from '../../components/DataTable.vue';
import { handleErrors } from '../../js/handle_error';
export default {
    mounted() {
        this.getPayments(1, true)
        this.getRates(1, true)
        this.getStudents(1, true)
    },
    data() {
        return {
            rates: [],
            rateSelected: '',
            payment_date: [],
            sourcharge: [],
            last_pay_date: [],
            students: [],
            studentSelected: '',
            payments: [],
            paginationLinks: [],
            editing: false

        }
    },
    methods: {
        async getPayments(pageNumber, firstPayments = false) {
            if (firstPayments) this.payments[0] = 'loading'
            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
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
            catch (error) {
                handleErrors(error)
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

                    }
                }
            }
            catch (error) {
                handleErrors(error)
            }
        },
        async getRates() {
            try {
                const response = await this.axios.get('/api/getTarifas')
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.rates = response.data

                    }
                    else {
                        console.log(response)
                    }
                }
            }
            catch {
                handleErrors(error)
            }
        },
        clearDropdown() {
            this.payment_date = null
            this.sourcharge = null
            this.last_pay_date = null
            this.rateSelected = []
            this.studentSelected = []
            this.editing = false
        },
        validateDropdowns() {
            const valid = this.payment_date && this.sourcharge && this.last_pay_date && this.studentSelected && this.rateSelected ? true : false
            return valid
        },

        async savePayment() {
            const button = document.querySelector('#adder-btn')
            button.disabled = 'true'

            if (this.validateDropdowns()) {
                button.innerText = 'Cargando...'
                try {
                    const response = await this.axios.post('/api/savePago',
                        {
                            payment_date: this.payment_date,
                            last_pay_date: this.last_pay_date,
                            sourcharge: this.sourcharge,
                            user_id: this.studentSelected,
                            rate_id: this.rateSelected,
                        })

                    if (response.status === 201) {
                        this.$swal.fire(
                            'Listo',
                            '¡Se registró el pago correctamente!',
                            'success'
                        )
                        this.getPayments()
                    }
                    else {
                        this.$swal.fire(
                            'Error',
                            'Parece que algo salió mal, intentalo de nuevo',
                            'error'
                        )
                        console.log(response)
                    }
                } catch (error) {
                    handleErrors(error)
                }
                this.clearDropdown()
                button.innerHTML = `Agregar <i class="material-icons m-auto ms-1">add_box</i>`
                button.disabled = ''
            }
            else {
                button.disabled = ''
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
    },

    setup() {
        document.title = "IBBACH | Cargas"
    },
    mounted() {
        this.getPayments()
        this.getStudents()
        this.getRates()
    },
    components: { DataTable }
}
</script>
<template>
    <main>
        <h1 class="h1 fs-1 fw-bold mb-3">Registro de pagos</h1>
        <section class="p-3">
            <h3 class="h3 fw-semibold">Registrar nuevo pago</h3>
            <form @submit.prevent="savePayment">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="d-inline-block">Fecha de pago</label>
                            <input type="date" class="form-control" v-model="payment_date" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="d-inline-block">Ultima fecha de pago</label>
                            <input type="date" class="form-control" v-model="last_pay_date" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="d-inline-block">Sobrecargo</label>
                            <input type="number" class="form-control" v-model="sourcharge" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="d-inline-block" for="roles">Cuota</label>
                            <select class="form-select" id="roles" v-model="rateSelected">
                                <option v-for="price in rates" :key="price.id" :value="price.id">{{
                                price.price }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="d-inline-block" for="roles">Seleccione un alumno</label>
                            <select class="form-select" id="roles" v-model="studentSelected">
                                <option v-for="student in students" :key="student.id" :value="student.id">{{
                                student.student
                                }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row-m3">
                    <div class="col col-lg-3">
                        <div class="d-flex flex-wrap">
                            <button type="submit" class="d-inline-flex btn btn-primary m-2" id="adder-btn">Agregar <i
                                    class="material-icons m-auto ms-1">add_box</i></button>
                            <button type="button" class="d-inline-flex btn btn-warning m-2"
                                @click.prevent="clearDropdown">Limpiar <i
                                    class="material-icons m-auto ms-1">backspace</i></button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <hr class="separator" />
        <section class="p-3 table-section">
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

<style scoped>
.inputs {
    max-width: 400px;
    min-width: 200px;
}


.list-click {
    cursor: pointer;
}
</style>