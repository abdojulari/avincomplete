<template>
    <div class="relative">
      <input
        type="text"
        v-model="search"
        @focus="dropdownVisible = true"
        @input="searchInput"
        placeholder="Select tags"
        class="border p-2 rounded w-full"
      />
      <!-- Dropdown list of options -->

      <ul v-if="dropdownVisible" class="absolute border bg-white w-full mt-1 rounded shadow-lg z-10 overflow-y-auto">
        <li
          v-for="option in filteredOptions"
          :key="option"
          @click="selectTag(option)"
          class="p-2 cursor-pointer hover:bg-gray-200"
        >
          {{ option }}
        </li>
      </ul>
      <div class="mt-2 flex flex-wrap gap-2">
        <span
          v-for="tag in selectedTags"
          :key="tag"
          class="my-2 bg-gray-400 text-white px-2 py-1 rounded flex items-center"
        >
          {{ tag }}
          <button @click="removeTag(tag)" class="ml-2 text-red-500">&times;</button>
        </span>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  
  import { ref, computed, defineEmits, onUnmounted } from 'vue';
  
  const props = defineProps<{
    options: string[];
    selectedTags: string[];
  }>();
  
  const emit = defineEmits(['update:selectedTags']);
  
  const search = ref('');
  const dropdownVisible = ref(false);
  
  const filteredOptions = computed(() => {
    if (!search.value) return props.options;
    return props.options.filter(option =>
      option.toLowerCase().includes(search.value.toLowerCase())
    );
  });
  
  const selectTag = (option: string) => {
    if (!props.selectedTags.includes(option)) {
      emit('update:selectedTags', [...props.selectedTags, option]);
    }
    search.value = '';
    dropdownVisible.value = false;
  };
  
  const removeTag = (tag: string) => {
    emit('update:selectedTags', props.selectedTags.filter(t => t !== tag));
  };
  
  const searchInput = () => {
    // Reactivity will handle the rest
  };
  
  // Handle clicks outside of the component
  const handleClickOutside = (event: MouseEvent) => {
    if (!event.target || !(event.target as HTMLElement).closest('.relative')) {
      dropdownVisible.value = false;
    }
  };
  
  // Register and clean up event listener for clicks outside of the component
  window.addEventListener('click', handleClickOutside);
  onUnmounted(() => {
    window.removeEventListener('click', handleClickOutside);
  });
  </script>
  