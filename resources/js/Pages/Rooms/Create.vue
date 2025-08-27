
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimarySubmitButton from '@/Components/PrimarySubmitButton.vue';

const roomTypes = usePage().props.roomTypes || [];
const form = useForm({
    number: '',
    room_type_id: '',
    availability_status: '',
    bed_type: '',
    number_of_beds: '',
    description: '',
    thumbnail: null,
    price_per_night: '',
    capacity: '',
    floor: '',
    room_size: '',
    view: '',
    smoking_allowed: false,
    special_notes: '',
});
function handleFileChange(e) {
    form.thumbnail = e.target.files[0];
}
function submit() {
    form.post(route('rooms.store'), {
        forceFormData: true
    });
}
</script>

<template>
    <AppLayout title="Create Room">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create Room
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="number">
                                    Room Number
                                </label>
                                <input v-model="form.number" id="number" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" :class="{'border-red-500': form.errors.number}" autofocus>
                                <div v-if="form.errors.number" class="text-red-500 text-xs mt-1">{{ form.errors.number }}</div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="room_type_id">
                                    Room Type
                                </label>
                                <select v-model="form.room_type_id" id="room_type_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" :class="{'border-red-500': form.errors.room_type_id}">
                                    <option value="">Select Room Type</option>
                                    <option v-for="type in roomTypes" :key="type.id" :value="type.id">{{ type.name }}</option>
                                </select>
                                <div v-if="form.errors.room_type_id" class="text-red-500 text-xs mt-1">{{ form.errors.room_type_id }}</div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="availability_status">
                                    Availability Status
                                </label>
                                <select v-model="form.availability_status" id="availability_status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" :class="{'border-red-500': form.errors.availability_status}">
                                    <option value="">Select Status</option>
                                    <option value="1">Available</option>
                                    <option value="2">Occupied</option>
                                    <option value="3">Maintenance</option>
                                </select>
                                <div v-if="form.errors.availability_status" class="text-red-500 text-xs mt-1">{{ form.errors.availability_status }}</div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="bed_type">
                                    Bed Type
                                </label>
                                <select v-model="form.bed_type" id="bed_type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" :class="{'border-red-500': form.errors.bed_type}">
                                    <option value="">Select Bed Type</option>
                                    <option value="1">Single Bed</option>
                                    <option value="2">Double Bed</option>
                                    <option value="3">Two Single Beds</option>
                                    <option value="4">Family Room</option>
                                </select>
                                <div v-if="form.errors.bed_type" class="text-red-500 text-xs mt-1">{{ form.errors.bed_type }}</div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="number_of_beds">
                                    Number of Beds
                                </label>
                                <input v-model="form.number_of_beds" id="number_of_beds" type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" :class="{'border-red-500': form.errors.number_of_beds}">
                                <div v-if="form.errors.number_of_beds" class="text-red-500 text-xs mt-1">{{ form.errors.number_of_beds }}</div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="description">
                                    Description
                                </label>
                                <textarea v-model="form.description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" :class="{'border-red-500': form.errors.description}"></textarea>
                                <div v-if="form.errors.description" class="text-red-500 text-xs mt-1">{{ form.errors.description }}</div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="price_per_night">
                                    Price Per Night
                                </label>
                                <input v-model="form.price_per_night" id="price_per_night" type="number" step="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" :class="{'border-red-500': form.errors.price_per_night}">
                                <div v-if="form.errors.price_per_night" class="text-red-500 text-xs mt-1">{{ form.errors.price_per_night }}</div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="capacity">
                                    Capacity
                                </label>
                                <input v-model="form.capacity" id="capacity" type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" :class="{'border-red-500': form.errors.capacity}">
                                <div v-if="form.errors.capacity" class="text-red-500 text-xs mt-1">{{ form.errors.capacity }}</div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="floor">
                                    Floor
                                </label>
                                <input v-model="form.floor" id="floor" type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" :class="{'border-red-500': form.errors.floor}">
                                <div v-if="form.errors.floor" class="text-red-500 text-xs mt-1">{{ form.errors.floor }}</div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="room_size">
                                    Room Size
                                </label>
                                <input v-model="form.room_size" id="room_size" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" :class="{'border-red-500': form.errors.room_size}">
                                <div v-if="form.errors.room_size" class="text-red-500 text-xs mt-1">{{ form.errors.room_size }}</div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="view">
                                    View
                                </label>
                                <input v-model="form.view" id="view" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" :class="{'border-red-500': form.errors.view}">
                                <div v-if="form.errors.view" class="text-red-500 text-xs mt-1">{{ form.errors.view }}</div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="smoking_allowed">
                                    Smoking Allowed
                                </label>
                                <input v-model="form.smoking_allowed" id="smoking_allowed" type="checkbox" class="mr-2 leading-tight dark:bg-gray-800 dark:border-gray-600">
                                <span class="text-sm dark:text-white">Yes</span>
                                <div v-if="form.errors.smoking_allowed" class="text-red-500 text-xs mt-1">{{ form.errors.smoking_allowed }}</div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="special_notes">
                                    Special Notes
                                </label>
                                <textarea v-model="form.special_notes" id="special_notes" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" :class="{'border-red-500': form.errors.special_notes}"></textarea>
                                <div v-if="form.errors.special_notes" class="text-red-500 text-xs mt-1">{{ form.errors.special_notes }}</div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="thumbnail">
                                    Thumbnail Image
                                </label>
                                <input @change="handleFileChange" id="thumbnail" type="file" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" :class="{'border-red-500': form.errors.thumbnail}">
                                <div v-if="form.errors.thumbnail" class="text-red-500 text-xs mt-1">{{ form.errors.thumbnail }}</div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-6">
                            <PrimarySubmitButton :disabled="form.processing">
                                Create
                            </PrimarySubmitButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
