<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

// Toastr custom options
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut",
    "showDuration": 300,
    "hideDuration": 300,
    "timeOut": 4000,
    "extendedTimeOut": 1000,
    "positionClass": "toast-top-right",
};

// Dark mode support for Toastr
function setToastrDarkMode() {
    const isDark = document.documentElement.classList.contains('dark');
    const styleId = 'toastr-dark-style';
    let styleTag = document.getElementById(styleId);
    if (isDark && !styleTag) {
        styleTag = document.createElement('style');
        styleTag.id = styleId;
        document.head.appendChild(styleTag);
    } else if (!isDark && styleTag) {
        styleTag.remove();
    }
}

// Watch for dark mode changes
const darkModeObserver = new MutationObserver(setToastrDarkMode);
darkModeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
setToastrDarkMode();


defineProps({
    title: String,
});

const page = usePage();

// Show toastr for success flash messages
let lastSuccess = ref(null);
watch(
    () => page.props.flash && page.props.flash.success,
    (newVal) => {
        if (newVal && newVal !== lastSuccess.value) {
            toastr.success(newVal);
            lastSuccess.value = newVal;
        }
    },
    { immediate: true }
);

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationMark class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('reservation.index')" :active="route().current('reservation.index')">
                                    Reservations
                                </NavLink>
                                <NavLink
                                    :href="route('login')"
                                    :active="route().current('login')"
                                >
                                    Log in
                                </NavLink>

                           

                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
