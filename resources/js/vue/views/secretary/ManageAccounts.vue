<script>
import { Swal, swal } from 'sweetalert2/dist/sweetalert2';
import DataTable from '../../components/DataTable.vue';
import UserInfoCard from '../../components/UserInfoCard.vue';
import { formatDate } from '../../js/format_time';

export default {
    mounted() {
        document.title = 'IBBACH | Administrar cuentas'
        this.getUsers(1, true)
    },
    data() {
        return {
            users: [],
            paginationLinks: [],
            loading: false,
            success: false,
            user: {},
            updatedUser: {},
            picked: 'admin',
            tableTitle: 'Usuarios admin',
            siteUrl: window.location.origin
        }
    },
    methods: {
        async getUsers(pageNumber, firstLoad = false, user = 'admin') {
            if (firstLoad) this.users[0] = 'loading'

            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }

            try {
                const response = await this.axios.get('/api/users/' + user + '?page=' + pageNumber)
                if (response.status === 200) {

                    this.users = this.formateDate(response.data.data)
                    this.paginationLinks = response.data.links
                }
                else {
                    this.users[0] = 'error'
                }
            }
            catch (error) {
                console.log(error)
                this.users[0] = 'error'
            }
        },
        showUser(user) {
            this.user = {}
            this.user = user.item
        },
        async restorePassword(userId) {
            await this.$swal.fire({
                title: '¿Estás seguro de restablecer la contraseña del usuario?',
                text: "La acción no se podrá revertir",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Restablecer'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.loading = true
                    this.axios.put('/api/restore-c-access', { id: userId })
                        .then(response => {
                            if (response.status === 200) {
                                this.updatedUser = { ...response.data }
                                this.success = true
                                document.getElementById('close-modal').click()
                            }
                            else {
                                this.$swal.fire("Error", "Ocurrió un error, inténtalo de nuevo", "error")
                            }
                        })
                        .catch(error => {
                            this.$swal.fire("Error", "Ocurrió un error, inténtalo de nuevo", "error")
                        })

                }
            })
            this.loading = false
        },
        async disableUser(userId) {
            await this.$swal.fire({
                title: '¿Estás seguro de deshabilitar este usuario?',
                text: "La acción no se podrá revertir",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Deshabilitar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.loading = true
                    this.axios.put('/api/disable-user', { id: userId })
                        .then(response => {
                            if (response.status === 200) {
                                this.$swal.fire("¡Listo!", "El usuario se ha deshabilitado", "success")
                                document.getElementById('close-modal').click()
                                this.getUsers(1, false, this.picked)
                            }
                            else {
                                this.$swal.fire("Error", "Ocurrió un error, inténtalo de nuevo", "error")
                            }
                        })
                        .catch(error => {
                            this.$swal.fire("Error", "Ocurrió un error, inténtalo de nuevo", "error")
                        })

                }
            })
            this.loading = false
        },
        /**
         * 
         * @param {Array} data 
         */
        formateDate(data) {
            data.forEach(user => user.created_at = formatDate(user.created_at))
            return data
        }

    },
    watch: {
        picked(rolePicked) {
            this.getUsers(1, true, rolePicked)
            this.tableTitle = `Usuarios ${rolePicked}`
        }
    },
    components: { DataTable, UserInfoCard },
}
</script>
<template>
    <section>
        <div class="modal fade text-black text-opacity-75" id="applicantModal" tabindex="-1"
            aria-labelledby="applicantModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-4" id="staticBackdropLabel">Acciones</h5>
                        <button type="button" id="close-modal"
                            class="btn btn-danger text-light d-flex justify-content-center" data-bs-dismiss="modal"
                            aria-label="Close"><span class="material-icons">close</span></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <p><b>Nombre:</b> {{ user.name }} {{ user.last_name }}</p>
                            <p><b>Código:</b> {{ user.code }}</p>
                            <p><b>Fecha de creación:</b> {{ user.created_at }}</p>
                            <div class="d-flex" v-if="!loading">
                                <button class="btn btn-success me-2 d-flex"
                                    @click.prevent="restorePassword(user.id)">Restablecer contraseña <span
                                        class="material-symbols-outlined ms-1">lock_reset</span></button>
                                <button class="btn btn-warning me-2 d-flex"
                                    @click.prevent="disableUser(user.id)">Deshabilitar usuario <span
                                        class="material-symbols-outlined ms-1">person_off</span></button>
                            </div>
                            <span class="d-flex justify-content-start ms-1 mb-4 px-5" v-else>
                                <div class="mt-3 dot-pulse">
                                    <div class="dot-pulse__dot"></div>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h3 class="m-3">Administra las cuentas por su rol</h3>
            <div class="m-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="admin" id="admin" value="admin" v-model="picked">
                    <label class="form-check-label cursor-pointer" for="admin">Admin</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="secretaria" id="secretaria" value="secretaria"
                        v-model="picked">
                    <label class="form-check-label cursor-pointer" for="secretaria">Secretaria</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="docente" id="docente" value="docente"
                        v-model="picked">
                    <label class="form-check-label cursor-pointer" for="docente">Docente</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="alumno" id="alumno" value="alumno"
                        v-model="picked">
                    <label class="form-check-label cursor-pointer" for="alumno">Alumno</label>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <DataTable :title="tableTitle" personalized :headers="[
                { title: 'Nombres', value: 'name' },
                { title: 'Apellidos', value: 'last_name' },
                { title: 'Código', value: 'code' },
                { title: 'Fecha de creación', value: 'created_at' },
                { title: 'Acciones' }
            ]" :items="users">
                <template #actions="item">
                    <button type="button" @click.prevent="showUser(item)"
                        class="btn btn-primary d-flex justify-content-center" title="Ver información detallada"
                        data-bs-toggle="modal" data-bs-target="#applicantModal">
                        <span class="material-icons">account_box</span>
                    </button>
                </template>
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks" :key="page">
                        <span class="page-link" @click="getUsers(page.url, false, picked)">{{ page.label ==
                        'pagination.previous'
                        ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
            </nav>
            <UserInfoCard :userinfo="updatedUser" :changedpass="true" v-if="success"></UserInfoCard>
        </div>
    </section>
</template>
<style scoped>
.cursor-pointer {
    cursor: pointer;
}

.dot-pulse {
    --uib-size: 40px;
    --uib-speed: 1.3s;
    --uib-color: rgb(39, 39, 39);

    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: var(--uib-size);
    height: calc(var(--uib-size) * 0.27);
}

.dot-pulse__dot,
.dot-pulse::before,
.dot-pulse::after {
    content: '';
    display: block;
    height: calc(var(--uib-size) * 0.18);
    width: calc(var(--uib-size) * 0.18);
    border-radius: 50%;
    background-color: var(--uib-color);
    transform: scale(0);
}

.dot-pulse::before {
    animation: pulse var(--uib-speed) ease-in-out infinite;
}

.dot-pulse__dot {
    animation: pulse var(--uib-speed) ease-in-out calc(var(--uib-speed) * 0.125) infinite both;
}

.dot-pulse::after {
    animation: pulse var(--uib-speed) ease-in-out calc(var(--uib-speed) * 0.25) infinite;
}

@keyframes pulse {

    0%,
    100% {
        transform: scale(0);
    }

    50% {
        transform: scale(1.5);
    }
}
</style>