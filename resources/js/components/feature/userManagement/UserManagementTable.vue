<script setup>
import { usePage } from '@inertiajs/vue3'
import { FlexRender, getCoreRowModel, useVueTable } from '@tanstack/vue-table'
import { h, reactive } from 'vue'

import { useHasPermissions } from '@/composables/hooks/auth/useHasPermissions'
const { hasPermissions } = useHasPermissions()
import UserRolesDropdown from '@/components/feature/userManagement/UserRolesDropdown.vue'
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table/index.js'

const { users } = usePage().props

const columns = [
  {
    accessorKey: `first_name`,
    header: () => h(`div`, { class: `text-sm font-semibold` }, `First Name`),
    cell: ({ row }) => {
      return h(
        `span`,
        { class: `text-sm font-semibold` },
        row.original.first_name,
      )
    },
  },
  {
    accessorKey: `last_name`,
    header: () => h(`div`, { class: `text-sm font-semibold` }, `Last Name`),
    cell: ({ row }) => {
      return h(
        `span`,
        { class: `text-sm font-semibold` },
        row.original.last_name,
      )
    },
  },
  {
    accessorKey: `email`,
    header: () => h(`div`, { class: `text-base` }, `Email`),
    cell: ({ row }) => {
      return h(`span`, { class: `text-sm font-semibold` }, row.original.email)
    },
  },
  {
    accessorKey: `roles`,
    header: () => h(`div`, { class: `text-base` }, `Roles`),
    cell: ({ row }) => {
      return h(
        `span`,
        { class: `text-sm font-semibold` },
        row.original.roles[0],
      )
    },
  },
  hasPermissions(`role.update`)
    ? {
        accessorKey: `edit`,
        header: () => h(`div`, { class: `text-sm font-semibold` }, `Edit`),
        cell: ({ row }) => {
          return h(UserRolesDropdown, {
            userId: row.original.id,
            onRoleUpdated: (newRole) => {
              updateUserRole(row.original.id, newRole, row)
            },
          })
        },
      }
    : null,
].filter(Boolean)

const tableOptions = reactive({
  get data() {
    return users
  },
  get columns() {
    return columns
  },
  getCoreRowModel: getCoreRowModel(),
})

const companiesTable = useVueTable(tableOptions)
const updateUserRole = (userId, newRole, row) => {
  row.original.roles[0] = newRole.name // Update the role in the row data
}
</script>

<template>
  <div class="rounded border border-border">
    <Table v-if="users">
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
</template>
