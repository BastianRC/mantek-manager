import type { BasicLocation } from "~/modules/location/types/Location"
import type { MachineType } from "./MachineType"
import type { UserRelation } from "~/modules/user/types/UserRelation"
import type { MachineStatus } from "./MachineStatus"
import type { WorkOrderRelation } from "~/modules/work-order/types/WorkOrderRelation"

export interface MachineDetails {
    id: number
    name: string
    type: MachineType
    category: MachineType
    machine_model: string
    serial_number: string
    manufacturer: string
    location: BasicLocation
    work_orders: WorkOrderRelation[]
    description: string | null
    install_date: string | null
    warranty_expiry: string | null
    supplier: string | null
    operating_temperature_min: number | null
    operating_temperature_max: number | null
    operating_pressure_max: number | null
    power_consumption: number | null
    voltage: number | null
    frequency: number | null
    weight: number | null
    dimensions: string | null
    maintenance_interval_days: number | null
    status: MachineStatus
    notes: string | null
    created_by: UserRelation
    updated_by: UserRelation
    created_at: Date
    updated_at: Date
}