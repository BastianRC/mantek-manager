import { useMutation, useQueryClient } from "@tanstack/vue-query"
import { destroy } from "../services/MachineService"
import { toast } from "vue-sonner"
import type { Machine } from "../types/Machine"

export const useDeleteMachine = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: async (id: number) => destroy(id),
        onSuccess: (_void, id) => {
            toast.success(`Máquina eliminada`, {
                description: '¡Se ha eliminado la máquina correctamente!'
            })

            queryClient.setQueryData(['machines'], (old: Machine[] = []) => {
                return old.filter(user => user.id !== id)
            })
        },
        onError: (error) => {
            toast.error(`Ha ocurrido un error al intentar eliminar la máquina.`, {
                description: error.message
            })
        }
    })
}