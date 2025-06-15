import { useMutation, useQueryClient } from "@tanstack/vue-query"
import type { UpdateRolePayload } from "../types/UpdateRolePayload"
import { update } from "../services/RoleService"
import { toast } from "vue-sonner"
import type { Role } from "../types/Role"
import type { RoleDetails } from "../types/RoleDetails"

export const useUpdateRole = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: ({ id, payload }: {id: number, payload: UpdateRolePayload}) => update(id, payload),
        onSuccess: (response: RoleDetails) => {
            toast.success(`Has modificado el rol ${response.name}`, {
                description: 'Se ha modificado el rol correctamente.'
            })

            queryClient.setQueryData(['roles'], (old: Role[] = []) =>
                old.map(u => u.id === response.id ? response : u)
            )

            queryClient.setQueryData(['role', response.id], response)
        },
        onError: (error) => {
            toast.error('Ha ocurrido un error al intentar modificar el rol.', {
                description: error.message
            })
        }
    })
}