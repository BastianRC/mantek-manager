import { useMutation, useQueryClient } from "@tanstack/vue-query";
import { play } from "../services/WorkOrderService";
import { toast } from "vue-sonner";

export const usePlayWorkOrder = () => {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: (id: number) => play(id),
    onSuccess: (response) => {
      toast.success(
        `Has iniciado el parte de trabajo: ${response.order_number}`,
        {
          description: "Se ha iniciado el parte de trabajo correctamente.",
        }
      );

      queryClient.invalidateQueries({ queryKey: ["work-orders"] });

      queryClient.setQueryData(["work-order", response.id], response);
    },
    onError: (error) => {
      toast.error(
        "Ha ocurrido un error al intentar iniciar el parte de trabajo.",
        {
          description: error.message,
        }
      );
    },
  });
};
