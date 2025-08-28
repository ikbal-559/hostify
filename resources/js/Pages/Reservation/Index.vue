<template>
    <GuestLayout title="Reservations">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Reservations
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <!-- Filters -->
                    <div class="flex flex-col md:flex-row gap-4 mb-6">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-200 mb-1">Room Type</label>
                            <select v-model="selectedRoomType"
                                class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">All</option>
                                <option v-for="type in roomTypes" :key="type.id" :value="type.id">{{ type.name }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-200 mb-1">Bed Type</label>
                            <select v-model="selectedBedType"
                                class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">All</option>
                                <option v-for="bed in bedTypes" :key="bed" :value="bed">{{ bed }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Room Cards -->
                    <div v-if="filteredRooms.length" class="flex flex-col gap-6">
                        <div v-for="room in filteredRooms" :key="room.id"
                            class="bg-white dark:bg-gray-900 rounded-lg shadow flex flex-col sm:flex-row overflow-hidden">
                            <div
                                class="w-full sm:w-48 min-w-0 sm:min-w-[280px] sm:max-w-[320px] flex items-center justify-center bg-gray-100 dark:bg-gray-800">
                                <img v-if="room.thumbnail" :src="`/storage/${room.thumbnail}`" alt="Room Thumbnail"
                                    class="object-cover w-full h-full sm:border-r border-b sm:border-b-0 border-gray-200 dark:border-gray-700" />
                            </div>
                            <div class="flex-1 p-5 flex flex-col">
                                <div class="flex justify-between items-center">
                                    <div class="font-bold text-lg text-blue-700 dark:text-blue-300 mb-2">
                                        Room #{{ room.number }}
                                    </div>
                                    <div class="flex justify-end mt-4">
                                        <BasicButton 
                                         @click="$inertia.visit(route('reservation.book', { reservation: room.id }))"
                                         customClass="px-3 py-1">
                                            Book Now
                                        </BasicButton>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-1 mb-2">
                                    <div class="text-gray-700 dark:text-gray-200">Type: <span class="font-semibold">{{
                                            room.room_type?.name ?? '-' }}</span></div>
                                    <div class="text-gray-700 dark:text-gray-200">Bed: <span class="font-semibold">{{
                                            room.bed_type || '-' }}</span></div>
                                    <div class="text-gray-700 dark:text-gray-200">Price: <span class="font-semibold">{{
                                        room.price_per_night ? `$${room.price_per_night}` : '-' }}</span></div>
                                    <div class="text-gray-700 dark:text-gray-200">Capacity: <span
                                            class="font-semibold">{{
                                            room.capacity || '-' }}</span></div>
                                    <div class="text-gray-700 dark:text-gray-200">Floor: <span class="font-semibold">{{
                                            room.floor || '-' }}</span></div>
                                    <div class="text-gray-700 dark:text-gray-200">Room Size: <span
                                            class="font-semibold">{{
                                            room.room_size || '-' }}</span></div>
                                    <div class="text-gray-700 dark:text-gray-200">View: <span class="font-semibold">{{
                                            room.view
                                            || '-' }}</span></div>
                                    <div class="text-gray-700 dark:text-gray-200">Smoking Allowed: <span
                                            class="font-semibold">{{ room.smoking_allowed ? 'Yes' : 'No' }}</span></div>
                                </div>
                                <div class="text-gray-500 dark:text-gray-400 text-xs mt-1">{{ room.description }}</div>

                            </div>
                        </div>
                    </div>
                    <div v-else class="text-gray-500 dark:text-gray-400 text-center py-8">No rooms found.</div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>

import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import BasicButton from '@/Components/BasicButton.vue';

let roomsRaw = usePage().props.rooms || [];
// If using Laravel Resource Collection, data is under .data
const rooms = Array.isArray(roomsRaw) ? roomsRaw : (roomsRaw.data || []);
const roomTypes = usePage().props.roomTypes || [];

// Collect all unique bed types from rooms
const bedTypes = Array.from(new Set(rooms.map(r => r.bed_type).filter(Boolean)));

const selectedRoomType = ref('');
const selectedBedType = ref('');

const filteredRooms = computed(() => {
    return rooms.filter(room => {
        const matchType = !selectedRoomType.value || room.room_type?.id == selectedRoomType.value;
        const matchBed = !selectedBedType.value || room.bed_type == selectedBedType.value;
        return matchType && matchBed;
    });
});
</script>

<style scoped>
/* Add your styles here if needed */
</style>
