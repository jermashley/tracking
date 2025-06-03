<script setup>
import { faTrashAlt } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { usePage } from '@inertiajs/vue3'
import { FlexRender, getCoreRowModel, useVueTable } from '@tanstack/vue-table'
import { h, reactive } from 'vue'

import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import { useImagesQuery } from '@/composables/queries/image'

import ImageDestroyDialog from './ImageDestroyDialog.vue'
import ImageThumbnailHoverCard from './ImageThumbnailHoverCard.vue'

const { initialImages } = usePage().props

const { data, isError } = useImagesQuery({
  config: {
    initialData: initialImages,
  },
})

const columns = [
  {
    accessorKey: `file_path`,
    header: () => h(`div`, { class: `text-sm font-semibold` }, ``),
    cell: ({ row }) => {
      return h(ImageThumbnailHoverCard, {
        image: row.original,
        class: `flex items-center justify-center`,
      })
    },
  },
  {
    accessorKey: `name`,
    header: () => h(`div`, { class: `text-sm font-semibold` }, `Name`),
    cell: ({ row }) => {
      return h(
        `div`,
        {
          class: `text-sm capitalize`,
        },
        row.original.name,
      )
    },
  },
  {
    accessorKey: `type`,
    header: () => h(`div`, { class: `text-sm font-semibold` }, `Type`),
    cell: ({ row }) => {
      return h(
        `div`,
        {
          class: `text-sm capitalize`,
        },
        row.original.image_type.name,
      )
    },
  },
  {
    accessorKey: `delete`,
    header: () => h(`div`, { class: `text-sm font-semibold` }, `Actions`),
    cell: ({ row }) => {
      return h(
        ImageDestroyDialog,
        {
          image: row.original,
        },
        () => {
          return h(FontAwesomeIcon, {
            icon: faTrashAlt,
            fixedWidth: true,
          })
        },
      )
    },
  },
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

const imagesTable = useVueTable(tableOptions)
</script>

<template>
  <div class="rounded border border-border">
    <Table v-if="data && !isError">
      <TableHeader>
        <TableRow
          v-for="headerGroup in imagesTable.getHeaderGroups()"
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
        <template v-if="imagesTable.getRowModel().rows?.length">
          <TableRow
            v-for="row in imagesTable.getRowModel().rows"
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
