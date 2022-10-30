<script setup>
  import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid'
  import { computed, onMounted } from '@vue/runtime-core';
  import { Link } from '@inertiajs/inertia-vue3';

  const props = defineProps({
      meta: Array,
      links: Array
  });

  const metaData = computed(() => {
    props.meta.links.pop()
    props.meta.links.shift()
    return props.meta
  });

  // const filteredMeta = computed(() => meta)
</script>

<template>
  <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
    <div class="flex flex-1 justify-between sm:hidden">
      <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
      <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
    </div>
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          Showing
          {{ ' ' }}
          <span class="font-medium">{{ meta.from }}</span>
          {{ ' ' }}
          to
          {{ ' ' }}
          <span class="font-medium">{{ meta.to }}</span>
          {{ ' ' }}
          of
          {{ ' ' }}
          <span class="font-medium">{{ meta.total }}</span>
          {{ ' ' }}
          results
          
        </p>
      </div>
      <div>
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
          <Link :href="links.prev">
            <a  class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20">
              <span class="sr-only">Previous</span>
              <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
            </a>
          </Link>

          
          <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
          <Link v-for="(val, index) in metaData.links" :key="index" :href="val.url">
            <a :aria-current="val.active ? 'page' : ''" :class="'relative inline-flex items-center border px-4 py-2 text-sm font-medium focus:z-20' + (val.active ? ' z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : ' bg-white border-gray-300 text-gray-500 hover:bg-gray-50')">{{val.label}}</a>
          </Link>

          <Link :href="links.next">
            <a class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20">
              <span class="sr-only">Next</span>
              <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
            </a>
          </Link>
        </nav>
      </div>
    </div>
  </div>
</template>