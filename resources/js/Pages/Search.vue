<script setup>
import { Head } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

import NewAuthLayout from "@/Layouts/NewAuthLayout.vue";
import AnimeSearchedCard from "@/Components/AnimeSearchedCard.vue";

const props = defineProps({
    animes: Object,
});

const query_input = ref(null);

onMounted(() => query_input.value.focus());
</script>

<template>
    <Head title="Pesquisa" />

    <NewAuthLayout>
        <div class="mt-16 ml-6 sm:ml-12">
            <div class="w-full pb-2 border-b-2 border-white/40">
                <input
                    ref="query_input"
                    id="q"
                    type="text"
                    class="block min-w-full text-3xl text-white bg-transparent border-b-2 border-none rounded outline-none appearance-none border-white/40 text-white/80 focus:ring-transparent disabled:text-white/30 disabled:placeholder:font-bold disabled:placeholder:text-white/30 sm:w-44"
                    placeholder="Digite o nome de um anime..."
                />
            </div>

            <div class="max-w-full mt-6">
                <div class="flex gap-4 py-2 overflow-x-auto">
                    <AnimeSearchedCard
                        v-for="anime in animes"
                        :anime="anime"
                        :key="anime.id"
                    />
                </div>
            </div>
        </div>
    </NewAuthLayout>
</template>
