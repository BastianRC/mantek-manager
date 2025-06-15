import { useQuery } from "@tanstack/vue-query"
import type { LocationSystemOptions } from "../types/LocationSystemOptions"
import { getAllSystems } from "../services/LocationOptionsService"

export const useGetLocationSystemsList = () => {
    return useQuery<LocationSystemOptions[]>({
        queryKey: ['locations_systems'],
        queryFn: getAllSystems,
        refetchOnWindowFocus: true,
        staleTime: 1000 * 60 * 2
    })
}