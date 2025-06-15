import { useQuery } from "@tanstack/vue-query"
import type { User } from "../types/User"
import { getAll } from "../services/UserService"

export const useGetUsersList = () => {
    return useQuery<User[]>({
        queryKey: ['users'],
        queryFn: getAll,
        refetchOnWindowFocus: true,
        staleTime: 1000 * 60 * 2
    })
}