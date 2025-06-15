import { useMutation, useQueryClient } from "@tanstack/vue-query"
import type { UpdateUserPayload } from "../types/UpdateUserPayload"
import { update } from "../services/UserService"
import { toast } from "vue-sonner"
import type { UserDetails } from "../types/UserDetails"
import type { User } from "../types/User"
import { toUser } from "../mapper/UserMapper"

export const useUpdateUser = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: async ({ id, payload }: { id: number, payload: UpdateUserPayload }) => update(id, payload),
        onSuccess: (response: UserDetails) => {
            toast.success(`Has modificado el usuario: ${response.first_name} ${response.last_name}`, {
                description: '¡Se ha modificado al usuario correctamente!'
            })

            queryClient.setQueryData(['users'], (old: User[] = []) =>
                old.map((u) =>
                    u.id === response.id ? toUser(response) : u
                )
            )

            queryClient.setQueryData(['user', response.id], response)
        },
        onError: (error) => {
            toast.error(`Ha ocurrido un error al intentar modificar al usuario.`, {
                description: error.message
            })
        }
    })
}