import { useMutation, useQueryClient } from "@tanstack/vue-query"
import { destroy } from "../../services/MachineCategoryService"
import { toast } from "vue-sonner"
import type { MachineCategory } from "../../types/MachineCategory"

export const useDeleteMachineCategory = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: async (id: number) => destroy(id),
        onSuccess: (_void, id) => {
            toast.success(`Categoria de máquina eliminada`, {
                description: '¡Se ha eliminado la categoria de máquina correctamente!'
            })

            queryClient.setQueryData(['machines_categories'], (old: MachineCategory[] = []) => {
                return old.filter(machineCategory => machineCategory.id !== id)
            })
        },
        onError: (error) => {
            toast.error(`Ha ocurrido un error al intentar eliminar la categoria de máquina.`, {
                description: error.message
            })
        }
    })
}