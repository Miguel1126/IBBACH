import { defineStore } from "pinia";

export const useUserStore = defineStore('user',{

    state: () => ({
        user: {
            id: '',
            name: '',
            last_name: '',
            code: '',
            role: '',
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