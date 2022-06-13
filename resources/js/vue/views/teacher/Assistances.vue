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
                {id: 3, statu: 'Permiso'}
            ],
            notes: [
                {id: 1, note: '1'},
                {id: 2, note: '2'},
                {id: 3, note: '3'}
            ],
            assistances:[
                
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
            },
                clearDropdown() {
                const app = this
                app.staSelected = []
                app.notSelected =[]
                
            },
            updateTable() {
                const app = this
                app.assistances.push({ id: app.assistances.length + 1,  date: app.assistance.date, statu: app.assistance.staSelected[0], note: app.assistance.notSelected[0], })
                app.clearDropdown()
                },
                deleteAssistance(id){
                this.assistances = this.assistances.filter(assistance => assistance.id != id);
                this.assistances = [... this.assistances];
            },
           
               confirmDelete(event, id) {
                this.$swal.fire({
                    title: '¿Estas seguro de querer borrar esta asistencia?',
                    text: "Si la borras, no podrás recuperarla",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Borrar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteAssistance(id)
                    this.$swal.fire(
                        'Listo',
                        'La asistencia ha sido eliminada',
                        'success'
                    )
                }
                })
            },
            },
              setup() {
            document.title = "IBBACH | Asistencias"
            
        
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
                    <span v-if="!assistance.notSelected.length">Notas</span>
                        <span v-else>{{ assistance.notSelected[0] }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                    <li v-for="note in notes" :key="note.id" class="dropdown-item"><button class="text-light list-click" @click="selectNot($event, note.note)">{{ note.note }}</button></li> 
                </ul>
                </div>
                <div class="m-4">
                    <button  type="button" class="d-inline-flex btn btn-primary btn-lg" @click="updateTable">Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                    <button type="button" class="d-inline-flex btn btn-warning btn-lg ms-3" @click="clearDrowdop">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
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
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
<tbody class="table-group-divider">
<tr v-for="assistance in assistances" :key="assistance.id">
<th scope="row">{{ assistance.id }}</th>
<td>{{ assistance.date }}</td>
<td>{{assistance.statu}}</td>
<td>{{assistance.note}}</td>
<td class="d-flex justify-content-center">
    <button type="button" class="btn btn-primary me-2" @click="selectAssistance($event, assistance.assistance, assistance.statu, assistance.note)">Modificar</button>
    <button type="button" class="btn btn-danger" @click="confirmDelete($event, assistance.id)">Eliminar</button>
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