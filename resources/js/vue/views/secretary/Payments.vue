<script>
import DataTable from '../../components/DataTable.vue';
import { handleErrors } from '../../js/handle_error';
import LoadingDots from '../../components/LoadingDots.vue';
import { formatDate } from '../../js/format_time';
export default {
    mounted() {
        this.getGroups()
        this.getRates()
    },
    data() {
        return {
            picked: '',
            userName: '',
            sourcharge: 0,
            queryLoading: false,
            loadingUsers: false,
            groups: [],
            rates: [],
            userPayments: [],
            rate: {
                Sabatino: 17,
                Diurno: 30
            },
            rateFiltered: {
                id: null,
                price: null,
            },
            nRate: null,
            total: 0,
            studentsFound: [],
            months: [],
            selectedUser: {},
            foundUser: false,
            notFound: false,
            loading: false,
            success: false,
            siteUrl: window.location.origin
        }
    },
    methods: {
        async getGroups() {
            try {
                const response = await this.axios.get('/api/get-grupos')
                this.groups = response.data
            }
            catch (error) {
                handleErrors(error)
            }
        },
        async getRates() {
            try {
                const response = await this.axios.get('/api/getTarifas')
                this.rates = response.data
            }
            catch (error) {
                handleErrors(error)
            }
        },
        async searchStudent() {
            if (this.picked) {
                this.notFound = false
                this.queryLoading = true
                this.loadingUsers = true
                try {
                    const response = await this.axios.post('/api/search-student', { userName: this.userName, groupId: this.picked })
                    if (response.data.length) this.studentsFound = response.data
                    else this.notFound = true
                    this.loadingUsers = false
                } catch (error) {
                    handleErrors(error)
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
                    icon: 'warning',
                    title: 'Selecciona una modalidad'
                })
            }
        },
        async getUserPayments(userId) {
            try {
                this.userPayments[0] = 'loading'
                const response = await this.axios.get('/api/get-user-payments/' + userId)
                this.userPayments = this.formatData(response.data)
            }
            catch (error) {
                this.userPayments[0] = 'error'
                handleErrors(error)
            }
        },
        async savePayment() {
            this.loading = true
            const date = new Date()
            const currentDate = `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`
            if (this.months.length) {
                try {
                    const payload = {
                        payment_date: currentDate,
                        total: this.total,
                        sourcharge: this.sourcharge,
                        rate_id: this.rateFiltered.id,
                        user_id: this.selectedUser.id,
                        paidMonths: this.months.length
                    }

                    const response = await this.axios.post('/api/savePago', payload)
                    if (response.status === 201) {
                        this.success = true
                        this.selectedUser.paid_months += this.months.length
                        this.getUserPayments(this.selectedUser.id)
                    }
                }
                catch (error) {
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
                        title: 'Ocurrió un error, inténtalo de nuevo'
                    })
                    this.loading = false
                    handleErrors(error)
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
                    icon: 'warning',
                    title: 'Selecciona al menos un pago'
                })
            }
            this.loading = false
        },
        selectUser(user) {
            this.selectedUser = {}
            this.selectedUser = user
            this.queryLoading = false
            this.success = false
            this.months = []
            this.sourcharge = 0
            this.getRate()
            this.getUserPayments(this.selectedUser.id)
            this.foundUser = true
        },
        getRate() {
            let rates = [...this.rates]
            let rate = rates.filter(r => r.price == this.rate[this.selectedUser.group])[0]
            this.rateFiltered.id = rate["id"]
            this.rateFiltered.price = rate["price"]
            if (this.selectedUser.group == "Diurno") this.nRate = 4
            if (this.selectedUser.group == "Sabatino") this.nRate = 9
        },
        calcTotal() {
            let total = parseFloat((this.rateFiltered.price * this.months.length) + this.sourcharge).toFixed(2)
            this.total = total
            return total
        },
        formatData(data) {

            let useData = [...data]

            useData.forEach(p => {
                p.payment_date = formatDate(p.payment_date)
                p.price = `$${p.price}`
                p.sourcharge = `$${p.sourcharge}`
                p.total = `$${p.total}`
            })

            return useData
        }
    },

    setup() {
        document.title = "IBBACH | Pagos"
    },
    components: { DataTable, LoadingDots }
}
</script>
<template>
    <main>
        <h1 class="fw-semibold ms-3">Registrar nuevo pago</h1>
        <form @submit.prevent="searchStudent">
            <div class="m-3 d-flex align-items-center justify-content-between flex-wrap search-bar">
                <div class="">
                    <p class="fs-5">Selecciona la modalidad: </p>
                    <div v-for="group in groups" class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" :name="groups.group" :id="group.group"
                            :value="group.id" v-model="picked">
                        <label class="form-check-label cursor-pointer" :for="group.group">{{ group.group }}</label>
                    </div>
                </div>
                <div class="d-flex">
                    <input type="text" class="form-control input" placeholder="Nombre del alumno" v-model="userName" />
                    <button type="submit" class="btn btn-secondary btn-lg ms-2 d-flex align-items-center"><span
                            class="material-symbols-outlined me-1">search</span></button>
                    <div class="query-result shadow" v-if="queryLoading">
                        <div class="d-flex justify-content-center mt-3 dots" v-if="loadingUsers">
                            <LoadingDots />
                        </div>
                        <div class="d-flex justify-content-center mt-3" v-else-if="notFound">
                            <p class="not-found">No se encontró el usuario</p>
                        </div>
                        <div v-else>
                            <ul class="found-users-list">
                                <li v-for="student in studentsFound" @click="selectUser(student)">
                                    <div>
                                        <img v-if="student.img" class="found-profile-img"
                                            :src="`${siteUrl}/images/users/${student.img}`" />
                                        <img v-else class="found-profile-img"
                                            :src="`${siteUrl}/images/users/no-image.svg`" />
                                    </div>
                                    <div>
                                        <span>{{ student.student }}</span>
                                        <span>{{ student.code }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <Transition name="fade">
            <div class="dashboard" v-if="foundUser">
                <section class="user-data-card m-3">
                    <div class="user-data-container">
                        <div class="profile-picture">
                            <img v-if="selectedUser.img" class="img-fluid"
                                :src="`${siteUrl}/images/users/${selectedUser.img}`" />
                            <img v-else class="img-fluid" :src="`${siteUrl}/images/users/no-image.svg`" />
                        </div>
                        <div class="user-data">
                            <p><b>Estudiante: </b>{{ selectedUser.student }}</p>
                            <p><b>Código: </b>{{ selectedUser.code }}</p>
                            <p><b>Teléfono: </b>{{ selectedUser.phone }}</p>
                            <p><b>Correo Electrónico: </b>{{ selectedUser.email }}</p>
                            <p><b>Dirección: </b>{{ selectedUser.address }}</p>
                            <p><b>Modalidad: </b>{{ selectedUser.group }}</p>
                            <p><b>Total pagos realizados: </b>{{ selectedUser.paid_months }}</p>
                        </div>
                    </div>
                </section>
                <section class="pay-detail-card m-3" success>
                    <div class="d-flex" v-if="selectedUser.group == 'Diurno' && selectedUser.paid_months == 4">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="d-block">
                                <div class="d-flex justify-content-center">
                                    <span class="material-symbols-outlined icon">task_alt</span>
                                </div>
                                <p class="mt-3 fw-bold fs-5 text-center">¡Este usuario ya completó los pagos!</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex" v-else-if="selectedUser.group == 'Sabatino' && selectedUser.paid_months == 9">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="d-block">
                                <div class="d-flex justify-content-center">
                                    <span class="material-symbols-outlined icon">task_alt</span>
                                </div>
                                <p class="mt-3 fw-bold fs-5 text-center">¡Este usuario ya completó los pagos!</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex" v-else>
                        <div class="d-flex justify-content-center align-items-center" v-if="success">
                            <div class="d-block">
                                <div class="d-flex justify-content-center">
                                    <span class="material-symbols-outlined icon">task_alt</span>
                                </div>
                                <p class="mt-3 fw-bold fs-5 text-center">¡Pago registrado con éxito!</p>
                            </div>
                        </div>
                        <div v-else>
                            <h4>Detalle del pago</h4>
                            <div class="fs-6 mb-1"><span>Pagos a realizar: {{ months.length }}</span></div>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <input v-for="a in (nRate - parseInt(selectedUser.paid_months))" class="check-input"
                                    type="checkbox" :value="a" v-model="months">
                            </div>
                            <div class="fs-6 my-1"><span>Sobrecargo:</span></div>
                            <div class="input-group input-group-sm mb-3">
                                <input type="number" class="form-control" aria-describedby="inputGroup-sizing-sm"
                                    v-model="sourcharge">
                            </div>
                            <div class="fs-6 my-1"><span>Cuota: ${{ rateFiltered.price }}</span></div>
                            <hr>
                            <div class="fs-6 my-1"><span><b>Total:</b> ${{ calcTotal() }}</span></div>
                            <div class="fs-6 mt-4 d-flex justify-content-center" v-if="loading">
                                <LoadingDots></LoadingDots>
                            </div>
                            <div class="fs-6 mt-4" v-else>
                                <button type="button"
                                    class="btn btn-success btn-sm btn-pay d-inline-flex justify-content-center gap-2"
                                    @click.prevent="savePayment()">Registrar pago <span
                                        class="material-symbols-outlined">payments</span></button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </Transition>
        <Transition name="fade">
            <div class="m-3" v-if="foundUser">
                <DataTable personalized :title="'Historial de pagos de ' + selectedUser.student" :headers="[
                    {title: 'Fecha de pago', value: 'payment_date'},
                    {title: 'Pagos realizados', value: 'paid_count'},
                    {title: 'Cuota', value: 'price'},
                    {title: 'Sobrecargo', value: 'sourcharge'},
                    {title: 'Total', value: 'total'}
                ]" :items="userPayments">
                </DataTable>
            </div>
        </Transition>
    </main>
</template>

<style scoped>
.fade-enter-from {
    opacity: 0;
}

.fade-enter-active {
    transition: all .5s ease;
}

.search-bar {
    background-color: var(--dark);
    padding: 8px;
    border-radius: 5px;
    position: relative;
    gap: 2rem;
}

.input {
    max-width: 300px;
    height: 50px;
    background-color: var(--dark-alt);
    color: #eee;
    border-top: 0px;
    border-left: 0px;
    border-right: 0px;
    border-bottom: 0px;
    border-radius: 5px;
}

.query-result {
    max-width: 300px;
    min-height: 50px;
    background-color: var(--dark);
    position: absolute;
    top: 65px;
}
.dots {
    padding: 0px 110px 0px;
}
.not-found {
    padding: 0px 52px 0px;
}
.found-users-list {
    width: 100%;
    margin: 0;
    padding: 0;
}

.found-users-list li {
    list-style: none;
    display: flex;
    align-items: center;
    padding: 7px;
    min-height: 50px;
    border-bottom: 1px solid #6f6f6f;
    cursor: pointer;
    transition: all .2s ease;
}

.found-users-list li:hover {
    background-color: #3a3944;
}

.found-users-list li div>img {
    width: 40px;
    height: 40px;
    margin-right: 8px;
    border-radius: 50%;
}

.found-users-list li div>span {
    display: block;
}

.dashboard {
    display: flex;
    flex-wrap: wrap;
}

.user-data-card {
    width: fit-content;
    padding: 2rem;
    background: var(--dark);
    border-radius: 5px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.user-data-container {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
}

.profile-picture img {
    border-radius: 50%;
    width: 200px;
    height: 200px;
}

.user-data {
    font-size: 1.1em;
}

.pay-detail-card {
    width: fit-content;
    max-width: 280px;
    padding: 1.3rem;
    background: var(--dark);
    border-radius: 5px;
}

.pay-detail-card[success] {
    display: flex;
}

.check-input {
    width: 2em;
    height: 2em;
    border-radius: 5px;
    cursor: pointer;
}

.icon {
    font-size: 3rem;
    color: #00e21e;
}

.btn-pay {
    width: 100%;
}

@media (max-width: 559px) {
    .profile-picture img {
        width: 150px;
        height: 150px;
    }

    .query-result {
        top: 160px;
    }
}

@media (max-width: 235px) {
    .query-result {
        top: 190px;
    }
}

@media (max-width: 196px) {
    .profile-picture img {
        width: 100px;
        height: 100px;
    }
}

@media (max-width: 556px) {
    .m-3 {
        margin: 0.3rem !important;
    }
}
</style>