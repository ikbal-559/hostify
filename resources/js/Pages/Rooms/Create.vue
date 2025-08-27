
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimarySubmitButton from '@/Components/PrimarySubmitButton.vue';
import { VTextField, VSelect, VTextarea, VCheckbox, VFileInput, VBtn, VRow, VCol } from 'vuetify/components';
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
                        <v-row dense>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.number"
                                    label="Room Number"
                                    :error-messages="form.errors.number ? [form.errors.number] : []"
                                    autofocus
                                />
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-select
                                    v-model="form.room_type_id"
                                    :items="roomTypes.map(type => ({ title: type.name, value: type.id }))"
                                    label="Room Type"
                                    :error-messages="form.errors.room_type_id ? [form.errors.room_type_id] : []"
                                    item-title="title"
                                    item-value="value"
                                    :return-object="false"
                                />
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-select
                                    v-model="form.availability_status"
                                    :items="[
                                        { title: 'Available', value: '1' },
                                        { title: 'Occupied', value: '2' },
                                        { title: 'Maintenance', value: '3' }
                                    ]"
                                    label="Availability Status"
                                    :error-messages="form.errors.availability_status ? [form.errors.availability_status] : []"
                                    item-title="title"
                                    item-value="value"
                                    :return-object="false"
                                />
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-select
                                    v-model="form.bed_type"
                                    :items="[
                                        { title: 'Single Bed', value: '1' },
                                        { title: 'Double Bed', value: '2' },
                                        { title: 'Two Single Beds', value: '3' },
                                        { title: 'Family Room', value: '4' }
                                    ]"
                                    label="Bed Type"
                                    :error-messages="form.errors.bed_type ? [form.errors.bed_type] : []"
                                    item-title="title"
                                    item-value="value"
                                    :return-object="false"
                                />
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.number_of_beds"
                                    label="Number of Beds"
                                    type="number"
                                    :error-messages="form.errors.number_of_beds ? [form.errors.number_of_beds] : []"
                                />
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-textarea
                                    v-model="form.description"
                                    label="Description"
                                    :error-messages="form.errors.description ? [form.errors.description] : []"
                                />
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-file-input
                                    v-model="form.thumbnail"
                                    label="Thumbnail Image"
                                    accept="image/*"
                                    :error-messages="form.errors.thumbnail ? [form.errors.thumbnail] : []"
                                    @change="handleFileChange"
                                />
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.price_per_night"
                                    label="Price Per Night"
                                    type="number"
                                    step="0.01"
                                    :error-messages="form.errors.price_per_night ? [form.errors.price_per_night] : []"
                                />
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.capacity"
                                    label="Capacity"
                                    type="number"
                                    :error-messages="form.errors.capacity ? [form.errors.capacity] : []"
                                />
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.floor"
                                    label="Floor"
                                    type="number"
                                    :error-messages="form.errors.floor ? [form.errors.floor] : []"
                                />
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.room_size"
                                    label="Room Size"
                                    :error-messages="form.errors.room_size ? [form.errors.room_size] : []"
                                />
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.view"
                                    label="View"
                                    :error-messages="form.errors.view ? [form.errors.view] : []"
                                />
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-checkbox
                                    v-model="form.smoking_allowed"
                                    label="Smoking Allowed"
                                    :error-messages="form.errors.smoking_allowed ? [form.errors.smoking_allowed] : []"
                                />
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-textarea
                                    v-model="form.special_notes"
                                    label="Special Notes"
                                    :error-messages="form.errors.special_notes ? [form.errors.special_notes] : []"
                                />
                            </v-col>
                        </v-row>
                        <div class="flex items-center justify-between mt-6">
                            <v-btn :loading="form.processing" color="primary" type="submit" variant="flat">
                                Create
                            </v-btn>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
