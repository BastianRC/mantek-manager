import { useQuery } from "@tanstack/vue-query"
import { getById } from "../services/RoleService"
import type { RoleDetails } from "../types/RoleDetails"

export const useGetRoleById = (id: Ref<number | null>) => {
    return useQuery<RoleDetails>({
        queryKey: ['role', id],
        queryFn: async () => getById(id.value!),
        enabled: computed(() => id.value !== null),
        refetchOnWindowFocus: true
    })
}