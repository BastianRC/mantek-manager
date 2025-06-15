import { useMutation, useQueryClient } from "@tanstack/vue-query"
import { destroy } from "../../services/MachineTypeService"
import { toast } from "vue-sonner"
import type { MachineType } from "../../types/MachineType"

export const useDeleteMachineType = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: async (id: number) => destroy(id),
        onSuccess: (_void, id) => {
            toast.success(`Tipo de máquina eliminada`, {
                description: '¡Se ha eliminado el tipo de máquina correctamente!'
            })

            queryClient.setQueryData(['machines_types'], (old: MachineType[] = []) => {
                return old.filter(machineTypes => machineTypes.id !== id)
            })
        },
        onError: (error) => {
            toast.error(`Ha ocurrido un error al intentar eliminar el tipo máquina.`, {
                description: error.message
            })
        }
    })
}