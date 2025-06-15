import type { Machine } from "~/modules/machine/types/Machine";
import type { WorkOrderPriority } from "./WorkOrderPriority";
import type { WorkOrderStatus } from "./WorkOrderStatus";
import type { WorkOrderMaterial } from "./WorkOrderMaterial";
import type { BasicUser } from "~/modules/user/types/BasicUser";
import type { WorkOrderType } from "./WorkOrderType";
import type { Location } from "~/modules/location/types/Location";

export interface WorkOrderDetails {
    id: number
    order_number: string
    title: string
    type: WorkOrderType
    description: string
    status: WorkOrderStatus
    priority: WorkOrderPriority
    due_at: string
    paused_at?: string
    started_at?: string
    completed_at?: string
    estimated_hours: number
    actual_hours?: number
    machine?: Machine
    assignee?: BasicUser
    location: Location
    requested_by?: string
    approved_by?: string
    notes?: string
    materials?: WorkOrderMaterial[]
    created_by: BasicUser
    updated_by: BasicUser
    created_at: string
    updated_at: string
}