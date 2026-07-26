<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { router } from "@inertiajs/vue3";
import { computed } from 'vue';
import FilteringSidebar from '@/components/products/FilteringSidebar.vue';
import ProductCard from '@/components/products/ProductCard.vue';
import SidebarProvider from '@/components/ui/sidebar/SidebarProvider.vue';
import type { Category, Product, Review } from '@/types';

const props = defineProps<{
  products: Product[];
  category: Category | null;
  categories: Category[];
  review: Review
}>();

const currentCategory = computed(() => props.category?.name ?? '');

const onCategorySelected = (category: any) => {

  if (currentCategory.value !== category.name) {

    console.log(category);
    router.reload({ data: {category: category.name}, only: ['products', 'category'] });
  }
};

const onReviewSelected = (args: any) => {

  // if (currentCategory.value !== ar.name) {
    console.log(args);
    router.reload({ data: {rating: args.rating}, only: ['products', 'review'] });
  // }
};

</script>

<template>

  <Head title="Products Catalog" />

  <div class="flex min-h-screen justify-start bg-background">
    <SidebarProvider class="w-fit">
      <FilteringSidebar :categories="categories" :currentCategory="currentCategory" @select-category="onCategorySelected" @filter-by-review="onReviewSelected" />
    </SidebarProvider>

    <div class="flex-1 p-6">
      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        <ProductCard :products="products" />
      </div>
    </div>
  </div>
</template>