<script setup>
const props = defineProps({
    options: Object,
});
</script>

<template>
    <select
        class="block w-44 appearance-none rounded border-none bg-transparent p-2 py-1 text-sm font-bold outline-none focus:ring-transparent"
    >
        <option
            v-for="option in options"
            :value="option.value"
            style="padding: 12px"
        >
            {{ option.label }}
        </option>
    </select>
</template>
