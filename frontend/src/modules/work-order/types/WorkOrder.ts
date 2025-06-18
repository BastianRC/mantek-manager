import type { WorkOrderPriority } from "./WorkOrderPriority";
import type { WorkOrderStatus } from "./WorkOrderStatus";
import type { Machine } from "~/modules/machine/types/Machine";
import type { Location } from "~/modules/location/types/Location";
import type { BasicUser } from "~/modules/user/types/BasicUser";
import type { WorkOrderType } from "./WorkOrderType";

export interface WorkOrder {
    id: number
    order_number: string
    title: string
    type: WorkOrderType
    description: string
    status: WorkOrderStatus
    priority: WorkOrderPriority
    due_at: Date
    estimated_hours: number
    actual_hours?: number
    is_started: boolean
    is_paused: boolean
    machine?: Machine
    assignee?: BasicUser
    location: Location
    created_at: Date
}