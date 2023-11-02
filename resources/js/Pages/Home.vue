<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { Head, router } from "@inertiajs/vue3";

import NewAuthLayout from "@/Layouts/NewAuthLayout.vue";

import AnimeSavedFilterSelect from "@/Components/AnimeSavedFilterSelect.vue";
import HomeFilterSelect from "@/Components/HomeFilterSelect.vue";
import SavedAnimeCard from "@/Components/SavedAnimeCard.vue";
import AppButton from "@/Components/AppButton.vue";
import { reactive } from "vue";

const props = defineProps({
    animes: Object,
    saved_animes: Object,
});

const query_input = ref("");

const saved_order_by = ref("last_watched_at");

const saved_q = ref("");

const saved_order_by_options = reactive([
    { value: "last_watched_at", label: "Último assistido" },
    { value: "title", label: "Nome" },
]);

const saved_animes_filtered = computed(() =>
    props.saved_animes.filter((anime) =>
        anime.title.toLowerCase().includes(saved_q.value.toLowerCase())
    )
);

watch(saved_order_by, async (_new, _old) => {
    router.get(
        route("home"),
        {
            orderBy: saved_order_by.value,
            sort: saved_order_by.value === "last_watched_at" ? "desc" : "asc",
        },
        {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        }
    );
});

onMounted(() => {
    if (query_input.value) {
        query_input.value.focus();
    }
});
</script>

<template>
    <Head title="Home" />

    <NewAuthLayout>
        <div v-if="$page.props.auth.user" class="ml-6 mt-16 sm:ml-12">
            <h2
                class="border-b-2 border-white/40 pb-2 text-lg font-black text-white/60"
            >
                Minha Lista
            </h2>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:gap-4">
                <HomeFilterSelect>
                    <label
                        for="q"
                        class="block w-24 min-w-fit text-sm font-medium text-white/80"
                    >
                        Pesquisar:
                    </label>

                    <input
                        id="q"
                        ref="query_input"
                        type="search"
                        class="block flex-1 appearance-none rounded border-none bg-transparent p-2 py-1 text-sm font-bold text-white outline-none placeholder:font-bold placeholder:text-white/60 focus:ring-transparent sm:w-44"
                        placeholder="Nome do Anime..."
                        v-model="saved_q"
                        autocomplete="off"
                    />
                </HomeFilterSelect>

                <HomeFilterSelect>
                    <label
                        for="orderBy"
                        class="block w-24 min-w-fit text-sm font-medium text-white/50"
                    >
                        Ordenar por:
                    </label>

                    <select
                        id="orderBy"
                        v-model="saved_order_by"
                        class="block flex-1 appearance-none rounded border-none bg-transparent p-2 py-1 text-sm font-bold text-white outline-none focus:ring-transparent disabled:text-white/30 sm:w-44"
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

                <!-- <HomeFilterSelect>
                    <label
                        for="gender"
                        class="block w-24 min-w-fit text-sm font-medium text-white/50"
                    >
                        Gêneros:
                    </label>

                    <AnimeSavedFilterSelect
                        id="gender"
                    >
                        <option
                            v-for="option in [
                                { label: 'Todos', value: '' },
                                { label: 'Ação', value: 'action' },
                            ]"
                            :value="option.value"
                            class="text-black"
                        >
                            {{ option.label }}
                        </option>
                    </AnimeSavedFilterSelect>
                </HomeFilterSelect> -->
            </div>

            <div class="mt-6 max-w-full">
                <!-- <div class="flex gap-4 overflow-x-auto py-2"> -->
                <div
                    class="mr-6 grid grid-cols-2 gap-y-4 overflow-x-auto py-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-7"
                >
                    <SavedAnimeCard
                        v-for="anime in saved_animes_filtered"
                        :anime="anime"
                        :key="anime.id"
                        v-once
                    />
                </div>
            </div>
        </div>

        <div class="mx-8 mt-16" v-else>
            <div
                class="mx-auto max-w-5xl rounded-xl border border-white/20 bg-black/50 px-6 py-10 text-center text-white shadow-xl backdrop-blur"
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
