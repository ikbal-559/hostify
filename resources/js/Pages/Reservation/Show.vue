<template>
    <GuestLayout :title="`Reservation #${reservation.id}`">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Reservation #{{ reservation.id }}
            </h2>
        </template>
        <div class="py-8 text-white">
            <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 shadow rounded p-6">
                <div class="mb-4">
                    <strong>Check-in:</strong> {{ reservation.check_in }}<br>
                    <strong>Check-out:</strong> {{ reservation.check_out }}<br>
                    <strong>Status:</strong> {{ reservation.status || '-' }}<br>
                    <strong>Notes:</strong> {{ reservation.notes || '-' }}
                </div>
                <div class="mb-4">
                    <h3 class="font-semibold mb-2">Guests</h3>
                    <ul>
                        <li v-for="guest in reservation.guests" :key="guest.id">
                            {{ guest.first_name }} {{ guest.last_name }}
                            <span v-if="guest.email">- {{ guest.email }}</span>
                            <span v-if="guest.phone">- {{ guest.phone }}</span>
                        </li>
                    </ul>
                </div>
                <div class="mb-4">
                    <h3 class="font-semibold mb-2">Rooms</h3>
                    <ul>
                        <li v-for="room in reservation.rooms" :key="room.id">
                            Room #{{ room.number }} ({{ room.room_type?.name || '-' }}) - ${{ room.price_per_night }} per night
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { usePage } from '@inertiajs/vue3';
const reservation = usePage().props.reservation;
</script>
