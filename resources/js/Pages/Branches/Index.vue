<template>
    <Head title="Branches" />
    <AVLayout>
        <div class="container mx-auto">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Incomplete Items</h2>
        
            <div class="flex flex-col mt-4">
                <form @submit.prevent="submit" class="flex items-center flex-col w-full">
                    <label for="branches" class="w-full my-2 font-bold">Select your branch:</label>
                    <select id="selectedBranch" v-model="form.selectedBranch" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option 
                            v-for="branch in branches" 
                            :key="branch.id" 
                            :value="branch.id"
                        >
                            {{ branch.name }}
                        </option>
                    </select>
                    <input 
                        placeholder="Item ID" 
                        type="text" 
                        id="itemID" 
                        v-model="form.itemID" 
                        class="
                            w-full my-5 border border-gray-300 
                            rounded-md shadow-sm focus:ring-indigo-500 
                            focus:border-indigo-500 sm:text-sm" 
                        />
                    <button type="submit" class="w-full ml-2 bg-blue-800 hover:bg-orange-500 text-white font-bold py-2 px-4 rounded">Let's go!</button>
                </form>
                <div class="w-full text-gray-800 py-5">
                    <p class="text-sm font-bold">Edmonton Public Library | &copy; {{ new Date().getFullYear() }} All rights reserved.</p>
                    <p class="text-xs"> Click here for <Link href="/" class="text-indigo-500" as="button" type="button"> Help </Link></p>
                </div> 
            </div>
        </div>
    </AVLayout>
</template>

<script setup lang="ts">
import { defineProps, ref, onMounted, reactive } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import AVLayout from '@/Layouts/AVLayout.vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { router } from '@inertiajs/vue3';

// Define a type for branches
type Branch = {
    id: number;
    name: string;
};

// Use defineProps to define the type of the incoming props
const props = defineProps<{
    branches: Branch[];
}>();

const branches = ref(props.branches);

onMounted(() => {
    // console.log(branches.value); 
});

// Use reactive to define the form object and its properties
// use type assertion to define the type of the form object

const form = reactive({
    selectedBranch: null,
    itemID: null
});

// Define a function to handle the form submission with typescript

const submit = () => {
    // check if form.itemID is null then route to /branchitems
    form.itemID === null ? router.get('/branchitems', { location: form.selectedBranch }) : router.get('/branch', { location: form.selectedBranch, itemId: form.itemID });
   
};
</script>


