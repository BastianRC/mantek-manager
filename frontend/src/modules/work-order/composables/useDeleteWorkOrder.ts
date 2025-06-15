import { useMutation, useQueryClient } from "@tanstack/vue-query"
import { destroy } from "../services/WorkOrderService"
import { toast } from "vue-sonner"
import type { WorkOrder } from "../types/WorkOrder"

export const useDeleteWorkOrder = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: async (id: number) => destroy(id),
        onSuccess: (response, id) => {
            toast.success(`Parte de trabajo eliminado`, {
                description: '¡Se ha eliminado el parte de trabajo correctamente!'
            })

            queryClient.setQueryData(['work-orders'], (old: WorkOrder[] = []) => {
                return old.filter(user => user.id !== id)
            })
        },
        onError: (error) => {
            toast.error(`Ha ocurrido un error al intentar eliminar el parte de trabajo.`, {
                description: error.message
            })
        }
    })
}