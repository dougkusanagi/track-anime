<script setup>
defineProps(["modelValue"]);
defineEmits(["update:modelValue"]);
</script>

<template>
    <input
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        type="text"
        class="block flex-1 rounded-lg border border-white/10 bg-transparent bg-gradient-to-b from-white/10 to-black/10 p-2 text-sm text-white placeholder-white/30 focus:border-white/40 focus:ring-white/40 disabled:bg-white/20 disabled:bg-none disabled:text-white/30"
    />
</template>
