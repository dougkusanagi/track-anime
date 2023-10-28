<script setup>
const props = defineProps({
    options: Object,
});
</script>

<template>
    <select
        class="block w-44 rounded border border-gray-300 bg-gray-50 p-2 py-1 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
    >
        <option v-for="option in options" :value="option.value">
            {{ option.label }}
        </option>
    </select>
</template>
