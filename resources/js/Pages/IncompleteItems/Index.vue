<template>
    <AVLayout>
        <div v-if="props.incompleteItems" class="p-8">
            <h2 class="px-1 font-bold text-3xl my-5">Incomplete Items</h2>
            <ul>
                <li class="text-2xl leading-10" v-for="item in props.incompleteItems" :key="item.id">
                    <p>ID: {{ item.id }}</p>
                    <p>Location: {{ item.location }}</p>
                    <p>Item ID: {{ item.itemId }}</p>
                </li>
            </ul>
        </div>
        <div v-if="props.newItem" class="flex flex-col p-2">
            <h2 class="px-1 font-bold text-3xl my-5">New Missing Item(s)</h2>
            <form @submit.prevent="()=> {}" class="flex flex-col p-1">
                <p class="text-2xl leading-8">The item <span class="p-1 bg-red-200 font-bold text-2xl">{{ props.newItem.itemId }}</span> is not already reported missing at <span class="p-1 bg-red-200 font-bold text-sm">{{ props.newItem.location }}</span>!</p>
                <div class="flex my-4">
                    <label class="text-3xl text-red-700 font-bold pr-2" for="reportSelection">Do you want to report this item missing?</label>
                    <select v-model="reportSelection" id="reportSelection" class="w-24 ml-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="select">Take action</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                
                <button type="submit" @click="customerInfo()" class="w-24 ml-2 bg-blue-800 hover:bg-orange-500 text-white font-bold py-2 px-4 rounded">Let's go!</button>
            </form>
        </div>
        <Modal :show="isOpen" @close="closeModal">
            <div class="p-6">
                <form @submit.prevent="submit" class="p-2">
                    <label for="itemID">Item ID</label>
                    <input type="text" id="itemID" v-model="props.newItem.itemId" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <label for="location">Location</label>
                    <input type="text" id="location" v-model="props.newItem.location" placeholder="newItem.location" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <label for="tags">Missing Items</label>
                    <MultiSelect
                        :options="tagOptions"
                        :selectedTags="selectedTags"
                        @update:selectedTags="tags => selectedTags = tags"
                    />
                    <label for="description">Description</label>
                    <textarea  type="text" id="description" cols="10" rows="5" v-model="props.newItem.description" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <button 
                        type="submit" 
                        class="w-full ml-2 bg-blue-800 hover:bg-orange-500 text-white font-bold py-2 px-4 rounded">
                        Submit
                    </button>
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
import MultiSelect from '@/Components/MultiSelect.vue';

type IncompleteItem = {
    id: number;
    location: number;
    itemId: string;
    description?: string; 
};
const selectedTags = ref<string[]>([]);
const tagOptions = ref<string[]>([
    'Case is missing',
    'Insert / Booklet missing',
    'Disc is missing',
    'Disc 1 is missing',
    'Disc 2 is missing',
    'Disc 3 is missing',
    'Several discs are missing',
    'Case does not belong to EPL',
    'Disc does not belong to EPL',
    'Book is missing',
    'Puppet is missing',
    'Map is missing',
    'Pattern is missing',
]);
const isOpen = ref(false);
const reportSelection = ref<string>('select');
const props = defineProps<{
    incompleteItems: IncompleteItem[];
    newItem: IncompleteItem;
}>();

const customerInfo = () => {
    if (reportSelection.value === 'yes') {
        isOpen.value = true;
    } else {
        Inertia.visit('/');
    }
};

const closeModal = () => {
    isOpen.value = false;
};

// Submission handler
const submit = () => {
  // Prepare data for submission
  const data = {
    ...props.newItem,
    tags: selectedTags.value, // Include selected tags here
  };

  console.log(data);
  
  // Example using Inertia to submit data
//   Inertia.post('/your-endpoint', data, {
//     onSuccess: () => {
//       // Handle success, e.g., redirect or show a success message
//     },
//     onError: (errors) => {
//       // Handle errors, e.g., show error messages
//     }
//   });
};

</script>
