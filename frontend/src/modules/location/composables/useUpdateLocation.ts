import { useMutation, useQueryClient } from "@tanstack/vue-query"
import type { UpdateLocationPayload } from "../types/UpdateLocationPayload"
import { update } from "../services/LocationService"
import { toast } from "vue-sonner"
import type { Location } from "../types/Location"
import type { LocationDetails } from "../types/LocationDetails"

export const useUpdateLocation = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: ({ id, payload }: {id: number, payload: UpdateLocationPayload}) => update(id, payload),
        onSuccess: (response: LocationDetails) => {
            toast.success(`Has modificado la ubicación ${response.name}`, {
                description: 'Se ha modificado la ubicación correctamente.'
            })

            queryClient.invalidateQueries({ queryKey: ['locations'] });

            queryClient.setQueryData(['location', response.id], response)
        },
        onError: (error) => {
            toast.error('Ha ocurrido un error al intentar modificar la ubicación.', {
                description: error.message
            })
        }
    })
}