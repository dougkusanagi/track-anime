<script setup>
import { Head, router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

import NewAuthLayout from "@/Layouts/NewAuthLayout.vue";

import AnimeSearchedCard from "@/Components/AnimeSearchedCard.vue";

import useUrl from "@/Composables/useUrl";
import useDebounce from "@/Composables/useDebounce";

const props = defineProps({
    animes: Object,
    already_on_list: Object,
});

const query_input = ref(null);
const q = ref(useUrl().params.q);

onMounted(() => query_input.value.focus());

function search() {
    useDebounce(() => {
        router.visit(route("search", { q: q.value }));
    }, 700);
}
</script>

<template>
    <Head title="Pesquisa" />

    <NewAuthLayout>
        <div class="ml-6 mt-16 sm:ml-12">
            <div class="max-w-full border-b-2 border-white/40 pb-2">
                <input
                    @input="search"
                    v-model="q"
                    ref="query_input"
                    type="search"
                    class="block min-w-full appearance-none rounded border-b-2 border-none border-white/40 bg-transparent text-3xl text-white text-white/80 outline-none focus:ring-transparent disabled:text-white/30 disabled:placeholder:font-bold disabled:placeholder:text-white/30 sm:w-44"
                    placeholder="Digite o nome de um anime..."
                />
            </div>
        </div>

        <!-- <pre>{{ already_on_list }}</pre> -->

        <div class="ml-6 mt-16 sm:ml-12">
            <div class="mt-6 flex-1">
                <div
                    class="grid grid-cols-2 gap-y-4 overflow-x-auto py-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-7"
                >
                    <AnimeSearchedCard
                        v-for="anime in animes"
                        :anime="anime"
                        :key="anime.id"
                        :already_on_list="
                            already_on_list.includes(anime.mal_id)
                        "
                    />
                </div>
            </div>
        </div>
    </NewAuthLayout>
</template>
