import { useMutation, useQueryClient } from "@tanstack/vue-query"
import type { CreateMachineTypePayload } from "../../types/CreateMachineTypePayload"
import { create } from "../../services/MachineTypeService"
import type { MachineType } from "../../types/MachineType"
import { toast } from "vue-sonner"

export const useCreateMachineType = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: (payload: CreateMachineTypePayload) => create(payload),
        onSuccess: (response: MachineType) => {
            toast.success(`Has añadido ${response.name}`, {
                description: 'Se ha añadido un nuevo tipo de máquina correctamente.'
            })

            queryClient.invalidateQueries({ queryKey: ['machines_types'] })
        },
        onError: (error) => {
            toast.error('Ha ocurrido un error al intentar crear el tipo de máquina.', {
                description: error.message
            })
        }
    })
}