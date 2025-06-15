import { useMutation, useQueryClient } from "@tanstack/vue-query"
import type { UpdateWorkOrderPayload } from "../types/UpdateWorkOrderPayload"
import { update } from "../services/WorkOrderService"
import { toast } from "vue-sonner"
import type { WorkOrder } from "../types/WorkOrder"

export const useUpdateWorkOrder = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: ({ id, payload }: {id: number, payload: UpdateWorkOrderPayload}) => update(id, payload),
        onSuccess: (response) => {
            toast.success(`Has modificado el parte de trabajo: ${response.order_number}`, {
                description: 'Se ha modificado el parte de trabajo correctamente.'
            })

            queryClient.invalidateQueries({ queryKey: ['work-orders'] })

            queryClient.setQueryData(['work-order', response.id], response)
        },
        onError: (error) => {
            toast.error('Ha ocurrido un error al intentar modificar el parte de trabajo.', {
                description: error.message
            })
        }
    })
}