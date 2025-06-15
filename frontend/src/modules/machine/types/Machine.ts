import type { BasicLocation } from "~/modules/location/types/Location"
import type { MachineCategory } from "./MachineCategory"
import type { MachineStatus } from "./MachineStatus"
import type { MachineType } from "./MachineType"

export interface Machine {
    id: number
    name: string
    type: MachineType
    category: MachineCategory 
    location: BasicLocation
    machine_model: string,
    serial_number: string,
    manufacturer: string,
    supplier: string,
    next_maintenance: Date | null
    status: MachineStatus
    created_at: Date | null
    updated_at: Date | null
}
