<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    items: Array,
    modelValue: '',
    name: ''
});

defineEmits(['update:modelValue']);

const input = ref('');

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

</script>

<template>
    <select :id="name" :name="name" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input">
        <option value="" >Please select option</option>
        <option :value="val.id" :key="val.id" v-for="val in items">{{val.name}}</option>
    </select>
</template>
