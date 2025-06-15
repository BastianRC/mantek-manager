import { useMutation, useQueryClient } from "@tanstack/vue-query"
import type { CreateMachineCategoryPayload } from "../../types/CreateMachineCategoryPayload"
import { create } from "../../services/MachineCategoryService"
import type { MachineCategory } from "../../types/MachineCategory"
import { toast } from "vue-sonner"

export const useCreateMachineCategory = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: (payload: CreateMachineCategoryPayload) => create(payload),
        onSuccess: (response: MachineCategory) => {
            toast.success(`Has añadido ${response.name}`, {
                description: 'Se ha añadido una nueva categoría de máquina correctamente.'
            })

            queryClient.invalidateQueries({ queryKey: ['machines_categories'] })
        },
        onError: (error) => {
            toast.error('Ha ocurrido un error al intentar crear la categoría de de máquina.', {
                description: error.message
            })
        }
    })
}