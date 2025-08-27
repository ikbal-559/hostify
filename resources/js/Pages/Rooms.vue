
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage } from '@inertiajs/vue3';
const rooms = usePage().props.rooms || [];

function editRoom(id) {
  window.location = route('rooms.edit', id);
}
</script>

<template>
  <AppLayout title="Rooms">
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          Rooms
        </h2>
        <button @click="$inertia.visit(route('rooms.create'))" class="ml-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
          + Create
        </button>
      </div>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
          <div v-if="rooms.length">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
              <thead class="bg-blue-100 dark:bg-blue-900">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-100 uppercase tracking-wider">ID</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-100 uppercase tracking-wider">Room Number</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-100 uppercase tracking-wider">Room Type</th>
                  <th class="px-6 py-3"></th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <tr v-for="room in rooms" :key="room.id">
                  <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ room.id }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ room.number }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ room.room_type?.name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-right">
                    <button @click="editRoom(room.id)" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-200 transition">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 10-4-4l-8 8v3z" />
                      </svg>
                       Edit
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div v-else class="p-4 dark:text-white">No rooms found.</div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
