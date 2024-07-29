<template>
    <AVLayout>
        <div v-if="incompleteItems">
            <h1 class="text-gray-700 text-bold text-3xl leading mb-2">Incomplete Items</h1>
            <!-- Search form -->
            <form @submit.prevent="submit" class="flex items">
                <input
                    type="text"
                    v-model="searchQuery"
                    placeholder="Search by title..."
                    class="w-64 my-2 p-1 border border-gray-200 rounded-md shadow-sm focus:ring-indigo-300 focus:border-indigo-300 sm:text-sm"
                />
            </form>

            <!-- Table with pagination -->
            <div class="overflow-x-auto text-sm bg-white/75 backdrop-blur-sm">
                <table class="min-w-full bg-white/75 backdrop-blur-sm border-gray-200 shadow-md overflow-hidden">
                    <thead class="bg-gray-100 text-gray-600">
                        <tr class="border-b border-black h-10">
                            <th class=" p-1 text-sm text-left">Item ID</th>
                            <th class=" p-1 text-sm text-left">Title</th>
                            <th @click="sortByDate" class=" p-1 text-sm text-left cursor-pointer">
                                Date
                                <span v-if="sortAscending">▲</span>
                                <span v-else>▼</span>
                            </th>
                            <th class="p-1 text-sm text-left">Customer</th>
                            <th class="p-1 text-sm text-left">Contact</th>
                            <th class="p-1 text-sm text-left">Complete</th>
                            <th class="p-1 text-sm text-left">Discard</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in paginatedItems" :key="item.itemId" class="hover:bg-sky-50 even:bg-gray-50 odd:bg-white h-12">
                            <td class="p-1 text-xs font-medium w-20">{{ item.itemId }}</td>
                            <td class="p-1 text-xs w-[28rem]">{{ item.title }}</td>
                            <td class="p-1 text-xs w-20">{{ item.createDate }}</td>
                            <td class="p-1 w-20">
                                <button
                                    @click="customerInfo(item)"
                                    class="border border-sky-500/50 text-sky-500/50 hover:bg-sky-500/50 hover:text-white text-xs rounded-md p-1 w-20"
                                >
                                    Info
                                </button>
                            </td>
                            <td class="p-1 w-20">
                                <button
                                    class="border border-orange-300 text-orange-300 hover:bg-orange-300 hover:text-white text-xs rounded-md p-1 w-20"
                                >
                                    Contacted
                            </button>
                            </td>
                            <td class="p-1 w-20">
                                <button
                                    class="border border-teal-300 text-teal-300 hover:bg-teal-300 hover:text-white text-xs rounded-md p-1 w-20"
                                >
                                    Complete
                            </button>
                            </td>
                            <td class="p-1 w-20">
                                <button
                                    class="border border-red-500 text-red-500 hover:bg-red-500 hover:text-white text-xs rounded-md p-1 w-20"
                                >
                                    Discard
                            </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination controls -->
            <div class="mt-2 flex justify-between">
                <button
                    v-if="currentPage > 1"
                    @click="changePage(currentPage - 1)"
                    class="w-20 bg-blue-500 text-white text-xs rounded-md p-2 cursor-pointer"
                >
                    &laquo; Previous
                </button>
                <button
                    v-if="currentPage < totalPages"
                    @click="changePage(currentPage + 1)"
                    class="w-20 bg-blue-500 text-white text-xs rounded-md p-2 cursor-pointer"
                >
                    Next &raquo;
                </button>
            </div>
        </div>
        <Modal :show="isOpen" @close="closeModal">
            <div class="p-6">
                <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                    <h2 class="text-lg font-medium leading-6">
                        Customer's Information
                    </h2>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Library Card Number
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ selectedItem?.userId }}
                            </dd>
                        </div>
                        <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Customer Name
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ selectedItem?.userName }}
                            </dd>
                        </div>
                        <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Email address
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ selectedItem?.userEmail }}
                            </dd>
                        </div>
                        <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Phone number
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ selectedItem?.userPhone }}
                            </dd>
                        </div>
                        <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Library Branch
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ selectedItem?.location }}
                            </dd>
                        </div>
                        <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Item ID
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ selectedItem?.itemId }}
                            </dd>
                        </div>
                        <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Item Title
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ selectedItem?.title }}
                            </dd>
                        </div>
                        <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Date
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ selectedItem?.createDate }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal" class="cursor-pointer"> Cancel </SecondaryButton>
                </div>
            </div>
        </Modal>
    </AVLayout>
</template>

<script setup lang="ts">
import { ref, computed, defineProps } from 'vue';
import AVLayout from '@/Layouts/AVLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Modal from '@/Components/Modal.vue';

type IncompleteItem = {
    id: number;
    itemId: string;
    title: string;
    createDate: string;
    userId: string;
    userName: string;
    userPhone: string;
    userEmail: string;
    location: string;
};

const isOpen = ref(false);
const selectedItem = ref<IncompleteItem | null>(null);
const props = defineProps<{
    incompleteItems: IncompleteItem[];
}>();

const customerInfo = (item: IncompleteItem) => {
    selectedItem.value = item;
    isOpen.value = true;
};

const searchQuery = ref<string>('');
const sortAscending = ref<boolean>(true);
const currentPage = ref<number>(1);
const pageSize = 10;

// Filter and sort items based on search query and sort order
const filteredSortedItems = computed(() => {
    let items = [...props.incompleteItems];
    // Filter by search query
    if (searchQuery.value) {
        items = items.filter(item =>
            item.title.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    }

    // Sort by date
    items.sort((a, b) => {
        const dateA = new Date(a.createDate);
        const dateB = new Date(b.createDate);
        return sortAscending.value ? dateA.getTime() - dateB.getTime() : dateB.getTime() - dateA.getTime();
    });

    return items;
});

// Paginate the sorted items
const paginatedItems = computed(() => {
    const start = (currentPage.value - 1) * pageSize;
    const end = start + pageSize;
    return filteredSortedItems.value.slice(start, end);
});

// Calculate total pages
const totalPages = computed(() => {
    return Math.ceil(filteredSortedItems.value.length / pageSize);
});

// Change the current page
const changePage = (newPage: number) => {
    if (newPage >= 1 && newPage <= totalPages.value) {
        currentPage.value = newPage;
    }
};

// Sort items by date
const sortByDate = () => {
    sortAscending.value = !sortAscending.value;
};

// Reset the date format when component is mounted
props.incompleteItems.forEach((item: IncompleteItem) => {
    const date = new Date(item.createDate);
    item.createDate = date.toISOString().split('T')[0];
});

// Submission handler
const submit = () => {
    // Handle search submission if necessary
};

const closeModal = () => {
    isOpen.value = false;
};
</script>
