import { useMutation, useQueryClient } from "@tanstack/vue-query"
import type { UpdateMachineCategoryPayload } from "../../types/UpdateMachineCategoryPayload"
import { update } from "../../services/MachineCategoryService"
import type { MachineCategory } from "../../types/MachineCategory"
import { toast } from "vue-sonner"

export const useUpdateMachineCategory = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: ({ id, payload }: { id: number, payload: UpdateMachineCategoryPayload }) => update(id, payload),
        onSuccess: (response: MachineCategory) => {
            toast.success(`Has modificado ${response.name}`, {
                description: 'Se ha modificado el tipo de máquina correctamente.'
            })

            queryClient.invalidateQueries({ queryKey: ['machines_categories'] })

        },
        onError: (error) => {
            toast.error('Ha ocurrido un error al intentar modificar el tipo de máquina.', {
                description: error.message
            })
        }
    })
}