<script setup>
import { ref, computed, onMounted, watch, reactive } from "vue";
import { Head, router, usePage } from "@inertiajs/vue3";

import NewAuthLayout from "@/Layouts/NewAuthLayout.vue";
import AnimeDetailsDrawer from "@/Components/AnimeDetailsDrawer.vue";

import HomeFilterSelect from "@/Components/HomeFilterSelect.vue";
import SavedAnimeCard from "@/Components/SavedAnimeCard.vue";
import AppButton from "@/Components/AppButton.vue";

import { initFlowbite } from "flowbite";
import { onBeforeMount } from "vue";
import axios from "axios";

const props = defineProps({
    top_ten_animes: Object,
    saved_animes: Object,
});

const query_input = ref("");

const saved_q = ref("");

const selected_anime = ref(props.top_ten_animes[0]);

let drawer_anime_details = null;

onBeforeMount(() => {
    const anime = { ...props.saved_animes[0] };
    selected_anime.value = anime;
});

function getAnimeDetails(anime) {
    return new Promise(async (resolve) => {
        const { data } = await axios.get(route("anime-details", anime.mal_id));

        resolve(data);
    });
}

async function openAnimeDetails(clicked_anime) {
    clicked_anime.details = await getAnimeDetails(clicked_anime);
    selected_anime.value = clicked_anime;
    console.log(clicked_anime);

    if (!drawer_anime_details) {
        drawer_anime_details = new Drawer(
            document.getElementById("drawer-saved-anime-details")
        );
    }

    drawer_anime_details.show();
}

const form_saved_anime = reactive({
    order_by: "last_watched_at",
    status: "",
});
const saved_order_by_options = reactive([
    { value: "last_watched_at", label: "Último assistido" },
    { value: "title", label: "Nome" },
]);

const saved_animes_filtered = computed(() =>
    props.saved_animes.filter((anime) =>
        anime.title.toLowerCase().includes(saved_q.value.toLowerCase())
    )
);

watch(form_saved_anime, async (_new, _old) => {
    router.get(
        route("home"),
        {
            orderBy: form_saved_anime.order_by,
            status: form_saved_anime.status,
            sort:
                form_saved_anime.order_by === "last_watched_at"
                    ? "desc"
                    : "asc",
        },
        {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        }
    );
});

onMounted(() => {
    initFlowbite();

    if (query_input.value) {
        query_input.value.focus();
    }
});
</script>

<template>
    <Head title="Home" />

    <NewAuthLayout>
        <AnimeDetailsDrawer :anime="selected_anime" />

        <div v-if="$page.props.auth.user" class="mt-16 ml-6 sm:ml-12">
            <h2
                class="pb-2 text-lg font-black border-b-2 border-white/40 text-white/60"
            >
                Minha Lista
            </h2>

            <div class="flex flex-col gap-3 mt-6 sm:flex-row sm:gap-4">
                <HomeFilterSelect>
                    <label
                        for="q"
                        class="block w-24 text-sm font-medium min-w-fit text-white/80"
                    >
                        Pesquisar:
                    </label>

                    <input
                        id="q"
                        ref="query_input"
                        type="search"
                        class="flex-1 block p-2 py-1 text-sm font-bold text-white bg-transparent border-none rounded outline-none appearance-none placeholder:font-bold placeholder:text-white/60 focus:ring-transparent sm:w-44"
                        placeholder="Nome do Anime..."
                        v-model="saved_q"
                        autocomplete="off"
                    />
                </HomeFilterSelect>

                <HomeFilterSelect>
                    <label
                        for="orderBy"
                        class="block w-24 text-sm font-medium min-w-fit text-white/50"
                    >
                        Ordenar por:
                    </label>

                    <select
                        id="orderBy"
                        v-model="form_saved_anime.order_by"
                        class="flex-1 block p-2 py-1 text-sm font-bold text-white bg-transparent border-none rounded outline-none appearance-none focus:ring-transparent disabled:text-white/30 sm:w-44"
                    >
                        <option
                            v-for="option in saved_order_by_options"
                            :value="option.value"
                            class="text-black"
                        >
                            {{ option.label }}
                        </option>
                    </select>
                </HomeFilterSelect>

                <HomeFilterSelect>
                    <label
                        for="status"
                        class="block w-24 text-sm font-medium min-w-fit text-white/50"
                    >
                        Status:
                    </label>

                    <select
                        id="status"
                        v-model="form_saved_anime.status"
                        class="flex-1 block p-2 py-1 text-sm font-bold text-white bg-transparent border-none rounded outline-none appearance-none focus:ring-transparent disabled:text-white/30 sm:w-44"
                    >
                        <option class="text-black" value="">Todos</option>

                        <option
                            v-for="(option, index) in usePage().props
                                .saved_anime_status_list"
                            :value="option"
                            class="text-black"
                        >
                            {{ index }}
                        </option>
                    </select>
                </HomeFilterSelect>
            </div>

            <div class="max-w-full mt-6">
                <!-- <div class="flex gap-4 py-2 overflow-x-auto"> -->
                <div
                    class="grid grid-cols-2 py-2 mr-6 gap-y-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-7"
                >
                    <SavedAnimeCard
                        v-for="anime in saved_animes_filtered"
                        :anime="anime"
                        :key="anime.id"
                        @changeSelectedAnime="openAnimeDetails"
                    />
                </div>
            </div>
        </div>

        <div class="mx-8 mt-16" v-else>
            <div
                class="max-w-5xl px-6 py-10 mx-auto text-center text-white border shadow-xl rounded-xl border-white/20 bg-black/50 backdrop-blur"
            >
                <p class="text-4xl font-bold">Bem vindo visitante!</p>

                <div
                    class="mt-6 text-xl text-white/70"
                    style="text-wrap: balance"
                >
                    <p>
                        Aqui você encontrará seus animes favoritos e poderá
                        guardá-los na sua lista, adicionar links para assistir e
                        salvar o episódio que parou de assistir para continuar
                        mais tarde.
                    </p>
                    <br />
                    <p>
                        <AppButton :href="route('login')">
                            Inicie uma sessão
                        </AppButton>
                        ou
                        <AppButton :href="route('register')"
                            >Cadastre-se</AppButton
                        >
                        para nunca mais ter que se preocupar em lembrar qual
                        episódio parou de assistir.
                    </p>
                </div>
            </div>
        </div>
    </NewAuthLayout>
</template>
