<script>
import RegisterStudent from './RegisterStudent.vue'
import ManageStudents from './ManageStudents.vue'
import Register from './Register.vue';
export default {
    mounted() {
        document.title = "IBBACH | Gestión de cuentas";
    },
    data() {
        return {
            tabs: ["register-student", "manage-students", "register-account"],
            tab: "",
            defaultClass: "btn text-light m-1 mb-0",
            tabStyle1: "btn text-light m-1 mb-0",
            tabStyle2: "btn text-light m-1 mb-0",
            tabStyle3: "btn text-light m-1 mb-0",
        };
    },
    methods: {
        toggleComponents(tab) {
            switch (tab) {
                case 1:
                    this.tab = this.tabs.at(0);
                    this.tabStyle1 += " focused";
                    this.tabStyle2 = this.defaultClass;
                    this.tabStyle3 = this.defaultClass;
                    break;
                case 2:
                    this.tab = this.tabs.at(1);
                    this.tabStyle1 = this.defaultClass;
                    this.tabStyle2 += " focused";
                    this.tabStyle3 = this.defaultClass;
                    break;
                case 3:
                    this.tab = this.tabs.at(2);
                    this.tabStyle1 = this.defaultClass;
                    this.tabStyle2 = this.defaultClass;
                    this.tabStyle3 += " focused";
                    break;
                default:
                    break;
            }
        }
    },
    components: { RegisterStudent, ManageStudents, Register }
}
</script>
<template>
    <main>
        <div class="mb-4">
            <h1>Gestión de cuentas</h1>
            <h4>Selecciona una pestaña para ver sus opciones</h4>
        </div>
        <div class="d-block">
            <div class="d-flex tabs">
                <div :class="tabStyle1" @click="toggleComponents(1)">Registrar estudiante</div>
                <div :class="tabStyle2" @click="toggleComponents(2)">Administrar estudiantes</div>
                <div :class="tabStyle3" @click="toggleComponents(3)">Registrar una cuenta</div>
            </div>
            <div class="w-100 h-100 rounded component-container p-4">
                <RegisterStudent v-if="tab === tabs.at(0)"></RegisterStudent>
                <ManageStudents v-if="tab === tabs.at(1)"></ManageStudents>
                <Register v-if="tab === tabs.at(2)"></Register>
            </div>
        </div>
    </main>
</template>

<style lang="scss" scoped>
.tabs div {
    background-color: var(--dark);
}

.focused {
    background-color: var(--dark-alt) !important;
}

.component-container {
    background-color: var(--dark-alt);
}
</style>