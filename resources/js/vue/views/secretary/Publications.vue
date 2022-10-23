<script>
import { useVuelidate } from '@vuelidate/core'
import { required, helpers } from '@vuelidate/validators'
import DataTable from '../../components/DataTable.vue'
import { handleErrors } from '../../js/handle_error';


export default {
    mounted() {
        this.getPublications(1, true);
    },
    data() {
        return {
            v$: useVuelidate(),
            img: '',
            publications: [],
            thumbnailImage: "",
            siteUrl: window.location.origin,
            paginationLinks: [],
            id: ''
        };
    },
    validations() {
        return {
            img: { required: helpers.withMessage("Agregar una imagen es obligatorio", required) }
        };
    },
    methods: {
        deleteP(idImg) {
            this.$swal.fire({
                title: '¿Estás seguro de eliminar esta publicacion ?',
                text: "La acción no se podrá revertir",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.axios.delete('/api/deletePublication', { data: { id: idImg } })
                        .then(response => {
                            if (response.status === 200) {
                                this.getPublications()
                                this.$swal.fire(
                                    '¡Listo!',
                                    'La publicacion ha sido eliminada',
                                    'success'
                                )
                            }
                            else {
                                this.$swal.fire("Error", "No se pudo eliminar la publicacion, inténtalo de nuevo", "error")
                            }
                        })
                        .catch(error => {
                            this.$swal.fire("Error", "Ocurrió un error, inténtalo de nuevo", "error")
                        })
                }
            })
        },
        async getPublications(pageNumber, firstpublications = false) {
            if (firstpublications) this.publications[0] = 'loading'
            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getpublicaciones?page=' + pageNumber)
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.publications = response.data.data;
                        this.paginationLinks = response.data.links
                    }
                    else {
                        this.publications[0] = 'error'
                    }
                }
            }
            catch (error) {
                handleErrors(error)
                this.publications[0]
            }
        },
        getImage(e) {
            let fileInput = document.getElementById('formFile');
            if (e.target.files[0].size > 2000000) {
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
                    title: 'La imagen no debe pesar mas de 2 MB'
                })
                fileInput.value = '';
                return false;
            }
            let file = e.target.files[0];
            let filePath = fileInput.value;
            let allowedExtensions = /(.jpg|.jpeg)$/i;
            if (!allowedExtensions.exec(filePath)) {
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
                    title: 'Debes elegir una imagen con el formato permitido'
                })
                fileInput.value = '';
                return false;
            }
            this.img = file;
            this.showImage(file);
        },
        showImage(file) {
            let reader = new FileReader();
            reader.onload = (e) => {
                this.thumbnailImage = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        async submitForm() {
            try {
                let data = new FormData;
                data.append("img", this.img);
                const response = await this.axios.post("/api/publicaciones", data);
                if (response.status === 201) {
                    this.clearInputs();
                    this.getPublications();
                    this.$swal.fire("Listo", "¡La nueva publicacion se ha enviado correctamente!", "success");
                }
                else {
                    this.$swal.fire("Error", "Ocurrió un error, intentalo de nuevo", "error");
                    console.log(response);
                }
            }
            catch (error) {
                this.$swal.fire("Error", "Ocurrió un error, intentalo de nuevo", "error");
                console.error(error);
            }
        },
        clearInputs() {
            this.img = null;
            this.thumbnailImage = null;
        }
    },
    computed: {
        images() {
            return this.thumbnailImage;
        }
    },
    components: { DataTable }
}
</script>
<template>
    <main>
        <section>
            <form @submit.prevent="submitForm" enctype="multipart/form-data">
                <span v-if="!thumbnailImage" class="d-flex justify-content-center text-lihgt fs-6 fw-bold text-center">
                    Sellecione una nueva publicacion,
                    <br> debe pesar un máximo de 2 Mb </span>
                <div class="d-flex justify-content-center">
                    <label for="formFile"
                        class="btn btn-secondary m-3 d-inline-flex icon d-flex justify-content-center">
                        <span class="material-symbols-outlined fs-1">add_a_photo</span>
                    </label>
                    <input class="d-none" type="file" id="formFile" @change="getImage" accept=".jpg, .jpeg">
                </div>
                <div class="d-flex justify-content-center"><span class="text-danger" v-if="v$.img.$error">{{
                v$.img.$errors[0].$message}}</span></div>
                <div class="d-flex justify-content-center">
                    <div class="m-3" v-if="thumbnailImage"><img :src="images" class="img-fluid rounded shadow"
                            style="width: 200px; height: 200px" />
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="d-inline-flex btn btn-primary m-2" id="adder-btn">Agregar <i
                            class="material-icons m-auto ms-1">add_box</i></button>
                </div>
            </form>
        </section>
        <section class="p-3 table-section">
            <DataTable personalized title="Publicaciones" :headers="[
                {title: 'Publicaciones', value: 'extra' },
            ]" :items="publications">
                <template #actions="item">
                    <div class="flex-wrap">
                        <img style="width: 200px; height: 200px" class="img-fluid"
                            :src="`${siteUrl}/images/publications/${item.item.img}`" />
                        <div class="m-3 d-flex justify-content-center">
                            <span @click="deleteP(item.item.id)" class="btn btn-danger">Eliminar</span>
                        </div>
                    </div>
                </template>
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks" :key="page">
                        <span class="page-link" @click="getPublications(page.url)">{{ page.label ==
                        'pagination.previous'
                        ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
            </nav>
        </section>
    </main>
</template>