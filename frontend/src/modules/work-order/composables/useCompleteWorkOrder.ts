import { useMutation, useQueryClient } from "@tanstack/vue-query";
import { complete } from "../services/WorkOrderService";
import { toast } from "vue-sonner";

export const useCompleteWorkOrder = () => {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: (id: number) => complete(id),
    onSuccess: (response) => {
      toast.success(
        `Has completado el parte de trabajo: ${response.order_number}`,
        {
          description: "Se ha completado el parte de trabajo correctamente.",
        }
      );

      queryClient.invalidateQueries({ queryKey: ["work-orders"] });

      queryClient.setQueryData(["work-order", response.id], response);
    },
    onError: (error) => {
      toast.error(
        "Ha ocurrido un error al intentar completar el parte de trabajo.",
        {
          description: error.message,
        }
      );
    },
  });
};
