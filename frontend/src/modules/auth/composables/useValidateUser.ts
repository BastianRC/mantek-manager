import { useQuery } from "@tanstack/vue-query"
import { useAuthStore } from "../stores/auth"
import type { Auth } from "../types/Auth"
import { validate } from "../services/AuthService"

export function useValidateUser() {
    const store = useAuthStore()

    return useQuery<Auth>({
        queryKey: ['validate'],
        queryFn: async () => {
            const user = await validate()
            store.setUser(user)

            return user
        },

        retry: false
    })
}