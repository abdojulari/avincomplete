<template>
    <AVLayout>
        <Head title="Report New Missing Item(s)" />
        <div class="w-full">
            <ul>
                <li v-for="item in incompleteItems" :key="item.id">
                    <p>ID: {{ item.id }}</p>
                    <p>Item ID: {{ item.itemId }}</p>
                    <p>Location: The item not found at the location specified {{ item.location }}, do you want to report the missing item</p>
                </li>
            </ul>

        </div>
    </AVLayout>
</template>

<script setup lang="ts">

import AVLayout from '@/Layouts/AVLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { defineProps, ref, onMounted, reactive } from 'vue';

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

const props = defineProps<{
    incompleteItems: IncompleteItem[];
}>();

</script>