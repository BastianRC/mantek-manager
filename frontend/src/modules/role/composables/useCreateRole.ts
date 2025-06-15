import { useMutation, useQueryClient } from "@tanstack/vue-query"
import type { CreateRolePayload } from "../types/CreateRolePayload"
import { create } from "../services/RoleService"
import { toast } from "vue-sonner"
import type { Role } from "../types/Role"
import type { RoleDetails } from "../types/RoleDetails"

export const useCreateRole = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: (payload: CreateRolePayload) => create(payload),
        onSuccess: (response: RoleDetails) => {
            toast.success(`Has añadido el rol ${response.name}`, {
                description: 'Se ha añadido el rol correctamente.'
            })

            queryClient.invalidateQueries({ queryKey: ['roles'] })
            
            queryClient.setQueryData(['role', response.id], response)
        },
        onError: (error) => {
            toast.error('Ha ocurrido un error al intentar crear el rol.', {
                description: error.message
            })
        }
    })
}