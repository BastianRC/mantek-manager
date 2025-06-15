import { useQuery } from "@tanstack/vue-query"
import type { MachineCategory } from "../../types/MachineCategory"
import { getAll } from "../../services/MachineCategoryService"

export const useGetMachineCategoriesList = () => {
    return useQuery<MachineCategory[]>({
        queryKey: ['machines_categories'],
        queryFn: getAll,
        refetchOnWindowFocus: true,
        staleTime: 1000 * 60 * 2
    })
}