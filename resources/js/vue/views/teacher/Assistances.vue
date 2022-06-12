<script>
export default {
    data() {
        return {
            assistance: {
                date:null,
                staSelected: [],
                notSelected: []
            },
            status: [
                {id: 1, statu: 'Presente'},
                {id: 2, statu: 'Ausente'},
                {id: 3, statu: 'permiso'}
            ],
            notes: [
                {id: 1, note: '1'},
                {id: 2, note: '2'},
                {id: 3, note: '3'}
            ]
        }
    },
    methods: {
        selectSta(event, statu) {
            this.assistance.staSelected = []
            this.assistance.staSelected.push(statu)
        },
         selectNot(event, note) {
            this.assistance.notSelected = []
            this.assistance.notSelected.push(note)
        }
    }
}
</script>

<template>
    <main>
        <h1 class="h1 fs-1 fw-bold">Registro de asistencia</h1>
        <section class="p-3">
            <h3 class="h3 fw-semibold">Registrar asistencia</h3>
             <div class="d-flex">
                <div class="m-2">
                    <label>Fecha</label>
                    <input class="form-control" type="date" name="fechainicio" placeholder="00-00-000" v-model="assistance.date">
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                <span><i class="material-icons">group</i></span>
                    <span v-if="!assistance.staSelected.length">Estado</span>
                    <span v-else>{{ assistance.staSelected[0] }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                    <li v-for="statu in status" :key="statu.id" class="dropdown-item"><button class="text-light" @click="selectSta($event, statu.statu)">{{ statu.statu }}</button></li> 
                </ul>
                </div>
                 <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                <span><i class="material-icons">note</i></span>
                    <span>Notas</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                    <li v-for="note in notes" :key="note.id" class="dropdown-item"><button class="text-light" @click="SelectedNot($event, note.note)">{{ note.note }}</button></li> 
                </ul>
                </div>
            </div>
        </section>
    </main>
</template>

<style scoped>
    .assistance {
        border-radius: 15px !important;
    }
</style>