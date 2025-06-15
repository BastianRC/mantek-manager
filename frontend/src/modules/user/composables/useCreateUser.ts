import { useMutation, useQueryClient } from "@tanstack/vue-query"
import type { CreateUserPayload } from "../types/CreateUserPayload"
import { create } from "../services/UserService"
import { toast } from "vue-sonner"
import type { UserDetails } from "../types/UserDetails"
import type { User } from "../types/User"
import { toUser } from "../mapper/UserMapper"

export const useCreateUser = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: async (payload: CreateUserPayload) => create(payload),
        onSuccess: (response: UserDetails) => {
            toast.success(`Has añadido a ${response.first_name} ${response.last_name}`, {
                description: '¡Se ha creado al usuario correctamente!'
            })

            queryClient.setQueryData(['users'], (old: User[] = []) => {
                const newUser = toUser(response)
                return [...old, newUser]
            })

            queryClient.setQueryData(['user', response.id], response)
        },
        onError: (error) => {
            toast.error(`Ha ocurrido un error al intentar crear al usuario.`, {
                description: error.message
            })
        }
    })
}