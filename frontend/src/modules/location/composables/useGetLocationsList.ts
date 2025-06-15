import { useQuery } from "@tanstack/vue-query"
import type { Location } from "../types/Location"
import { getAll } from "../services/LocationService"

export const useGetLocationsList = () => {
    return useQuery<Location[]>({
        queryKey: ['locations'],
        queryFn: getAll,
        refetchOnWindowFocus: true,
        staleTime: 1000 * 60 * 2
    })
}