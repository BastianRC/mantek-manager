import type { WorkOrderPriority } from "./WorkOrderPriority"
import type { WorkOrderStatus } from "./WorkOrderStatus"

export const WORK_ORDER_STATUSES: WorkOrderStatus[] = [
  'not_started',
  'in_progress',
  'paused',
  'completed',
]

export const WORD_ORDER_PRIORITIES: WorkOrderPriority[] = [
  'low',
  'medium',
  'high',
  'critical',
]