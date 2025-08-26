
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import PrimarySubmitButton from '@/Components/PrimarySubmitButton.vue';

const roomType = usePage().props.roomType;
const form = useForm({
    name: roomType.name || '',
});

function submit() {
    form.put(route('room-types.update', roomType.id));
}
</script>

<template>
    <AppLayout title="Edit Room Type">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Edit Room Type
                </h2>
                <button @click="$inertia.visit(route('room-types.index'))" class="ml-4 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    View All
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="name">
                                Name
                            </label>
                            <input v-model="form.name" id="name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" :class="{'border-red-500': form.errors.name}" autofocus>
                            <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                        </div>
                        <div class="flex items-center justify-between">
                            <PrimarySubmitButton :disabled="form.processing">
                                Update
                            </PrimarySubmitButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
