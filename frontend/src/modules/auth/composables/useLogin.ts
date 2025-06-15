import { useMutation } from "@tanstack/vue-query"
import { useAuthStore } from "../stores/auth"
import type { LoginPayload } from "../types/LoginPayload"
import { login } from "../services/AuthService"
import { setToken } from "../helpers/tokenStorage"
import { toast } from "vue-sonner"

export function useLogin() {
    
    const store = useAuthStore()

    return useMutation({
        mutationFn: async (payload: LoginPayload) => {
            const session = await login(payload)

            setToken(session.token)
            store.setUser(session.user)
        },
        onSuccess: () => {
            toast.success(`Bienvenido ${store.user?.name}.`, {
                description: '¡Has iniciado sesión correctamente!'
            })

            navigateTo('/dashboard')
        },

        onError: (error) => {
            toast.error(`No se ha podido iniciar sesión.`, {
                description: `${error.message}`
            })
        }
    })
}