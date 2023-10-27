<script setup>
import { ref } from "vue";

import House from "@/Icons/HeroIcons/House.vue";
import MagnifyingGlass from "@/Icons/HeroIcons/MagnifyingGlass.vue";
import UserCircle from "@/Icons/HeroIcons/UserCircle.vue";
import { Link } from "@inertiajs/vue3";

const isOpen = ref(false);

const links = [
    {
        name: "Início",
        href: "#",
        icon: House,
    },
    {
        name: "Pesquisar",
        href: "#",
        icon: MagnifyingGlass,
    },
    {
        name: "",
        href: "#",
        icon: UserCircle,
    },
];
</script>

<template>
    <header
        class="fixed top-0 w-full border-b-2 sm:flex sm:justify-between sm:items-center sm:px-4 sm:py-3"
        style="
            border-image: linear-gradient(
                    90deg,
                    rgba(255, 255, 255, 0.25),
                    rgba(255, 255, 255, 0.1),
                    rgba(255, 255, 255, 0.25)
                )
                1;
        "
    >
        <div class="absolute inset-0 backdrop-blur-xl bg-white/10 -z-10"></div>

        <div class="flex items-center justify-between px-4 py-3 sm:p-0">
            <Link :href="route('home')" class="flex items-center gap-2">
                <img
                    class="h-12 mt-2"
                    src="/logo-anime-track.svg"
                    alt="Workcation"
                />
                <span class="text-xl">TRACK ANIME</span>
            </Link>

            <button
                @click="isOpen = !isOpen"
                type="button"
                class="block p-2 text-gray-500 rounded hover:shadow-xl hover:bg-indigo-600 hover:shadow-indigo-600/60 hover:text-white sm:hidden"
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
            class="gap-10 px-2 pt-2 pb-4 border-t-2 sm:border-none sm: sm:flex sm:p-0"
            style="
                border-image: linear-gradient(
                        90deg,
                        rgba(255, 255, 255, 0.25),
                        rgba(255, 255, 255, 0.1),
                        rgba(255, 255, 255, 0.25)
                    )
                    1;
            "
        >
            <a
                href="#"
                class="flex items-center gap-2 px-3 py-3 font-semibold text-white rounded hover:shadow-xl hover:bg-indigo-700 hover:shadow-indigo-700/60"
                v-for="link in links"
            >
                <component :is="link.icon" />

                {{ link.name }}
            </a>
        </nav>
    </header>
</template>
