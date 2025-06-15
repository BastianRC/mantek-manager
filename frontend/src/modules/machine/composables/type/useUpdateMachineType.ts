import { useMutation, useQueryClient } from "@tanstack/vue-query"
import type { UpdateMachineTypePayload } from "../../types/UpdateMachineTypePayload"
import { update } from "../../services/MachineTypeService"
import type { MachineCategory } from "../../types/MachineCategory"
import { toast } from "vue-sonner"
import type { MachineType } from "../../types/MachineType"

export const useUpdateMachineType = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: ({ id, payload }: { id: number, payload: UpdateMachineTypePayload }) => update(id, payload),
        onSuccess: (response: MachineType) => {
            toast.success(`Has modificado ${response.name}`, {
                description: 'Se ha modificado el tipo de máquina correctamente.'
            })

            queryClient.invalidateQueries({ queryKey: ['machines_types'] })

        },
        onError: (error) => {
            toast.error('Ha ocurrido un error al intentar modificar el tipo de máquina.', {
                description: error.message
            })
        }
    })
}