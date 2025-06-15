import { useMutation, useQueryClient } from "@tanstack/vue-query"
import { destroy } from "../services/RoleService"
import { toast } from "vue-sonner"
import type { Role } from "../types/Role"

export const useDeleteRole = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: async (id: number) => destroy(id),
        onSuccess: (_void, id) => {
            toast.success(`Rol eliminado`, {
                description: '¡Se ha eliminado el rol correctamente!'
            })

            queryClient.setQueryData(['roles'], (old: Role[] = []) => {
                return old.filter(user => user.id !== id)
            })
        },
        onError: (error) => {
            toast.error(`Ha ocurrido un error al intentar eliminar el rol.`, {
                description: error.message
            })
        }
    })
}