<script setup>
    import { Link } from '@inertiajs/inertia-vue3';

    defineProps({
        items: Array
    });
</script>

<template>
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
            <tr :key="index" v-for="(val, index) in items" class="bg-white border-b">
                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                    {{ ++index }}
                </th>
                <td class="py-4 px-6">
                    {{ val.name }}
                </td>
                <td class="py-4 px-6">
                    {{ val.link }}
                </td>
                <td class="py-4 px-6">
                    <Link :href="route('resumes.edit')">
                        <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    </Link>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>