
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import PrimarySubmitButton from '@/Components/PrimarySubmitButton.vue';

const form = useForm({
    name: '',
});

function submit() {
    form.post(route('room-types.store'));
}
</script>

<template>
    <AppLayout title="Create Room Type">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create Room Type
            </h2>
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
                                    Create
                                </PrimarySubmitButton>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </AppLayout>
</template>
