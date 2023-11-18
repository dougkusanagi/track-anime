<script setup>
import { Link } from "@inertiajs/vue3";
</script>
<template>
    <span
        class="rounde inline-flex w-fit items-center justify-center rounded bg-gradient-to-r from-indigo-900 via-indigo-500 to-indigo-900 pb-[2px] hover:via-indigo-200"
    >
        <Link
            :href="route('login')"
            v-bind="$attrs"
            class="rounded bg-indigo-800 px-3 py-2 text-sm font-bold text-white/80 shadow-lg shadow-indigo-700/40 transition-all hover:text-white hover:brightness-125 disabled:cursor-not-allowed disabled:opacity-50"
        >
            <slot />
        </Link>
    </span>
</template>
