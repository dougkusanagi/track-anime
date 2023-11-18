<script setup>
defineProps(["modelValue"]);
defineEmits(["update:modelValue"]);
</script>

<template>
    <select
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="rounded-lg border-white/10 bg-white/10 p-2 text-sm text-white placeholder-white/30 focus:border-white/40 focus:ring-white/40 disabled:bg-white/20 disabled:text-white/30"
    >
        <slot />
    </select>
</template>
