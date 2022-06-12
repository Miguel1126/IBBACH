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
            ],
             assistances:[
                    
                
                ],
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
        },
        
        
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
                    <li v-for="statu in status" :key="statu.id" class="dropdown-item"><button class="text-light list-click" @click="selectSta($event, statu.statu)">{{ statu.statu }}</button></li> 
                </ul>
                </div>
                 <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                <span><i class="material-icons">note</i></span>
                    <span>Notas</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                    <li v-for="note in notes" :key="note.id" class="dropdown-item"><button class="text-light list-click" @click="selectNot($event, note.note)">{{ note.note }}</button></li> 
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
         <section class="p-3">
            <div class="table-container p-3 mb-5 bg-body rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Listado de cargas</h3>
                <table class="table table-bordered border-dark bg-light">
                    <thead class="table-success table-bordered border-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Fecha de asistencia</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Notas</th>
                            <th scope="col" class="w-25">Acciones</th>
                            <tbody class="table-group-divider">
                    </tbody>
                        </tr>
                    </thead>
                    
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