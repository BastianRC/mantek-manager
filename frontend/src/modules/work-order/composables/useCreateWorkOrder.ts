import { useMutation, useQueryClient } from "@tanstack/vue-query"
import type { CreateWorkOrderPayload } from "../types/CreateWorkOrderPayload"
import { create } from "../services/WorkOrderService"
import { toast } from "vue-sonner"
import type { WorkOrder } from "../types/WorkOrder"

export const useCreateWorkOrder = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: (payload: CreateWorkOrderPayload) => create(payload),
        onSuccess: (response) => {
            toast.success(`Has añadido el parte de trabajo: ${response.order_number}`, {
                description: 'Se ha añadido el parte de trabajo correctamente.'
            })

            queryClient.invalidateQueries({ queryKey: ['work-orders'] })

            queryClient.setQueryData(['work-order', response.id], response)
        },
        onError: (error) => {
            toast.error('Ha ocurrido un error al intentar crear el parte de trabajo.', {
                description: error.message
            })
        }
    })
}