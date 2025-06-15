import { useQuery } from "@tanstack/vue-query"
import type { LocationTypeOptions } from "../types/LocationTypeOptions"
import { getAllTypes } from "../services/LocationOptionsService"

export const useGetLocationTypesList = () => {
    return useQuery<LocationTypeOptions[]>({
        queryKey: ['locations_types'],
        queryFn: getAllTypes,
        refetchOnWindowFocus: true,
        staleTime: 1000 * 60 * 2
    })
}