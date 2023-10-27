<script setup>
const props = defineProps({
    options: Object,
});
</script>

<template>
    <select
        class="block p-2 text-sm text-gray-900 border border-gray-300 rounded w-44 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
    >
        <option v-for="option in options" :value="option.value">
            {{ option.label }}
        </option>
    </select>
</template>
