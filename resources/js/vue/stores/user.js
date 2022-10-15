import { defineStore } from "pinia";

export const useUserStore = defineStore('user',{

    state: () => ({
        user: {
            id: '',
            img: '',
            name: '',
            last_name: '',
            code: '',
            role: '',
            group: '',
            status: '',
            applicant_id: ''
        }
    }),

    actions: {
        setUser(user) {
            this.user = {}
            this.user = user
        }
    }
})