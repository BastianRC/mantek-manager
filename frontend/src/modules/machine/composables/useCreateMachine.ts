import { useMutation, useQueryClient } from "@tanstack/vue-query"
import type { CreateMachinePayload } from "../types/CreateMachinePayload"
import { create } from "../services/MachineService"
import { toast } from "vue-sonner"
import type { MachineDetails } from "../types/MachineDetails"


export const useCreateMachine = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: (payload: CreateMachinePayload) => create(payload),
        onSuccess: (response: MachineDetails) => {
            toast.success(`Has añadido la máquina ${response.name}`, {
                description: 'Se ha añadido la máquina correctamente.'
            })

            queryClient.invalidateQueries({ queryKey: ['machines'] })

            queryClient.setQueryData(['machine', response.id], response)
        },
        onError: (error) => {
            toast.error('Ha ocurrido un error al intentar crear la máquina.', {
                description: error.message
            })
        }
    })
}