import { useMutation, useQueryClient } from "@tanstack/vue-query"
import { destroy } from "../services/LocationService"
import { toast } from "vue-sonner"
import type { Location } from "../types/Location"

export const useDeleteLocation = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: async (id: number) => destroy(id),
        onSuccess: (_void, id) => {
            toast.success(`Ubicación eliminada`, {
                description: '¡Se ha eliminado la ubicación correctamente!'
            })

            queryClient.setQueryData(['locations'], (old: Location[] = []) => {
                return old.filter(user => user.id !== id)
            })
        },
        onError: (error) => {
            toast.error(`Ha ocurrido un error al intentar eliminar la ubicación.`, {
                description: error.message
            })
        }
    })
}