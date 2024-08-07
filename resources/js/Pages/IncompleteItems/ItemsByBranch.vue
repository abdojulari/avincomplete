<template>
    <AVLayout>
        <div v-if="incompleteItems">
            <h1 class="text-gray-700 text-bold text-3xl leading-10 mb-2">Incomplete Items</h1>
            <!-- Search form -->
            <form for="search and filter" @submit.prevent="submit" class="flex flex-col md:flex-row justify-between">
                <div class="flex my-2 px-2 md:my-5">
                    <div class="">
                        <label for="pageSize" class="font-bold px-1">Items per page:</label>
                        <select
                            id="pageSize"
                            v-model="form.pageSize"
                            class="w-full md:w-16 p-1 border border-gray-200 rounded-md shadow-sm focus:ring-indigo-300 focus:border-indigo-300 sm:text-sm"
                        >
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <div class="md:mx-4">
                        <label for="filterBy" class="font-bold px-1">Filter by:</label>
                        <select
                            id="filterBy"
                            v-model="form.filter"
                            class="w-full md:w-32 p-1 border border-gray-200 rounded-md shadow-sm focus:ring-indigo-300 focus:border-indigo-300 sm:text-sm"
                        >
                            <option value="">All</option>
                            <option value="contact">Contacted</option>
                            <option value="complete">Completed</option>
                            <option value="discard">Discarded</option>
                        </select>
                    </div>
                </div>
                <input
                    name="search"
                    type="text"
                    v-model="searchQuery"
                    placeholder="Search by title..."
                    class="w-full md:w-64 md:h-8 my-2 md:my-5 p-1 border border-gray-200 rounded-md shadow-sm focus:ring-indigo-300 focus:border-indigo-300 sm:text-sm"
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
                            <td class="p-1 text-xs w-20">{{ createDateString(item.createDate) }}</td>
                            <td class="p-1 w-20">
                                <button
                                    @click="actionButton('info', item)"
                                    class="
                                        border border-sky-900/50 text-sky-900/50 
                                        hover:bg-sky-500/50 hover:text-white hover:border-sky-500/50 
                                        text-xs rounded-md p-1 w-20 font-bold"
                                >
                                    Info
                                </button>
                            </td>
                            <td class="p-1 w-20">
                                <button
                                    @click="actionButton('contact', item)"
                                    class="border border-orange-900 text-orange-900 
                                    hover:bg-orange-300 hover:text-white hover:border-orange-300
                                    text-xs rounded-md p-1 w-20 font-bold"
                                >
                                    Contacted
                                </button>
                            </td>
                            <td class="p-1 w-20">
                                <button
                                    @click="actionButton('complete', item)"
                                    class="border border-teal-900 text-teal-900 
                                    hover:bg-teal-300 hover:text-white hover:border-teal-300
                                    text-xs rounded-md p-1 w-20 font-bold"
                                >
                                    Complete
                            </button>
                            </td>
                            <td class="p-1 w-20">
                                <button
                                    @click="actionButton('discard', item)"
                                    class="border border-red-900 text-red-900 
                                    hover:bg-red-500 hover:text-white hover:border-red-500
                                    text-xs rounded-md p-1 w-20 font-bold"
                                >
                                    Discard
                            </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination controls -->
            <div class="mt-6 flex justify-between">
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
               <!-- Modals -->
               <Modal :show="isOpen" @close="closeModal">
            <div class="p-6">
                <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                    <h2 class="text-lg font-medium leading-6">Customer's Information</h2>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div v-for="(value, key) in selectedItemInfo" :key="key" class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">{{ key }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ value }}</dd>
                        </div>
                    </dl>
                </div>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal" class="cursor-pointer">Cancel</SecondaryButton>
                </div>
            </div>
        </Modal>
        <!-- modal for action buttons -->
         <Modal :show="showModal" >
            <div class="p-6 flex flex-col">
                <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3 mb-5" role="alert">
                    <h2 class="text-lg font-medium leading-6">
                        Alert
                    </h2>
                </div>
                <div class="font-medium" v-html="message"></div>
                <div class="flex justify-end">
                    <SecondaryButton @click="showModal = false" class="cursor-pointer"> Close </SecondaryButton>
                </div>
            </div>
         </Modal>
    </AVLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, computed, defineProps, reactive } from 'vue';
import AVLayout from '@/Layouts/AVLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Modal from '@/Components/Modal.vue';
import { router } from '@inertiajs/vue3';
import { IncompleteItem } from '@/types/incomplete';

const isOpen = ref(false);
const showModal = ref(false);
const message = ref('');
const selectedItem = ref<IncompleteItem | null>(null);
const props = defineProps<{
    incompleteItems: IncompleteItem[];
}>();

const actionButton = (actionType:  'info' | 'contact' | 'complete' | 'discard', item: IncompleteItem) => {
    const now = new Date().toISOString().split('T')[0];
    let messageText = '';
    
    switch(actionType) {
        case 'info':
            selectedItem.value = item;
            isOpen.value = true;
            break;
        case 'contact':
            item.contact = true;
            item.contactDate = now;
            messageText = `<p class="w-full">Contacted customer flag set on 
                        <span class="bg-gray-400 text-white font-bold p-1 w-32">
                            ${item.itemId}
                        </span>
                        for this user: ${item.userName}</p>`;
            showModal.value = true;
            break;
        case 'complete':
            item.complete = true;
            item.completeDate = now;
            messageText = `<p class="w-full">Congratulations! This item 
                        <span class="bg-gray-400 text-white font-bold p-1 w-32">
                        ${item.itemId} 
                        </span>
                        is marked as completed</p>`;
            showModal.value = true;
            break;
        case 'discard':
            item.discard = true;
            item.discardDate = now;
            messageText = `<p>Item <span class="bg-gray-400 text-white font-bold p-1 w-32"> 
                            ${item.itemId} </span> has been discarded!</p>`;
            showModal.value = true;
            break;
    }
    message.value = messageText;
    updateItem(item);
};

const searchQuery = ref<string>('');
const sortAscending = ref<boolean>(true);
const currentPage = ref<number>(1);

const form = reactive({
    pageSize: 10,
    filter: '',
});
// Filter and sort items based on search query and sort order
const filteredSortedItems = computed(() => {
    let items = [...props.incompleteItems];
    // Filter by search query
    if (searchQuery.value) {
        items = items.filter(item =>
            item.title.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    }

    // Filter based on the selected filter option where contact is true, complete is true or discard is true

   
    // Sort by date
    items.sort((a, b) => {
        const dateA = new Date(a.createDate);
        const dateB = new Date(b.createDate);
        return sortAscending.value ? dateA.getTime() - dateB.getTime() : dateB.getTime() - dateA.getTime();
    });

    if (form.filter === 'contact') {
        return items = items.filter(item => {
            console.log('something pole', item.contact);
            return item.contact;
        });
        
    } 
    else if (form.filter === 'complete') {
        return items = items.filter(item => {
            console.log('something pole', item.complete);
            return item.complete;
        });
    }
    else if (form.filter === 'discard') {
        return items = items.filter(item => {
            console.log('something pole', item.discard);
            return item.discard;
        });
    }
    else {
        return items;
    }
    
});

// Paginate the sorted items
const paginatedItems = computed(() => {
    const start = (currentPage.value - 1) * form.pageSize;
    const end = start + form.pageSize;
    return filteredSortedItems.value.slice(start, end);
});

// Calculate total pages
const totalPages = computed(() => {
    return Math.ceil(filteredSortedItems.value.length / form.pageSize);
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

// Submission handler
const submit = () => {
    // Handle search submission if necessary
};

const closeModal = () => {
    isOpen.value = false;
};

const createDateString = (date: string) => {
    return new Date(date).toISOString().split('T')[0];
};

// update the changes to the database i.e. if the item has been contacted, completed or discarded
const updateItem = (item: IncompleteItem) => {
    router.put(`/branchitems/${item.id}`, item, {
        preserveState: true,
        onSuccess: () => console.log('Item updated successfully'),
        onError: () => console.error('Failed to update item'),
    });
};

// Extract information from the selected item
const selectedItemInfo = computed(() => {
    if (!selectedItem.value) return {};
    return {
        'Library Card Number': selectedItem.value.userId,
        'Customer Name': selectedItem.value.userName,
        'Email address': selectedItem.value.userEmail,
        'Phone number': selectedItem.value.userPhone,
        'Library Branch': selectedItem.value.location,
        'Item ID': selectedItem.value.itemId,
        'Item Title': selectedItem.value.title,
        'Description': selectedItem.value.comments,
        'Date': createDateString(selectedItem.value.createDate),
    };
});
</script>
