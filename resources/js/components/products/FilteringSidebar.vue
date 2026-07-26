<script setup lang='ts'>
import { Star } from '@lucide/vue';
import { ref } from 'vue';
import type { Category } from '@/types/category.js';
import Checkbox from '../ui/checkbox/Checkbox.vue';
import Sidebar from '../ui/sidebar/Sidebar.vue';
import SidebarContent from '../ui/sidebar/SidebarContent.vue';
import SidebarGroup from '../ui/sidebar/SidebarGroup.vue';
import SidebarGroupLabel from '../ui/sidebar/SidebarGroupLabel.vue';
import SidebarHeader from '../ui/sidebar/SidebarHeader.vue';
import SidebarMenu from '../ui/sidebar/SidebarMenu.vue';
import SidebarMenuButton from '../ui/sidebar/SidebarMenuButton.vue';
import SidebarMenuItem from '../ui/sidebar/SidebarMenuItem.vue';
import { useSidebar } from '../ui/sidebar/utils.js';
import Slider from '../ui/slider/Slider.vue';

defineProps<{
  categories: Category[];
  currentCategory: string;
}>();

const { isMobile } = useSidebar();

const priceRange = ref([25, 100]);

const emit = defineEmits(['selectCategory', 'filterByReview']);

</script>

<template>


  <Sidebar :collapsible="isMobile ? 'icon' : 'none'" variant="sidebar">
    <SidebarHeader class="flex-row justify-between items-center px-2.5 pt-4">
      <!-- <Filter :size="18" fill="black" /> -->
      <span class="font-medium">Filter</span>
      <button class="text-sm text-muted dark:text-muted-foreground cursor-pointer">Clear all</button>

    </SidebarHeader>
    <SidebarContent>
      <SidebarGroup>
        <SidebarGroupLabel>Category</SidebarGroupLabel>
        <SidebarMenu>
          <!--  -->
          <SidebarMenuItem v-for="category in categories" :key="category.id">
            <SidebarMenuButton :class="currentCategory === category.name ? 'bg-sidebar-accent' : ''"
              @click="emit('selectCategory', category)">

              <span>{{ category.name }}</span>

            </SidebarMenuButton>
          </SidebarMenuItem>
        </SidebarMenu>
      </SidebarGroup>
      <SidebarGroup>
        <SidebarGroupLabel>Reviews</SidebarGroupLabel>
        <SidebarMenu>
          <SidebarMenuItem v-for="index in 4" :key="index">
            <SidebarMenuButton as="label">
              <Checkbox @update:modelValue="(isChecked) => {

                if (isChecked) {
                  emit('filterByReview', {
                    checked: isChecked,
                    rating: 5 - index
                  })
                }
                
              }" />
              <span class="flex gap-x-1 items-center">
                <Star :size="16" fill="#E8A736" stroke-width="0" />
                +{{ 5 - index }}
              </span>
            </SidebarMenuButton>
          </SidebarMenuItem>
        </SidebarMenu>
      </SidebarGroup>
      <SidebarGroup>
        <SidebarGroupLabel>Price</SidebarGroupLabel>
        <div class="px-2.5">

          <div class="flex justify-between text-xs text-muted-foreground px-1 mb-2">
            <span>${{ priceRange[0] }}</span>
            <span>${{ priceRange[1] }}</span>
          </div>
          <Slider v-model="priceRange" :min="25" :max="100" :step="1" class="mx-auto w-full max-w-xs" />
        </div>
      </SidebarGroup>
    </SidebarContent>
  </Sidebar>

</template>