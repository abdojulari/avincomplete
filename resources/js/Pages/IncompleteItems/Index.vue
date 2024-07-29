<template>
    <AVLayout>
        <div v-if="incompleteItems" class="p-8 ">
            <h2>Incomplete Items</h2>
            <ul>
                <li v-for="item in incompleteItems" :key="item.id">
                    <p>ID: {{ item.id }}</p>
                    <p>Location: {{ item.location }}</p>
                    <p>Item ID: {{ item.itemId }}</p>
                </li>
            </ul>
        </div>
        <div v-if="newItem" class="flex flex-col p-2">
            <h2>New Missing Item(s)</h2>
            <form @submit.prevent="submit" class="flex flex-col p-2">
                <p>The item <span class="p-1 bg-red-200 font-bold text-sm">{{ newItem.itemId }}</span> is not found at <span class="p-1 bg-red-200 font-bold text-sm">{{ newItem.location }}</span>!</p>
      
                <label for="report">Do you want to report the missing item?</label>
                <select v-model="reportSelection"  id="report" class="my-5 w-24 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <button type="submit" @click="customerInfo()" 
                    class="w-24 ml-2 bg-blue-800 hover:bg-orange-500 text-white font-bold py-2 px-4 rounded"
                >
                    Let's go!
                </button>
            </form>

        </div>
        <Modal :show="isOpen" @close="closeModal">
            <div class="p-6">
                <form @submit.prevent="submit" class="p-2">
                    <label for="itemID">Item ID</label>
                    <input type="text" id="itemID" v-model="newItem.itemId" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <label for="location">Location</label>
                    <input type="text" id="location" v-model="newItem.location" placeholder="newItem.location" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <label for="description">Description</label>
                    <input type="text" id="description"  class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />

                    <button type="submit" class="w-full ml-2 bg-blue-800 hover:bg-orange-500 text-white font-bold py-2 px-4 rounded">Submit</button>
                </form>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal" class="p-2 border border-gray-200 cursor-pointer"> Cancel </SecondaryButton>
                </div>
            </div>
        </Modal>
    </AVLayout>
</template>

<script setup lang="ts">
import AVLayout from '@/Layouts/AVLayout.vue';
import Modal from '@/Components/Modal.vue';
import { Inertia } from '@inertiajs/inertia';
import { ref, defineProps } from 'vue';

type IncompleteItem = {
    id: number;
    location: number;
    itemId: string;
};


const isOpen = ref(false);
const reportSelection = ref('select');
const props = defineProps<{
    incompleteItems: IncompleteItem[];
    newItem: IncompleteItem;
}>();

const customerInfo = () => {
    reportSelection.value === 'yes' ? isOpen.value = true : Inertia.visit('/');
};

const closeModal = () => {
    isOpen.value = false;
};


// Submission handler
const submit = () => {
    // Handle search submission if necessary

};

</script>
