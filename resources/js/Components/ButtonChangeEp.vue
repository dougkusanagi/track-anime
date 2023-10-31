<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <button
        class="flex h-8 w-8 items-center justify-center bg-[#1D0D80] hover:brightness-150"
    >
        <slot />
    </button>
</template>
