import { useQuery } from "@tanstack/vue-query"
import { getById } from "../services/UserService"
import type { UserDetails } from "../types/UserDetails"

export const useGetUserById = (id: Ref<number | null>) => {
    return useQuery<UserDetails>({
        queryKey: ['user', id],
        queryFn: async () => getById(id.value!),
        enabled: computed(() => id.value !== null),
        refetchOnWindowFocus: true,
    })
}