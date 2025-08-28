<template>
    <GuestLayout :title="`Book Room #${room.number}`">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Book Room #{{ room.number }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 flex flex-col sm:flex-row gap-8">
                    <div class="w-full sm:w-1/2 flex flex-col items-center">
                        <img v-if="room.thumbnail" :src="`/storage/${room.thumbnail}`" alt="Room Thumbnail" class="object-cover w-full max-w-xs h-48 rounded mb-4 border border-gray-200 dark:border-gray-700" />
                        <div class="font-bold text-lg text-blue-700 dark:text-blue-300 mb-2">Room #{{ room.number }}</div>
                        <div class="text-gray-700 dark:text-gray-200 mb-1">Type: <span class="font-semibold">{{ room.room_type?.name ?? '-' }}</span></div>
                        <div class="text-gray-700 dark:text-gray-200 mb-1">Bed: <span class="font-semibold">{{ room.bed_type || '-' }}</span></div>
                        <div class="text-gray-700 dark:text-gray-200 mb-1">Price: <span class="font-semibold">{{ room.price_per_night ? `$${room.price_per_night}` : '-' }}</span></div>
                        <div class="text-gray-700 dark:text-gray-200 mb-1">Capacity: <span class="font-semibold">{{ room.capacity || '-' }}</span></div>
                        <div class="text-gray-700 dark:text-gray-200 mb-1">Floor: <span class="font-semibold">{{ room.floor || '-' }}</span></div>
                        <div class="text-gray-700 dark:text-gray-200 mb-1">Room Size: <span class="font-semibold">{{ room.room_size || '-' }}</span></div>
                        <div class="text-gray-700 dark:text-gray-200 mb-1">View: <span class="font-semibold">{{ room.view || '-' }}</span></div>
                        <div class="text-gray-700 dark:text-gray-200 mb-1">Smoking Allowed: <span class="font-semibold">{{ room.smoking_allowed ? 'Yes' : 'No' }}</span></div>
                        <div class="text-gray-500 dark:text-gray-400 text-xs mt-1">{{ room.description }}</div>
                    </div>
                    <div class="w-full sm:w-1/2 flex flex-col justify-center">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Reservation Details</h3>
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 mb-1">Check-in Date</label>
                                <input v-model="form.check_in" type="date" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100 w-full" required />
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 mb-1">Check-out Date</label>
                                <input v-model="form.check_out" type="date" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100 w-full" required />
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 mb-1">Guests</label>
                                <input v-model.number="form.guests" type="number" min="1" :max="room.capacity || 10" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100 w-full" required />
                            </div>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded shadow transition-colors duration-150 w-full mt-2">
                                Confirm Booking
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

const room = usePage().props.room;

const form = useForm({
    check_in: '',
    check_out: '',
    guests: 1,
});

function submit() {
    // You can implement the booking logic here, e.g.,
    // form.post(route('reservations.store', { room: room.id }))
    alert('Booking submitted! (Implement backend logic)');
}
</script>

<style scoped>
/* Add your styles here if needed */
</style>
