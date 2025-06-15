import type { WorkOrderMaterial } from "./WorkOrderMaterial";
import type { WorkOrderPriority } from "./WorkOrderPriority";
import type { WorkOrderStatus } from "./WorkOrderStatus";

export interface UpdateWorkOrderPayload {
    title?: string
    type?: string
    description?: string
    priority?: WorkOrderPriority
    status?: WorkOrderStatus,
    due_at?: string
    paused_at?: string
    started_at?: string
    completed_at?: string
    estimated_hours: number
    actual_hours?: number
    machine_id?: number
    assignee_id?: number
    location_id: number
    requested_by?: string
    approved_by?: string
    notes?: string
    materials?: Pick<WorkOrderMaterial, 'material_name' | 'quantity' | 'unit'>[]
}