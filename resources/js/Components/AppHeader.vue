<script setup>
import { ref, computed, shallowRef, onBeforeMount } from "vue";

import House from "@/Icons/HeroIcons/House.vue";
import MagnifyingGlass from "@/Icons/HeroIcons/MagnifyingGlass.vue";
import UserCircle from "@/Icons/HeroIcons/UserCircle.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import CaretDown from "@/Icons/CaretDown.vue";
import DropdownUserMenu from "./DropdownUserMenu.vue";
import AppButtonHeader from "./AppButtonHeader.vue";

const isOpen = ref(false);
const q = ref("");
const showSearchHeader = computed(() => {
    return (
        computed(() => usePage().props.auth.user) && !route().current("search")
    );
});

const links = shallowRef([
    {
        name: "Início",
        href: route("home"),
        icon: House,
    },
]);

function search() {
    router.get(route("search", { q: q.value }));
}
</script>

<template>
    <header
        class="fixed top-0 z-10 w-full border-b-2 sm:flex sm:items-center sm:justify-between sm:px-10 sm:py-3"
        style="
            border-image: linear-gradient(
                    90deg,
                    rgba(255, 255, 255, 0.12),
                    rgba(255, 255, 255, 0.05),
                    rgba(255, 255, 255, 0.12)
                )
                1;
        "
    >
        <div
            class="absolute inset-0 -z-10 bg-gradient-to-b from-white/10 to-black/10 backdrop-blur-xl"
        ></div>

        <div class="flex items-center justify-between px-4 py-3 sm:p-0">
            <Link :href="route('home')" class="flex items-center gap-2">
                <img
                    class="h-12 mt-2"
                    src="/logo-anime-track.svg"
                    alt="Workcation"
                />

                <span class="text-2xl font-medium text-white">TRACK ANIME</span>
            </Link>

            <button
                @click="isOpen = !isOpen"
                type="button"
                class="block p-2 text-gray-500 rounded hover:bg-indigo-600 hover:text-white hover:shadow-xl hover:shadow-indigo-600/60 sm:hidden"
            >
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                    <path
                        v-if="isOpen"
                        fill-rule="evenodd"
                        d="M18.278 16.864a1 1 0 0 1-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 0 1-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 0 1 1.414-1.414l4.829 4.828 4.828-4.828a1 1 0 1 1 1.414 1.414l-4.828 4.829 4.828 4.828z"
                    />

                    <path
                        v-if="!isOpen"
                        fill-rule="evenodd"
                        d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"
                    />
                </svg>
            </button>
        </div>

        <nav
            :class="isOpen ? 'block' : 'hidden'"
            class="flex items-center px-2 pt-2 pb-4 border-t-2 sm:flex sm:border-none sm:p-0"
        >
            <div class="flex items-center gap-10">
                <AppButtonHeader :href="link.href" v-for="link in links">
                    <component :is="link.icon" />

                    {{ link.name }}
                </AppButtonHeader>

                <form @submit.prevent="search" v-if="showSearchHeader">
                    <input
                        type="search"
                        placeholder="Pesquisar..."
                        v-model="q"
                        class="flex items-center gap-2 px-4 py-3 font-semibold text-black transition-all rounded"
                    />
                </form>
            </div>

            <a
                href="mailto:dl.aguiar@yahoo.com.br?subject=EMAIL DO TRACK ANIME"
                class="flex items-center justify-center ml-6 mr-8 text-xs transition-all border border-red-800 rounded-full h-7 w-7 hover:bg-red-800"
                title="Envie sua sujestão 🤯️ ou relate um problema 💩️"
            >
                ?
            </a>

            <div class="border-l-0 border-white/20 sm:border-l-2 sm:pl-4">
                <AppButtonHeader
                    id="dropdownUserMenuButton"
                    data-dropdown-toggle="dropdownUserMenu"
                    type="button"
                    class="w-full"
                >
                    <UserCircle />

                    <span class="sm:hidden"> Configurações </span>

                    <CaretDown />
                </AppButtonHeader>

                <DropdownUserMenu />
            </div>
        </nav>
    </header>
</template>
