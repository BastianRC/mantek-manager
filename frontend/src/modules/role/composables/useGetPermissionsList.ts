import { useQuery } from "@tanstack/vue-query"
import type { Permission } from "../types/Permission"
import { getAll } from "../services/PermissionService"

export const useGetPermissionsList = () => {
    return useQuery<Permission[]>({
        queryKey: ['permissions'],
        queryFn: async () => getAll()
    })
}