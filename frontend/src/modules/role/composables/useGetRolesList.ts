import { useQuery } from "@tanstack/vue-query"
import type { Role } from "../types/Role"
import { getAll } from "../services/RoleService"

export const useGetRolesList = () => {
    return useQuery<Role[]>({
        queryKey: ['roles'],
        queryFn: getAll,
        refetchOnWindowFocus: true,
        staleTime: 1000 * 60 * 2
    })
}