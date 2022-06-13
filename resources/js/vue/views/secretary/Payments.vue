<script>
    export default {
        data() {
            return {
                rates: [
                    { id: 1, rate: 'Cuota 1' },
                    { id: 2, rate: 'Cuota 2' },
                    { id: 3, rate: 'Cuota 3' },
                    { id: 4, rate: 'Cuota 4' }
                ],
                users: [
                    { id: 1, name: 'Usuario 1' },
                    { id: 2, name: 'Usuario 2' },
                    { id: 3, name: 'Usuario 3' },
                    { id: 4, name: 'Usuario 4' }
                ],
                payments: [
                    { id: 1, payDate: '2022-05-31', lastPayDate: '2022-06-04', surcharge: 5.00, rate: 'Cuota 1', user: 'Usuario 1' },
                    { id: 2, payDate: '2022-05-31', lastPayDate: '2022-06-04', surcharge: 5.00, rate: 'Cuota 2', user: 'Usuario 2' },
                    { id: 3, payDate: '2022-05-31', lastPayDate: '2022-06-04', surcharge: 5.00, rate: 'Cuota 3', user: 'Usuario 3' },
                    { id: 4, payDate: '2022-05-31', lastPayDate: '2022-06-04', surcharge: 5.25, rate: 'Cuota 4', user: 'Usuario 4' },
                ],
                payment: {
                    raSelected: [],
                    usSelected: [],
                    payDate: null,
                    lastPayDate: null,
                    surcharge: null,
                },
                editing: false
            }
        },
        methods: {
            selectRa(event, rate) {
                this.payment.raSelected = []
                this.payment.raSelected.push(rate)
            },
            selectUs(event, user) {
                this.payment.usSelected = []
                this.payment.usSelected.push(user)
            },
            clearDropInput() {
                const app = this
                app.payment.raSelected = []
                app.payment.usSelected = []
                app.payment.payDate = null
                app.payment.lastPayDate = null
                app.payment.surcharge = null
                app.editing = false
            },
            validateDropInput() {
                const app = this;
                const valid = app.payment.raSelected.length && app.payment.usSelected.length && app.payment.payDate && app.payment.lastPayDate ? true : false
                return valid
            },
            updateTable() {
                const app = this
                if (app.validateDropInput()) {
                    app.payments.push({ id: app.payments.length + 1, payDate: app.payment.payDate, lastPayDate: app.payment.lastPayDate, surcharge: app.payment.surcharge, rate: app.payment.raSelected[0], user: app.payment.usSelected[0] })
                    app.clearDropInput()
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
            selectPayment(event, payDate, lastPayDate, surcharge, rate, user) {
                const app = this
                app.editing = true
                app.payment.payDate = payDate
                app.payment.lastPayDate = lastPayDate
                app.payment.surcharge = surcharge
                app.payment.raSelected.push(rate)
                app.payment.usSelected.push(user)
            },
            saveEdit() {
                this.editing = false
                this.clearDropInput()
                this.$swal.fire(
                        'Listo',
                        'Se editó el pago',
                        'success'
                    )
            },
            deletePayment(id){
                this.payments = this.payments.filter(payment => payment.id != id)
                this.payments = [... this.payments]
            },
            confirmDelete(event, id) {
                this.$swal.fire({
                    title: '¿Estas seguro de querer borrar este pago?',
                    text: "Si lo borras, no podrás recuperarlo",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Borrar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                if (result.isConfirmed) {
                    this.deletePayment(id)
                    this.$swal.fire(
                        'Listo',
                        'El pago ha sido eliminad0',
                        'success'
                    )
                }
                })
            }
        },
        setup() {
            document.title = "IBBACH | Pagos"
        }
    }
</script>

<template>
    <main>
        <h1 class="h1 fs-1 fw-bold">Registro de pagos</h1>
        <br />
        <section class="p-3">
            <h3 class="h3 fw-semibold">Ingresa el pago</h3>
            <div class="d-flex">
                <div class="m-2">
                    <label>Fecha de pago</label>
                    <input class="form-control" type="date" name="fechainicio" placeholder="00-00-000" v-model="payment.payDate">
                </div>
                <div class="m-2">
                    <label>Ultima fecha de pago</label>
                    <input class="form-control" type="date" name="fechafin" placeholder="00-00-000" v-model="payment.lastPayDate">
                </div>
                <div class="m-2">
                    <label>Cargo por incumplir fecha de pago</label>
                    <input class="form-control" type="number" name="cargo" placeholder="5.00" v-model="payment.surcharge">
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!payment.raSelected.length">Cuota</span>
                        <span v-else>{{ payment.raSelected[0] }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="rate in rates" :key="rate.id" class="dropdown-item text-light list-click" @click="selectRa($event, rate.rate)">{{ rate.rate }}</li>
                    </ul>
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!payment.usSelected.length">Usuario</span>
                        <span v-else>{{ payment.usSelected[0] }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="user in users" :key="user.id" class="dropdown-item text-light list-click" @click="selectUs($event, user.name)">{{ user.name }}</li>
                    </ul>
                </div>
                <div class="m-4">
                    <button v-if="!editing" type="button" class="d-inline-flex btn btn-primary btn-lg" @click="updateTable">Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                    <button v-else type="button" class="d-inline-flex btn btn-success btn-lg" @click="saveEdit">Guardar <i class="material-icons m-auto ms-1">edit</i></button>
                    <button v-if="!editing" type="button" class="d-inline-flex btn btn-warning btn-lg ms-3" @click="clearDropInput">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
                    <button v-else type="button" class="d-inline-flex btn btn-danger btn-lg ms-3" @click="clearDropInput">Cancelar <i class="material-icons m-auto ms-1">cancel</i></button>
                </div>
            </div>
        </section>
        <hr class="separator"/>
        <section class="p-3">
            <div class="table-container p-3 mb-5 bg-body rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Listado de pagos</h3>
                <table class="table table-bordered border-dark bg-light">
                    <thead class="table-success table-bordered border-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Fecha de pago</th>
                            <th scope="col">Ultima fecha de pago</th>
                            <th scope="col">Cargo</th>
                            <th scope="col">Cuota</th>
                            <th scope="col">Usuario</th>
                            <th scope="col" class="w-25">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="payment in payments" :key="payment.id">
                            <th scope="row">{{ payment.id }}</th>
                            <td>{{ payment.payDate }}</td>
                            <td>{{ payment.lastPayDate }}</td>
                            <td>$ {{ payment.surcharge }}</td>
                            <td>{{ payment.rate }}</td>
                            <td>{{ payment.user }}</td>
                            <td class="d-flex justify-content-center">
                                <button type="button" class="btn btn-primary me-2" @click="selectPayment($event, payment.payDate, payment.lastPayDate, payment.surcharge, payment.rate, payment.user)">Modificar</button>
                                <button type="button" class="btn btn-danger" @click="confirmDelete($event, payment.id)">Eliminar</button>
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