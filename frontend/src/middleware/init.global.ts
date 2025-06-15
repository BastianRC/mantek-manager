import { useValidateUser } from "~/modules/auth/composables/useValidateUser"
import { useAuthStore } from "~/modules/auth/stores/auth"

export default defineNuxtRouteMiddleware(async () => {
    const store = useAuthStore()
    const token = useCookie('token')

    if (token.value) {
        const { error } = await useValidateUser().refetch()

        if (error) {
            console.warn('[MIDDLEWARE] Token inválido. Limpiando store.')

            store.clean()
            token.value = null
        }
    }
})