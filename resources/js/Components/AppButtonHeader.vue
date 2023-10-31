<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    type: {
        type: String,
        default: "Link",
        defineOptions: {
            values: ["Link", "Button"],
        },
    },
});
</script>
<template>
    <component
        :is="props.type === 'Link' ? Link : 'button'"
        class="flex items-center gap-2 rounded px-4 py-3 font-semibold text-white transition-all hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-700/60"
    >
        <slot />
    </component>
</template>
