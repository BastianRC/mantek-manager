import { useQuery } from "@tanstack/vue-query"
import type { Machine } from "../types/Machine"
import { getAll } from "../services/MachineService"

export const useGetMachinesList = () => {
    return useQuery<Machine[]>({
        queryKey: ['machines'],
        queryFn: getAll,
        refetchOnWindowFocus: true,
        staleTime: 1000 * 60 * 2
    })
}