<script setup>
import { Link } from "@inertiajs/vue3";
</script>
<template>
    <Link
        :href="route('login')"
        class="rounded bg-indigo-800 px-3 py-2 text-sm font-bold text-white shadow-lg shadow-indigo-700/60 transition-all hover:shadow-indigo-700/60 hover:brightness-125 disabled:cursor-not-allowed disabled:opacity-50"
    >
        <slot />
    </Link>
</template>
