import type { Auth } from "../types/Auth"

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null as Auth | null
  }),

  persist: {
    pick: ['user']
  },

  getters: {
    isAuthenticated: (state) => !!state.user
  },

  actions: {
    setUser(user: Auth) {
      this.user = user
    },

    clean() {
      this.user = null
    }
  }
})
