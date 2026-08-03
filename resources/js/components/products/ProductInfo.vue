<script setup lang="ts">
import { ref } from 'vue';
import type { Product } from '@/types/product.js';
import Heading from '../Heading.vue';
import StarReview from '../StarReview.vue';
import AddToCart from './AddToCart.vue';
import ProductDescription from './ProductDescription.vue';
import ProductPrice from './ProductPrice.vue';
import ProductQuantity from './ProductQuantity.vue';

defineProps<{
  product: Product;
}>();

const quantity = ref(1);
</script>

<template>
  <div class="flex flex-col py-6 sm:w-1/2">
    <div class="mb-5 flex flex-col gap-y-2">
      <span class="text-sm font-medium tracking-wide text-gray-400 uppercase">
        Electronics
      </span>
      <Heading variant="large" class="font-inter" :title="product.name" />

      <StarReview :avg_rating="product.rating" :reviews_count="product.reviews_count" />
    </div>

    <div class="flex flex-col gap-y-3">
      <ProductPrice :price="product.price" />

      <ProductDescription
        >A Great Gaming laptop that is used also for Graphic Design lorme ipsum
        is here we are trying to abolbe this product is what you need
        wewe</ProductDescription
      >

      <div class="mt-6 flex flex-col gap-y-4">
        <ProductQuantity v-model="quantity" />

        <AddToCart />
      </div>
    </div>
  </div>
</template>
