<template>
    <form @submit="onSubmit" class="space-y-6">
        <AlertMessage v-if="locations.length === 0" title="¡No hay ubicaciones creadas!"
            message="Faltan recursos que hacen imposible crear una nueva máquina." :icon="AlertCircle"
            variant="destructive" />
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Cpu class="size-5" />
                            Información Básica
                        </CardTitle>
                        <CardDescription>Datos principales de la máquina</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="name">
                                <FormItem v-auto-animate>
                                    <FormLabel>Nombre de la Máquina *</FormLabel>
                                    <FormControl>
                                        <Input type="text" placeholder="Compresor Principal A"
                                            v-bind="componentField" />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <FormField v-slot="{ componentField }" name="type_id">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Tipo *</FormLabel>
                                        <div class="flex items-center gap-2">
                                            <Select v-bind="componentField">
                                                <FormControl>
                                                    <SelectTrigger>
                                                        <SelectValue placeholder="Seleccionar tipo" />
                                                    </SelectTrigger>
                                                </FormControl>
                                                <SelectContent>
                                                    <SelectGroup>
                                                        <SelectItem v-for="(type, index) in types" :key="index"
                                                            :value="type.id">
                                                            {{ type.name }}
                                                        </SelectItem>
                                                    </SelectGroup>
                                                </SelectContent>
                                            </Select>

                                            <CreateMachineTypeForm />
                                        </div>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>

                            <div class="space-y-2">
                                <FormField v-slot="{ componentField }" name="category_id">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Categoría *</FormLabel>
                                        <div class="flex items-center gap-2">
                                            <Select v-bind="componentField">
                                                <FormControl>
                                                    <SelectTrigger>
                                                        <SelectValue placeholder="Seleccionar categoría" />
                                                    </SelectTrigger>
                                                </FormControl>
                                                <SelectContent>
                                                    <SelectGroup>
                                                        <SelectItem v-for="(category) in categories" :key="category.id"
                                                            :value="category.id">
                                                            {{ category.name }}
                                                        </SelectItem>
                                                    </SelectGroup>
                                                </SelectContent>
                                            </Select>

                                            <CreateMachineCategoryForm />
                                        </div>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <FormField v-slot="{ componentField }" name="machine_model">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Modelo *</FormLabel>
                                        <div class="flex items-center gap-2">
                                            <FormControl v-if="isNewModel">
                                                <Input type="text" placeholder="Introducir nuevo modelo"
                                                    v-bind="componentField" />
                                            </FormControl>

                                            <Combobox v-else by="label" class="w-full">
                                                <FormControl>
                                                    <ComboboxAnchor>
                                                        <div class="relative w-full items-center">
                                                            <ComboboxInput :display-value="(val) => val?.label ?? ''"
                                                                placeholder="Seleccionar modelo" />
                                                            <ComboboxTrigger
                                                                class="absolute end-0 inset-y-0 flex items-center justify-center opacity-50">
                                                                <ChevronsUpDown class="size-4 text-muted-foreground" />
                                                            </ComboboxTrigger>
                                                        </div>
                                                    </ComboboxAnchor>
                                                </FormControl>

                                                <ComboboxList>
                                                    <ComboboxEmpty>
                                                        Sin resultados.
                                                    </ComboboxEmpty>

                                                    <ComboboxGroup>
                                                        <ComboboxItem v-for="model in models" :key="model.value"
                                                            :value="model" @select="() => {
                                                                setFieldValue('machine_model', model.value)
                                                            }">
                                                            {{ model.label }}

                                                            <ComboboxItemIndicator>
                                                                <Check :class="cn('ml-auto size-4')" />
                                                            </ComboboxItemIndicator>
                                                        </ComboboxItem>
                                                    </ComboboxGroup>
                                                </ComboboxList>
                                            </Combobox>

                                            <Button type="button" variant="outline"
                                                @click="isNewModel ? isNewModel = false : isNewModel = true; setFieldValue('machine_model', '')">
                                                <TextCursorInput v-if="!isNewModel" />
                                                <TextSearch v-else />
                                            </Button>
                                        </div>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>

                            <div class="space-y-2">
                                <FormField v-slot="{ componentField }" name="serial_number">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Número de Serie *</FormLabel>
                                        <FormControl>
                                            <Input type="text" placeholder="AC2023001" v-bind="componentField" />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="manufacturer">
                                <FormItem v-auto-animate>
                                    <FormLabel>Fabricante *</FormLabel>
                                    <div class="flex items-center gap-2">
                                        <FormControl v-if="isNewManufacturer">
                                            <Input type="text" placeholder="Introducir nuevo fabricante"
                                                v-bind="componentField" />
                                        </FormControl>


                                        <Combobox v-else by="label" class="w-full">
                                            <FormControl>
                                                <ComboboxAnchor>
                                                    <div class="relative w-full items-center">
                                                        <ComboboxInput :display-value="(val) => val"
                                                            placeholder="Seleccionar fabricante" />
                                                        <ComboboxTrigger
                                                            class="absolute end-0 inset-y-0 flex items-center justify-center opacity-50">
                                                            <ChevronsUpDown class="size-4 text-muted-foreground" />
                                                        </ComboboxTrigger>
                                                    </div>
                                                </ComboboxAnchor>
                                            </FormControl>

                                            <ComboboxList>
                                                <ComboboxEmpty>
                                                    Sin resultados.
                                                </ComboboxEmpty>

                                                <ComboboxGroup>
                                                    <ComboboxItem v-for="manufacturer in manufacturers"
                                                        :key="manufacturer.value" :value="manufacturer.value" @select="() => {
                                                            setFieldValue('manufacturer', manufacturer.value)
                                                        }">
                                                        {{ manufacturer.label }}

                                                        <ComboboxItemIndicator>
                                                            <Check :class="cn('ml-auto size-4')" />
                                                        </ComboboxItemIndicator>
                                                    </ComboboxItem>
                                                </ComboboxGroup>
                                            </ComboboxList>
                                        </Combobox>

                                        <Button type="button" variant="outline"
                                            @click="isNewManufacturer ? isNewManufacturer = false : isNewManufacturer = true; setFieldValue('manufacturer', '')">
                                            <TextCursorInput v-if="!isNewManufacturer" />
                                            <TextSearch v-else />
                                        </Button>
                                    </div>

                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="description">
                                <FormItem v-auto-animate>
                                    <FormLabel>Descripción</FormLabel>
                                    <FormControl>
                                        <Textarea placeholder="Descripción detallada de la máquina..."
                                            v-bind="componentField" />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Settings class="h-5 w-5" />
                            Especificaciones Técnicas
                        </CardTitle>
                        <CardDescription>Parámetros técnicos y operativos</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <FormField v-slot="{ componentField }" name="status">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Estado *</FormLabel>
                                        <Select v-bind="componentField">
                                            <FormControl>
                                                <SelectTrigger>
                                                    <SelectValue placeholder="Seleccionar estado" />
                                                </SelectTrigger>
                                            </FormControl>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectItem v-for="(state, index) in states" :key="index"
                                                        :value="state.value">
                                                        {{ state.label }}
                                                    </SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>

                            <div class="space-y-2">
                                <FormField v-slot="{ value, handleChange }" name="maintenance_interval_days">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Intervalo de Mantenimiento</FormLabel>
                                        <FormControl>
                                            <NumberField :default-value="0" :min="0" locale="es"
                                                :format-options="{ style: 'unit', unit: 'day', unitDisplay: 'long' }"
                                                :model-value="value" @update:model-value="handleChange">
                                                <NumberFieldContent>
                                                    <NumberFieldDecrement />
                                                    <NumberFieldInput />
                                                    <NumberFieldIncrement />
                                                </NumberFieldContent>
                                            </NumberField>
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-3">
                            <div class="space-y-2">
                                <FormField v-slot="{ value, handleChange }" name="operating_temperature_min">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Temp. Mín.</FormLabel>
                                        <FormControl>
                                            <NumberField :default-value="0" locale="es"
                                                :format-options="{ style: 'unit', unit: 'celsius', unitDisplay: 'narrow' }"
                                                :model-value="value" @update:model-value="handleChange">
                                                <NumberFieldContent>
                                                    <NumberFieldDecrement />
                                                    <NumberFieldInput />
                                                    <NumberFieldIncrement />
                                                </NumberFieldContent>
                                            </NumberField>
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>

                            <div class="space-y-2">
                                <FormField v-slot="{ value, handleChange }" name="operating_temperature_max">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Temp. Máx.</FormLabel>
                                        <FormControl>
                                            <NumberField :default-value="0" locale="es"
                                                :format-options="{ style: 'unit', unit: 'celsius', unitDisplay: 'narrow' }"
                                                :model-value="value" @update:model-value="handleChange">
                                                <NumberFieldContent>
                                                    <NumberFieldDecrement />
                                                    <NumberFieldInput />
                                                    <NumberFieldIncrement />
                                                </NumberFieldContent>
                                            </NumberField>
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>

                            <div class="space-y-2">
                                <FormField v-slot="{ value, handleChange }" name="operating_pressure_max">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Presión Máx. (bar)</FormLabel>
                                        <FormControl>
                                            <NumberField :model-value="value" locale="es" :step="0.1"
                                                :format-options="{ maximumFractionDigits: 1 }"
                                                @update:model-value="handleChange">
                                                <NumberFieldContent>
                                                    <NumberFieldDecrement />
                                                    <NumberFieldInput />
                                                    <NumberFieldIncrement />
                                                </NumberFieldContent>
                                            </NumberField>
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-3">
                            <div class="space-y-2">
                                <FormField v-slot="{ value, handleChange }" name="power_consumption">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Consumo (kW)</FormLabel>
                                        <FormControl>
                                            <NumberField locale="es" :step="0.1"
                                                :format-options="{ maximumFractionDigits: 1 }" :model-value="value"
                                                @update:model-value="handleChange">
                                                <NumberFieldContent>
                                                    <NumberFieldDecrement />
                                                    <NumberFieldInput />
                                                    <NumberFieldIncrement />
                                                </NumberFieldContent>
                                            </NumberField>
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>

                            <div class="space-y-2">
                                <FormField v-slot="{ value, handleChange }" name="voltage">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Voltaje (V)</FormLabel>
                                        <FormControl>
                                            <NumberField :default-value="0" :model-value="value"
                                                @update:model-value="handleChange">
                                                <NumberFieldContent>
                                                    <NumberFieldDecrement />
                                                    <NumberFieldInput />
                                                    <NumberFieldIncrement />
                                                </NumberFieldContent>
                                            </NumberField>
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>

                            <div class="space-y-2">
                                <FormField v-slot="{ value, handleChange }" name="frequency">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Frecuencia (Hz)</FormLabel>
                                        <FormControl>
                                            <NumberField :default-value="0" :model-value="value"
                                                @update:model-value="handleChange">
                                                <NumberFieldContent>
                                                    <NumberFieldDecrement />
                                                    <NumberFieldInput />
                                                    <NumberFieldIncrement />
                                                </NumberFieldContent>
                                            </NumberField>
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <FormField v-slot="{ value, handleChange }" name="weight">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Peso</FormLabel>
                                        <FormControl>
                                            <NumberField locale="es" :step="0.1"
                                                :format-options="{ style: 'unit', unit: 'kilogram', unitDisplay: 'short' }"
                                                :model-value="value" @update:model-value="handleChange">
                                                <NumberFieldContent>
                                                    <NumberFieldDecrement />
                                                    <NumberFieldInput />
                                                    <NumberFieldIncrement />
                                                </NumberFieldContent>
                                            </NumberField>
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>

                            <div class="space-y-2">
                                <FormField v-slot="{ componentField }" name="dimensions">
                                    <FormItem v-auto-animate>
                                        <FormLabel>Dimensiones (L x W x H)</FormLabel>
                                        <FormControl>
                                            <Input type="text" placeholder="2.0 x 1.5 x 1.8 m"
                                                v-bind="componentField" />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                </FormField>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <div class="space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <MapPin class="size-5" />
                            Ubicación y Fechas
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="location_id">
                                <FormItem v-auto-animate>
                                    <FormLabel>Ubicación *</FormLabel>
                                    <Select v-bind="componentField">
                                        <FormControl>
                                            <SelectTrigger>
                                                <SelectValue placeholder="Seleccionar ubicación" />
                                            </SelectTrigger>
                                        </FormControl>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectItem v-for="(location) in locations" :key="location.id"
                                                    :value="location.id">
                                                    {{ location.name }}
                                                </SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="space-y-2">
                            <FormField name="install_date">
                                <FormItem class="flex flex-col">
                                    <FormLabel>Fecha de Instalación *</FormLabel>
                                    <Popover>
                                        <PopoverTrigger as-child>
                                            <FormControl>
                                                <Button variant="outline" :class="cn(
                                                    'w-full ps-3 text-start font-normal',
                                                    !installDate && 'text-muted-foreground',
                                                )">
                                                    <span>{{ installDate ? new DateFormatter('es-ES', {
                                                        dateStyle: 'short'
                                                    }).format(toDate(installDate)) : "Introduce una fecha" }}</span>
                                                    <CalendarIcon class="ms-auto size-4 opacity-50" />
                                                </Button>
                                                <input hidden>
                                            </FormControl>
                                        </PopoverTrigger>
                                        <PopoverContent class="w-auto p-0">
                                            <Calendar v-model:placeholder="phInstall" :model-value="installDate"
                                                calendar-label="Fecha de Instalación" initial-focus
                                                :min-value="new CalendarDate(1900, 1, 1)"
                                                :max-value="today(getLocalTimeZone())" @update:model-value="(v) => {
                                                    if (v) {
                                                        setFieldValue('install_date', v.toString())
                                                    }
                                                    else {
                                                        setFieldValue('install_date', undefined)
                                                    }
                                                }" />
                                        </PopoverContent>
                                    </Popover>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>

                        <div class="space-y-2">
                            <FormField name="warranty_expiry">
                                <FormItem class="flex flex-col">
                                    <FormLabel>Vencimiento Garantía</FormLabel>
                                    <Popover>
                                        <PopoverTrigger as-child>
                                            <FormControl>
                                                <Button variant="outline" :class="cn(
                                                    'w-full ps-3 text-start font-normal',
                                                    !warrantyExpiry && 'text-muted-foreground',
                                                )">
                                                    <span>{{ warrantyExpiry ? new DateFormatter('es-ES', {
                                                        dateStyle: 'short'
                                                    }).format(toDate(warrantyExpiry)) : "Introduce una fecha"
                                                        }}</span>
                                                    <CalendarIcon class="ms-auto size-4 opacity-50" />
                                                </Button>
                                                <input hidden>
                                            </FormControl>
                                        </PopoverTrigger>
                                        <PopoverContent class="w-auto p-0">
                                            <Calendar v-model:placeholder="phWarranty" :model-value="warrantyExpiry"
                                                calendar-label="Vencimiento Garantía" initial-focus
                                                :min-value="new CalendarDate(1900, 1, 1)" @update:model-value="(v) => {
                                                    if (v) {
                                                        setFieldValue('warranty_expiry', v.toString())
                                                    }
                                                    else {
                                                        setFieldValue('warranty_expiry', undefined)
                                                    }
                                                }" />
                                        </PopoverContent>
                                    </Popover>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <FileText class="size-5" />
                            Documentación
                        </CardTitle>
                        <CardDescription>Manuales, certificados, imagenes y documentos técnicos</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <FormField v-slot="{ value, handleChange }" name="documents">
                            <FormItem v-auto-animate>
                                <FormControl>
                                    <div
                                        class="relative border-2 border-dashed border-muted-foreground/25 rounded-lg p-3 text-center">

                                        <div class="pointer-events-none">
                                            <Upload class="mx-auto size-10 text-muted-foreground mb-4" />
                                            <p class="text-sm font-medium">Subir documentos</p>
                                            <p class="text-xs text-muted-foreground">
                                                Haz clic para seleccionar los archivos
                                            </p>
                                        </div>

                                        <Input type="file" id="file-upload" multiple
                                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="hidden"
                                            @change="handleChange" />

                                        <Label for="file-upload" class="absolute inset-0 cursor-pointer">
                                            <span class="sr-only">Seleccionar archivos</span>
                                        </Label>
                                    </div>
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>

                        <div v-if="values.documents?.length !== 0" class="space-y-2">
                            <h4 class="font-medium">Archivos seleccionados:</h4>
                            <div v-for="(document, index) in values.documents" :key="index"
                                class="flex items-center justify-between p-2 bg-muted rounded-lg">
                                <span class="text-sm truncate w-full">{{ document.name }}</span>
                                <Button type="button" variant="ghost" :size="null"
                                    class="h-auto p-1 text-muted-foreground hover:text-destructive"
                                    @click="setFieldValue('documents', (values.documents ?? []).filter(d => d !== document));">
                                    <X class="size-4" />
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            Información Comercial
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <FormField v-slot="{ componentField }" name="supplier">
                                <FormItem v-auto-animate>
                                    <FormLabel>Proveedor *</FormLabel>
                                    <div class="flex items-center gap-2">
                                        <FormControl v-if="isNewSupplier">
                                            <Input type="text" placeholder="Introducir nuevo proveedor"
                                                v-bind="componentField" />
                                        </FormControl>


                                        <Combobox v-else by="label" class="w-full">
                                            <FormControl>
                                                <ComboboxAnchor>
                                                    <div class="relative w-full items-center">
                                                        <ComboboxInput :display-value="(val) => val"
                                                            placeholder="Seleccionar proveedor" />
                                                        <ComboboxTrigger
                                                            class="absolute end-0 inset-y-0 flex items-center justify-center opacity-50">
                                                            <ChevronsUpDown class="size-4 text-muted-foreground" />
                                                        </ComboboxTrigger>
                                                    </div>
                                                </ComboboxAnchor>
                                            </FormControl>

                                            <ComboboxList>
                                                <ComboboxEmpty>
                                                    Sin resultados.
                                                </ComboboxEmpty>

                                                <ComboboxGroup>
                                                    <ComboboxItem v-for="supplier in suppliers"
                                                        :key="supplier.value" :value="supplier.value" @select="() => {
                                                            setFieldValue('supplier', supplier.value)
                                                        }">
                                                        {{ supplier.label }}

                                                        <ComboboxItemIndicator>
                                                            <Check :class="cn('ml-auto size-4')" />
                                                        </ComboboxItemIndicator>
                                                    </ComboboxItem>
                                                </ComboboxGroup>
                                            </ComboboxList>
                                        </Combobox>

                                        <Button type="button" variant="outline"
                                            @click="isNewSupplier ? isNewSupplier = false : isNewSupplier = true; setFieldValue('supplier', '')">
                                            <TextCursorInput v-if="!isNewSupplier" />
                                            <TextSearch v-else />
                                        </Button>
                                    </div>

                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>

        <Card>
            <CardHeader>
                <CardTitle>Notas Adicionales</CardTitle>
            </CardHeader>
            <CardContent>
                <div class="space-y-2">
                    <FormField v-slot="{ componentField }" name="notes">
                        <FormItem v-auto-animate>
                            <FormControl>
                                <Textarea placeholder="Información adicional, observaciones, historial previo..."
                                    v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                </div>
            </CardContent>
        </Card>

        <div class="flex items-center justify-end gap-4">
            <Button type="button" variant="outline" @click="$router.back">
                Cancelar
            </Button>
            <Button type="submit" class="min-w-32">
                <Save v-if="!loading" class="mr-2 size-4" />
                <Loader2 v-else class="mr-2 size-4 animate-spin" />
                Crear Máquina
            </Button>
        </div>
    </form>
</template>

<script setup lang="ts">
import type { Location } from '~/modules/location/types/Location';
import type { MachineCategory } from '../types/MachineCategory';
import type { MachineType } from '../types/MachineType';
import Card from '~/components/ui/card/Card.vue';
import CardHeader from '~/components/ui/card/CardHeader.vue';
import CardTitle from '~/components/ui/card/CardTitle.vue';
import { AlertCircle, CalendarIcon, Check, ChevronsUpDown, Cpu, FileText, Loader2, MapPin, Pencil, Plus, Save, Settings, TextCursorInput, TextSearch, Upload, X } from 'lucide-vue-next';
import CardDescription from '~/components/ui/card/CardDescription.vue';
import CardContent from '~/components/ui/card/CardContent.vue';
import { FormField } from '~/components/ui/form';
import FormItem from '~/components/ui/form/FormItem.vue';
import FormLabel from '~/components/ui/form/FormLabel.vue';
import FormControl from '~/components/ui/form/FormControl.vue';
import Input from '~/components/ui/input/Input.vue';
import FormMessage from '~/components/ui/form/FormMessage.vue';
import Select from '~/components/ui/select/Select.vue';
import SelectTrigger from '~/components/ui/select/SelectTrigger.vue';
import SelectValue from '~/components/ui/select/SelectValue.vue';
import SelectContent from '~/components/ui/select/SelectContent.vue';
import SelectGroup from '~/components/ui/select/SelectGroup.vue';
import SelectItem from '~/components/ui/select/SelectItem.vue';
import Combobox from '~/components/ui/combobox/Combobox.vue';
import ComboboxAnchor from '~/components/ui/combobox/ComboboxAnchor.vue';
import ComboboxInput from '~/components/ui/combobox/ComboboxInput.vue';
import ComboboxTrigger from '~/components/ui/combobox/ComboboxTrigger.vue';
import ComboboxList from '~/components/ui/combobox/ComboboxList.vue';
import ComboboxEmpty from '~/components/ui/combobox/ComboboxEmpty.vue';
import ComboboxGroup from '~/components/ui/combobox/ComboboxGroup.vue';
import ComboboxItem from '~/components/ui/combobox/ComboboxItem.vue';
import ComboboxItemIndicator from '~/components/ui/combobox/ComboboxItemIndicator.vue';
import { cn } from '~/lib/utils';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';
import { useForm } from 'vee-validate';
import type { Machine } from '../types/Machine';
import Textarea from '~/components/ui/textarea/Textarea.vue';
import NumberField from '~/components/ui/number-field/NumberField.vue';
import NumberFieldContent from '~/components/ui/number-field/NumberFieldContent.vue';
import NumberFieldDecrement from '~/components/ui/number-field/NumberFieldDecrement.vue';
import NumberFieldInput from '~/components/ui/number-field/NumberFieldInput.vue';
import NumberFieldIncrement from '~/components/ui/number-field/NumberFieldIncrement.vue';
import Button from '~/components/ui/button/Button.vue';
import Popover from '~/components/ui/popover/Popover.vue';
import PopoverTrigger from '~/components/ui/popover/PopoverTrigger.vue';
import PopoverContent from '~/components/ui/popover/PopoverContent.vue';
import Calendar from '~/components/ui/calendar/Calendar.vue';
import { CalendarDate, DateFormatter, getLocalTimeZone, parseDate, today } from '@internationalized/date'
import { toDate } from 'reka-ui/date'
import Label from '~/components/ui/label/Label.vue';
import CreateMachineTypeForm from './CreateMachineTypeForm.vue';
import CreateMachineCategoryForm from './CreateMachineCategoryForm.vue';
import AlertMessage from '~/components/custom/Alert/AlertMessage.vue';

const props = defineProps<{
    loading?: boolean,
    types: MachineType[],
    categories: MachineCategory[],
    locations: Location[]
    machines: Machine[]
}>()

const emit = defineEmits(['submit'])

const states: Ref<{ label: string, value: string }[]> = ref([
    { label: 'Operativo', value: 'operational' },
    { label: 'Mantenimiento', value: 'maintenance' },
    { label: 'Advertencia', value: 'warning' },
    { label: 'Critico', value: 'critical' },
    { label: 'Retirado', value: 'retired' },
])

const models = computed(() => {
    const seen = new Set()
    return props.machines
        .filter((m) => m.machine_model && !seen.has(m.machine_model) && seen.add(m.machine_model))
        .map((m) => ({
            value: m.machine_model,
            label: m.machine_model,
        }))
})

const isNewModel: Ref<boolean> = ref(false)

const manufacturers = computed(() => {
    const seen = new Set()
    return props.machines
        .filter((m) => m.manufacturer && !seen.has(m.manufacturer) && seen.add(m.manufacturer))
        .map((m) => ({
            value: m.manufacturer,
            label: m.manufacturer,
        }))
})

const isNewManufacturer: Ref<boolean> = ref(false)

const suppliers = computed(() => {
    const seen = new Set()
    return props.machines
        .filter((m) => m.supplier && !seen.has(m.supplier) && seen.add(m.supplier))
        .map((m) => ({
            value: m.supplier,
            label: m.supplier,
        }))
})

const isNewSupplier: Ref<boolean> = ref(false)

const installDate = computed({
    get: () => values.install_date ? parseDate(values.install_date) : undefined,
    set: val => val,
})

const warrantyExpiry = computed({
    get: () => values.warranty_expiry ? parseDate(values.warranty_expiry) : undefined,
    set: val => val,
})

const phInstall = ref()
const phWarranty = ref()

const formSchema = toTypedSchema(z.object({
    name: z
        .string()
        .nonempty({ message: 'El nombre es obligatorio' }),
    type_id: z
        .number()
        .min(1, { message: 'El tipo es obligatorio' }),
    category_id: z
        .number()
        .min(1, { message: 'La categoria es obligatorio' }),
    machine_model: z
        .string()
        .nonempty({ message: 'El modelo es obligatorio' }),
    serial_number: z
        .string()
        .nonempty({ message: 'El numero de serie es obligatorio' }),
    manufacturer: z
        .string()
        .nonempty({ message: 'El fabricante es obligatorio' }),
    description: z
        .string()
        .optional(),
    status: z
        .string()
        .nonempty({ message: 'El estado es obligatorio' })
        .default('operational'),
    maintenance_interval_days: z
        .coerce
        .number()
        .optional(),
    operating_temperature_min: z
        .coerce
        .number()
        .optional(),
    operating_temperature_max: z
        .coerce
        .number()
        .optional(),
    operating_pressure_max: z
        .coerce
        .number()
        .optional(),
    power_consumption: z
        .coerce
        .number()
        .optional(),
    voltage: z
        .coerce
        .number()
        .optional(),
    frequency: z
        .coerce
        .number()
        .optional(),
    weight: z
        .coerce
        .number()
        .optional(),
    dimensions: z
        .string()
        .optional(),
    location_id: z
        .number()
        .min(1, { message: 'La ubicación es obligatorio' }),
    install_date: z
        .string()
        .nonempty({ message: 'La fecha de instalación es obligatorio' }),
    warranty_expiry: z
        .string()
        .optional(),
    documents: z
        .array(z.instanceof(File))
        .optional(),
    supplier: z
        .string()
        .optional(),
    notes: z
        .string()
        .optional()
}))

const { handleSubmit, setFieldValue, values } = useForm({
    validationSchema: formSchema,
    initialValues: {
        name: '',
        machine_model: '',
        serial_number: '',
        manufacturer: '',
        description: '',
        status: 'operational',
        maintenance_interval_days: 0,
        operating_temperature_min: 0,
        operating_temperature_max: 0,
        operating_pressure_max: 0.0,
        power_consumption: 0.0,
        voltage: 0,
        frequency: 0,
        weight: 0.0,
        dimensions: '',
        documents: [],
        notes: ''
    }
})

const onSubmit = handleSubmit((values) => {
    emit('submit', values)
})

</script>

<style scoped></style>