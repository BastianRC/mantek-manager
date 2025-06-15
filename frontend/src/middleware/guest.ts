import { useAuthStore } from "~/modules/auth/stores/auth"

export default defineNuxtRouteMiddleware(() => {
  const store = useAuthStore()

  if (store.isAuthenticated) {
    return navigateTo('/dashboard')
  }
})