import { useQuery } from "@tanstack/vue-query"
import type { WorkOrder } from "../types/WorkOrder"
import { getAll } from "../services/WorkOrderService"

export const useGetWorkOrdersList = () => {
    return useQuery<WorkOrder[]>({
        queryKey: ['work-orders'],
        queryFn: async () => getAll()
    })
}