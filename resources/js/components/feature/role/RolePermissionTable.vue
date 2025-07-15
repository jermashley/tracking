<script setup>
import { router } from '@inertiajs/vue3'
import { FlexRender, getCoreRowModel, useVueTable } from '@tanstack/vue-table'
import { computed, h, reactive } from 'vue'

import RolePermissionCheckbox from '@/components/feature/role/RolePermissionCheckbox.vue'
import { Button } from '@/components/ui/button/index.js'
import { DialogFooter } from '@/components/ui/dialog/index.js'
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table/index.js'

const props = defineProps({
  permissions: {
    type: Array,
    required: true,
  },
  allPermissions: {
    type: Array,
    required: true,
  },
})

const permissionsWithChecked = computed(() => {
  return props.allPermissions.map((permission) => ({
    ...permission,
    checked: props.permissions.some((p) => p.name === permission.name),
  }))
})

const checkedPermissions = computed(() => {
  return permissionsWithChecked.value
    .filter((permission) => permission.checked)
    .map((permission) => permission.name)
})

const cancelDialog = () => {
  // Emit an event to close the dialog
  router.visit(route(`admin.role.index`))
}

const columns = [
  {
    accessorKey: `name`,
    header: () => h(`div`, { class: `text-sm font-semibold` }, `Permission`),
    cell: ({ row }) => {
      return h(`span`, { class: `text-sm font-semibold` }, row.original.name)
    },
  },
  {
    accessorKey: `edit`,
    header: () => h(`div`, { class: `text-sm font-semibold` }, `Assign`),
    cell: ({ row }) => {
      return h(RolePermissionCheckbox, {
        modelValue: row.original.checked,
      })
    },
  },
]

const tableOptions = reactive({
  get data() {
    return permissionsWithChecked
  },
  get columns() {
    return columns
  },
  getCoreRowModel: getCoreRowModel(),
})

const companiesTable = useVueTable(tableOptions)
</script>

<template>
  <div class="rounded border border-border">
    <Table v-if="props.permissions">
      <TableHeader>
        <TableRow
          v-for="headerGroup in companiesTable.getHeaderGroups()"
          :key="headerGroup.id"
        >
          <TableHead v-for="header in headerGroup.headers" :key="header.id">
            <FlexRender
              v-if="!header.isPlaceholder"
              :render="header.column.columnDef.header"
              :props="header.getContext()"
            />
          </TableHead>
        </TableRow>
      </TableHeader>

      <TableBody>
        <template v-if="companiesTable.getRowModel().rows?.length">
          <TableRow
            v-for="row in companiesTable.getRowModel().rows"
            :key="row.uuid"
          >
            <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
              <FlexRender
                :render="cell.column.columnDef.cell"
                :props="cell.getContext()"
              />
            </TableCell>
          </TableRow>
        </template>

        <template v-else>
          <TableRow>
            <TableCell :colspan="columns.length" class="h-24 text-center">
              No results.
            </TableCell>
          </TableRow>
        </template>
      </TableBody>
    </Table>
  </div>
  <DialogFooter class="flex flex-row items-center justify-end space-x-2 pt-4">
    <Button
      variant="secondary"
      size="sm"
      :disabled="isPending"
      @click="cancelDialog"
    >
      Cancel
    </Button>

    <Button
      type="button"
      variant="default"
      size="sm"
      class=""
      :disabled="isPending"
      @click="submitForm"
    >
      Save
    </Button>
  </DialogFooter>
</template>
