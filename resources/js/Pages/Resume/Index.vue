<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue';
import Table from '@/Components/Table.vue';
import { Link } from '@inertiajs/inertia-vue3';

defineProps({
    resumes: Array
}
);

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Resume
            </h2>
        </template>

    <div class="bg-gray-50">
        <div class="mx-auto max-w-7xl py-12 px-4 sm:px-6 lg:items-center lg:justify-between lg:py-16 lg:px-8">
             <div v-if="$page.props.flash.success" class="p-4 -mt-8 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                <span class="font-medium">
                    {{ $page.props.flash.success }}
                </span>
            </div>
            <!-- <template> -->
                <div class="overflow-x-auto relative">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    #
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Name
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Link
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :key="index" v-for="(val, index) in resumes.data" class="bg-white border-b">
                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                    {{ ++index }}
                                </th>
                                <td class="py-4 px-6">
                                    {{ val.name }}
                                </td>
                                <td class="py-4 px-6">
                                    <a target="_blank" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" :href="route('resumes.display', val.code)">{{ route('resumes.display', val.code) }}</a>
                                </td>
                                <td class="py-4 px-6">
                                    <Link :href="route('resumes.edit', val.id)">
                                        <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <!-- </template> -->
            <Pagination :meta="resumes.meta" :links="resumes.links"></Pagination>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
