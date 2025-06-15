import type { MachineStatus } from './MachineStatus'

export interface UpdateMachinePayload {
    name?: string
    type_id?: number
    category_id?: number
    machine_model?: string
    serial_number?: string
    manufacturer?: string
    location_id?: number
    description?: string | null
    install_date?: string | null
    warranty_expiry?: string | null
    supplier?: string | null
    operating_temperature_min?: number | null
    operating_temperature_max?: number | null
    operating_pressure_max?: number | null
    power_consumption?: number | null
    voltage?: number | null
    frequency?: number | null
    weight?: number | null
    dimensions?: string | null
    maintenance_interval_days?: number | null
    status?: MachineStatus
    notes?: string | null
}
