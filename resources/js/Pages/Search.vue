<script setup>
import { Head } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

import NewAuthLayout from "@/Layouts/NewAuthLayout.vue";

const query_input = ref(null);

onMounted(() => query_input.value.focus());
</script>

<template>
    <Head title="Pesquisa" />

    <NewAuthLayout>
        <div class="ml-6 mt-16 sm:ml-12">
            <div class="w-full border-b-2 border-white/40 pb-2">
                <input
                    ref="query_input"
                    id="q"
                    type="text"
                    class="block min-w-full appearance-none rounded border-b-2 border-none border-white/40 bg-transparent text-3xl text-white text-white/80 outline-none focus:ring-transparent disabled:text-white/30 disabled:placeholder:font-bold disabled:placeholder:text-white/30 sm:w-44"
                    placeholder="Digite o nome de um anime..."
                />
            </div>
        </div>
    </NewAuthLayout>
</template>
