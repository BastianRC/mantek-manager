import type { WorkOrderDetails } from "../types/WorkOrderDetails";

export const getWorkOrderActionMeta = (order: WorkOrderDetails) => {
  const isAssigned = order.status === "assigned";
  const isInProgress = order.status === "in_progress";
  const isPaused = order.is_paused;
  const isStarted = order.is_started;

  return {
    canStartOrResume: isAssigned || (isInProgress && isPaused),
    canPause: isInProgress && isStarted && !isPaused,
    canComplete: isInProgress && isStarted
  };
};
