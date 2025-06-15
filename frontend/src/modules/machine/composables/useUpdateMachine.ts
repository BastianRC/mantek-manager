import { useMutation, useQueryClient } from "@tanstack/vue-query"
import type { UpdateMachinePayload } from "../types/UpdateMachinePayload"
import { update } from "../services/MachineService"
import { toast } from "vue-sonner"
import type { MachineDetails } from "../types/MachineDetails"

export const useUpdateMachine = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: ({ id, payload }: {id: number, payload: UpdateMachinePayload}) => update(id, payload),
        onSuccess: (response: MachineDetails) => {
            toast.success(`Has modificado la máquina ${response.name}`, {
                description: 'Se ha modificado la máquina correctamente.'
            })

            queryClient.invalidateQueries({ queryKey: ['machines'] })

            queryClient.setQueryData(['machine', response.id], response)
        },
        onError: (error) => {
            toast.error('Ha ocurrido un error al intentar modificar la máquina.', {
                description: error.message
            })
        }
    })
}