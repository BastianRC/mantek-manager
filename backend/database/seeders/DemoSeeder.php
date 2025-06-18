<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Src\Chronology\Infrastructure\Persistence\Eloquent\Models\ChronologyEloquent;
use Src\Location\Infrastructure\Persistence\Eloquent\Models\LocationEloquent;
use Src\Machine\Infrastructure\Persistence\Eloquent\Models\MachineCategoryEloquent;
use Src\Machine\Infrastructure\Persistence\Eloquent\Models\MachineEloquent;
use Src\Machine\Infrastructure\Persistence\Eloquent\Models\MachineTypeEloquent;
use Src\Role\Infrastructure\Persistence\Eloquent\Models\PermissionEloquent;
use Src\Role\Infrastructure\Persistence\Eloquent\Models\RoleEloquent;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;
use Src\WorkOrder\Infrastructure\Persistence\Eloquent\Models\WorkOrderEloquent;
use Src\WorkOrder\Infrastructure\Persistence\Eloquent\Models\WorkOrderMaterialEloquent;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // 1. Crear roles
            $superAdmin = RoleEloquent::firstOrCreate([
                'name' => 'Super Admin',
                'guard_name' => 'sanctum',
                'description' => 'Acceso total al sistema'
            ]);
            $supervisor = RoleEloquent::firstOrCreate([
                'name' => 'Supervisor',
                'guard_name' => 'sanctum',
                'description' => 'Gestiona órdenes y ubicaciones asignadas'
            ]);
            $technician = RoleEloquent::firstOrCreate([
                'name' => 'Técnico',
                'guard_name' => 'sanctum',
                'description' => 'Ejecuta tareas asignadas en órdenes de trabajo'
            ]);

            $allPermissions = PermissionEloquent::all();
            $superAdmin->syncPermissions($allPermissions);

            $supervisor->syncPermissions(PermissionEloquent::whereIn('name', [
                'View all users',
                'View all machines',
                'View all work orders',
                'Update work order'
            ])->get());

            $technician->syncPermissions(PermissionEloquent::whereIn('name', [
                'View all machines',
                'View all work orders',
                'Update work order'
            ])->get());

            // 2. Crear usuarios
            $admin = UserEloquent::create([
                'first_name' => 'Diego',
                'last_name' => 'Ruiz',
                'email' => 'admin@mantek.app',
                'phone' => '+34600000001',
                'password' => Hash::make('Password123!'),
                'department' => 'Sistemas',
                'notes' => 'Usuario con acceso completo',
                'is_active' => true,
            ]);
            $admin->assignRole($superAdmin);

            $supervisorUser = UserEloquent::create([
                'first_name' => 'Sonia',
                'last_name' => 'López',
                'email' => 'supervisor@mantek.app',
                'phone' => '+34600000002',
                'password' => Hash::make('Password123!'),
                'department' => 'Administracion',
                'notes' => null,
                'is_active' => true,
            ]);
            $supervisorUser->assignRole($supervisor);

            $tech1 = UserEloquent::create([
                'first_name' => 'Tomás',
                'last_name' => 'García',
                'email' => 'tecnico1@mantek.app',
                'phone' => '+34600000003',
                'password' => Hash::make('Password123!'),
                'department' => 'Mantenimiento',
                'notes' => null,
                'is_active' => true,
            ]);
            $tech1->assignRole($technician);

            $tech2 = UserEloquent::create([
                'first_name' => 'Lucía',
                'last_name' => 'Fernández',
                'email' => 'tecnico2@mantek.app',
                'phone' => '+34600000004',
                'password' => Hash::make('Password123!'),
                'department' => 'Mantenimiento',
                'notes' => null,
                'is_active' => true,
            ]);
            $tech2->assignRole($technician);

            // 3. Crear tipos y categorías de máquina
            $type1 = MachineTypeEloquent::create(['name' => 'Climatizadora', 'created_by' => $admin->id]);
            $type2 = MachineTypeEloquent::create(['name' => 'Compresor', 'created_by' => $admin->id]);

            $cat1 = MachineCategoryEloquent::create(['name' => 'HVAC', 'created_by' => $admin->id]);
            $cat2 = MachineCategoryEloquent::create(['name' => 'Neumática', 'created_by' => $admin->id]);

            // 4. Crear ubicaciones
            $locations = collect([
                LocationEloquent::create([
                    'name' => 'Fábrica Norte',
                    'type' => 'building',
                    'description' => 'Ubicación principal',
                    'address' => 'Calle Industria 1',
                    'floor' => 0,
                    'latitude' => 37.987,
                    'longitude' => -1.123,
                    'manager_id' => $supervisorUser->id,
                    'emergency_contact' => 'Guardia Norte',
                    'emergency_phone' => '610000000',
                    'created_by' => $admin->id,
                ]),
                LocationEloquent::create([
                    'name' => 'Almacén Sur',
                    'type' => 'warehouse',
                    'description' => 'Depósito secundario',
                    'address' => 'Camino Viejo 22',
                    'floor' => null,
                    'latitude' => 37.123,
                    'longitude' => -1.345,
                    'manager_id' => $supervisorUser->id,
                    'emergency_contact' => 'Guardia Sur',
                    'emergency_phone' => '620000000',
                    'created_by' => $admin->id,
                ])
            ]);



            // 5. Crear máquinas
            $machines = collect([
                MachineEloquent::create([
                    'name' => 'Compresor Línea A',
                    'type_id' => $type2->id,
                    'category_id' => $cat2->id,
                    'machine_model' => 'CPX-200',
                    'serial_number' => 'CMP001',
                    'manufacturer' => 'AirMax',
                    'location_id' => $locations[0]->id,
                    'status' => 'operational',
                    'created_by' => $admin->id,
                ]),
                MachineEloquent::create([
                    'name' => 'Unidad HVAC Principal',
                    'type_id' => $type1->id,
                    'category_id' => $cat1->id,
                    'machine_model' => 'HVAC-X100',
                    'serial_number' => 'HVAC1001',
                    'manufacturer' => 'CoolTech',
                    'location_id' => $locations[0]->id,
                    'status' => 'operational',
                    'created_by' => $admin->id,
                ]),
                MachineEloquent::create([
                    'name' => 'Extractor Secundario',
                    'type_id' => $type1->id,
                    'category_id' => $cat1->id,
                    'machine_model' => 'EXTR-55',
                    'serial_number' => 'EXT055',
                    'manufacturer' => 'VentCorp',
                    'location_id' => $locations[1]->id,
                    'status' => 'maintenance',
                    'created_by' => $admin->id,
                ]),
                MachineEloquent::create([
                    'name' => 'Compresor Línea B',
                    'type_id' => $type2->id,
                    'category_id' => $cat2->id,
                    'machine_model' => 'CPX-201',
                    'serial_number' => 'CMP002',
                    'manufacturer' => 'AirMax',
                    'location_id' => $locations[1]->id,
                    'status' => 'warning',
                    'created_by' => $admin->id,
                ]),
            ]);

            // 6. Crear órdenes de trabajo
            $orders = collect([
                WorkOrderEloquent::create([
                    'order_number' => 'WO-250001',
                    'title' => 'Mantenimiento general HVAC',
                    'type' => 'preventive',
                    'description' => 'Limpieza de filtros y revisión de presión',
                    'priority' => 'medium',
                    'status' => 'in_progress',
                    'assignee_id' => $tech1->id,
                    'machine_id' => $machines[1]->id,
                    'location_id' => $locations[0]->id,
                    'due_at' => now()->addDays(2),
                    'started_at' => now()->subHours(3),
                    'resumed_at' => now()->subHours(1),
                    'estimated_hours' => 2.5,
                    'actual_hours' => 2.0,
                    'created_by' => $supervisorUser->id,
                ]),
                WorkOrderEloquent::create([
                    'order_number' => 'WO-250002',
                    'title' => 'Revisión compresor B',
                    'type' => 'corrective',
                    'description' => 'Detectado ruido inusual en funcionamiento',
                    'priority' => 'high',
                    'status' => 'assigned',
                    'assignee_id' => $tech1->id,
                    'machine_id' => $machines[3]->id,
                    'location_id' => $locations[1]->id,
                    'due_at' => now()->addDays(1),
                    'estimated_hours' => 3.0,
                    'created_by' => $supervisorUser->id,
                ]),
                WorkOrderEloquent::create([
                    'order_number' => 'WO-250003',
                    'title' => 'Sustitución extractor',
                    'type' => 'improvement',
                    'description' => 'Cambio de unidad extractora por modelo actualizado',
                    'priority' => 'low',
                    'status' => 'pending',
                    'machine_id' => $machines[2]->id,
                    'location_id' => $locations[1]->id,
                    'due_at' => now()->addDays(5),
                    'estimated_hours' => 4.0,
                    'created_by' => $supervisorUser->id,
                ]),
                WorkOrderEloquent::create([
                    'order_number' => 'WO-250004',
                    'title' => 'Verificación compresor A',
                    'type' => 'inspection',
                    'description' => 'Inspección periódica del compresor principal',
                    'priority' => 'medium',
                    'status' => 'completed',
                    'assignee_id' => $tech2->id,
                    'machine_id' => $machines[0]->id,
                    'location_id' => $locations[0]->id,
                    'due_at' => now()->subDays(1),
                    'started_at' => now()->subDays(2)->setTime(9, 0),
                    'resumed_at' => now()->subDays(2)->setTime(10, 0),
                    'completed_at' => now()->subDays(1)->setTime(12, 0),
                    'estimated_hours' => 1.5,
                    'actual_hours' => 2.5,
                    'created_by' => $supervisorUser->id,
                ]),
            ]);

            // 7. Añadir materiales a las órdenes
            foreach ($orders as $order) { {
                    WorkOrderMaterialEloquent::create([
                        'work_order_id' => $order->id,
                        'material_name' => 'Filtro HEPA',
                        'quantity' => 1,
                        'unit' => 'unit',
                        'created_by' => $order->assignee_id,
                    ]);

                    WorkOrderMaterialEloquent::create([
                        'work_order_id' => $order->id,
                        'material_name' => 'Lubricante técnico',
                        'quantity' => 0.5,
                        'unit' => 'l',
                        'created_by' => $order->assignee_id,
                    ]);
                }
            }

            // 8. Cronología por entidad creada
            $chronologies = [
                // Usuarios
                ['user_id' => $admin->id, 'target_type' => 'user', 'target_id' => $tech1->id, 'event_type' => 'created', 'description' => 'Técnico creado', 'meta' => ['email' => $tech1->email]],
                ['user_id' => $admin->id, 'target_type' => 'user', 'target_id' => $tech2->id, 'event_type' => 'created', 'description' => 'Técnica creada', 'meta' => ['email' => $tech2->email]],

                // Ubicaciones
                ['user_id' => $admin->id, 'target_type' => 'location', 'target_id' => $locations[0]->id, 'event_type' => 'created', 'description' => 'Ubicación Fábrica Norte registrada', 'meta' => ['type' => $locations[0]->type]],
                ['user_id' => $admin->id, 'target_type' => 'location', 'target_id' => $locations[1]->id, 'event_type' => 'created', 'description' => 'Ubicación Almacén Sur registrada', 'meta' => ['type' => $locations[1]->type]],

                // Máquinas
                ['user_id' => $admin->id, 'target_type' => 'machine', 'target_id' => $machines[0]->id, 'event_type' => 'created', 'description' => 'Máquina creada', 'meta' => ['name' => $machines[0]->name]],
                ['user_id' => $admin->id, 'target_type' => 'machine', 'target_id' => $machines[1]->id, 'event_type' => 'created', 'description' => 'Máquina creada', 'meta' => ['name' => $machines[1]->name]],

                // Órdenes de trabajo
                ['user_id' => $supervisorUser->id, 'target_type' => 'work_order', 'target_id' => $orders[0]->id, 'event_type' => 'assigned', 'description' => 'Orden asignada al técnico', 'meta' => ['assigned_to' => $tech1->email]],
                ['user_id' => $tech1->id, 'target_type' => 'work_order', 'target_id' => $orders[0]->id, 'event_type' => 'started', 'description' => 'Orden iniciada', 'meta' => []],
                ['user_id' => $tech2->id, 'target_type' => 'work_order', 'target_id' => $orders[3]->id, 'event_type' => 'completed', 'description' => 'Orden finalizada', 'meta' => []],
            ];

            foreach ($chronologies as $entry) { {
                    ChronologyEloquent::create([
                        'target_type' => $entry['target_type'],
                        'target_id' => $entry['target_id'],
                        'user_id' => $entry['user_id'],
                        'event_type' => $entry['event_type'],
                        'description' => $entry['description'],
                        'meta' => $entry['meta'],
                        'created_at' => now(),
                    ]);
                }
            }
        });
    }
}
