<script setup>
import { faEdit } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { Link } from '@inertiajs/vue3'
import { FlexRender, getCoreRowModel, useVueTable } from '@tanstack/vue-table'
import { h, reactive } from 'vue'

import { Button } from '@/components/ui/button'
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import { useCompaniesQuery } from '@/composables/queries/company'

import SelectThemeDialog from '../theme/SelectThemeDialog.vue'
import CompanyInfoCell from './CompanyInfoCell.vue'
import CompanyUpdateButton from './CompanyUpdateButton.vue'
import EnableMapSwitch from './EnableMapSwitch.vue'

const { data, isError } = useCompaniesQuery()

const columns = [
  {
    accessorKey: `name`,
    header: () => h(`div`, { class: `text-sm font-semibold` }, `Name`),
    cell: ({ row }) => {
      return h(CompanyInfoCell, {
        name: row.getValue(`name`),
        pipelineCompanyId: row.original.pipeline_company_id,
        phone: row.original.phone,
        website: row.original.website,
        email: row.original.email,
        logo: row.original.logo,
      })
    },
  },
  {
    accessorKey: `enable_map`,
    header: () => h(`div`, { class: `text-sm font-semibold` }, `Tracking Map`),
    cell: ({ row }) => {
      return h(EnableMapSwitch, {
        companyId: row.original.id,
        id: `enable_map`,
        name: `Enable Map`,
        value: Boolean(row.getValue(`enable_map`)),
      })
    },
  },
  {
    accessorKey: `theme_id`,
    header: () => h(`div`, { class: `text-base` }, `Theme`),
    cell: ({ row }) => {
      return h(SelectThemeDialog, {
        companyId: row.original.id,
        currentTheme: row.original.theme,
      })
    },
  },
  {
    accessorKey: `edit`,
    header: () => h(`div`, { class: `text-sm font-semibold` }, `Edit`),
    cell: ({ row }) => {
      return h(Button, { variant: `outline`, size: `sm`, asChild: true }, [
        h(Link, { href: route(`admin.company.show`, row.original.uuid) }, [
          h(FontAwesomeIcon, { icon: faEdit, fixedWidth: true }),
        ]),
      ])
    },
  },
  //   {
  //     accessorKey: `logo`,
  //     header: () => h(`div`, { class: `text-base` }, `Logo`),
  //     cell: ({ row }) => h(`img`, { class: `text-base`, src: row.logo }),
  //   },
  //   {
  //     accessorKey: `theme_id`,
  //     header: () => h(`div`, { class: `text-base` }, `Theme`),
  //     cell: ({ row }) => h(`div`, { class: `text-base` }, row.theme_id),
  //   },
  //   {
  //     accessorKey: `background_image_id`,
  //     header: () => h(`div`, { class: `text-base` }, `Background`),
  //     cell: ({ row }) =>
  //       h(`div`, { class: `text-base` }, row.background_image_id),
  //   },
]

const tableOptions = reactive({
  get data() {
    return data
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
    <Table v-if="data && !isError">
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
