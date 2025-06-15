import { useQuery } from "@tanstack/vue-query"
import { getById } from "../services/WorkOrderService"
import type { WorkOrderDetails } from "../types/WorkOrderDetails"

export const useGetWorkOrderById = (id: Ref<number | null>) => {
    return useQuery<WorkOrderDetails>({
        queryKey: ['work-order', id],
        queryFn: async () => getById(id.value!),
        enabled: computed(() => id.value !== null),
        refetchOnWindowFocus: true
    })
}