import { useMutation, useQueryClient } from "@tanstack/vue-query";
import { toast } from "vue-sonner";
import { pause } from "../services/WorkOrderService";

export const usePauseWorkOrder = () => {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: (id: number) => pause(id),
    onSuccess: (response) => {
      toast.success(
        `Has pausado el parte de trabajo: ${response.order_number}`,
        {
          description: "Se ha pausado el parte de trabajo correctamente.",
        }
      );

      queryClient.invalidateQueries({ queryKey: ["work-orders"] });

      queryClient.setQueryData(["work-order", response.id], response);
    },
    onError: (error) => {
      toast.error(
        "Ha ocurrido un error al intentar pausar el parte de trabajo.",
        {
          description: error.message,
        }
      );
    },
  });
};
