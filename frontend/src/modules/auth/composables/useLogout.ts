import { useMutation } from "@tanstack/vue-query"
import { useAuthStore } from "../stores/auth"
import { logout } from "../services/AuthService"
import { clearToken } from "../helpers/tokenStorage"
import { toast } from "vue-sonner"

export function useLogout() {

    const store = useAuthStore()
    const name = store.user?.name

    return useMutation({
        mutationFn: async () => {
            await logout()

            clearToken()
            store.clean()
        },
        onSuccess: () => {
            toast.success(`Adios ${name}.`, {
                description: '¡Has cerrado la sesión correctamente!'
            })

            navigateTo('/login')
        },

        onError: (error) => {
            toast.error(`No se ha podido cerrar la sesión.`, {
                description: `${error.message}`
            })
        }
    })
}