import { useMutation, useQueryClient } from "@tanstack/vue-query"
import { destroy } from "../services/UserService"
import { toast } from "vue-sonner"
import type { User } from "../types/User"

export const useDeleteUser = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: async (id: number) => destroy(id),
        onSuccess: (_void, id) => {
            toast.success(`Usuario eliminado`, {
                description: '¡Se ha eliminado al usuario correctamente!'
            })

            queryClient.setQueryData(['users'], (old: User[] = []) => {
                return old.filter(user => user.id !== id)
            })
        },
        onError: (error) => {
            toast.error(`Ha ocurrido un error al intentar eliminar al usuario.`, {
                description: error.message
            })
        }
    })
}