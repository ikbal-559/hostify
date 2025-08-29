<template>
    <GuestLayout :title="`Book Room #${room.number}`">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Book Room #{{ room.number }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
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
                                <div v-for="(guest, idx) in form.guests" :key="idx" class="border rounded p-3 mb-2 bg-gray-50 dark:bg-gray-700">
                                    <div class="flex gap-2 mb-2">
                                        <input v-model="guest.first_name" type="text" placeholder="First Name" class="rounded border-gray-300 dark:bg-gray-800 dark:text-gray-100 w-1/2" required />
                                        <input v-model="guest.last_name" type="text" placeholder="Last Name" class="rounded border-gray-300 dark:bg-gray-800 dark:text-gray-100 w-1/2" required />
                                    </div>
                                    <div class="flex gap-2 mb-2">
                                        <input v-model="guest.email" type="email" placeholder="Email (optional)" class="rounded border-gray-300 dark:bg-gray-800 dark:text-gray-100 w-1/2" />
                                        <input v-model="guest.phone" type="text" placeholder="Phone (optional)" class="rounded border-gray-300 dark:bg-gray-800 dark:text-gray-100 w-1/2" />
                                    </div>
                                    <div class="flex gap-2 mb-2">
                                        <input v-model="guest.date_of_birth" type="date" placeholder="Date of Birth (optional)" class="rounded border-gray-300 dark:bg-gray-800 dark:text-gray-100 w-1/2" />
                                        <select v-model="guest.gender" class="rounded border-gray-300 dark:bg-gray-800 dark:text-gray-100 w-1/2">
                                            <option value="">Gender (optional)</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <button v-if="form.guests.length > 1" type="button" @click="form.guests.splice(idx, 1)" class="text-red-600 text-xs mt-1">Remove Guest</button>
                                </div>
                                <button type="button" @click="form.guests.push({first_name:'',last_name:'',email:'',phone:'',date_of_birth:'',gender:''})" class="text-blue-600 text-xs">+ Add Guest</button>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 mb-1">Notes</label>
                                <textarea v-model="form.notes" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100 w-full" rows="2" placeholder="Special requests or notes (optional)"></textarea>
                            </div>
                            <!-- Room selection is hidden, as this page is for a single room, but backend expects array -->
                            <input type="hidden" v-model="form.room_ids[0]" />
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
    check_in: ref(usePage().props.startDate ?? ''),
    check_out: ref(usePage().props.endDate ?? ''),
    guests: [
        {
            first_name: '',
            last_name: '',
            email: '',
            phone: '',
            date_of_birth: '',
            gender: '',
        }
    ],
    room_ids: [room.id],
    notes: '',
});
 

function submit() {
    form.post(route('reservations.store'));
}
</script>

<style scoped>
/* Add your styles here if needed */
</style>
