<script setup lang="ts">
import { Star } from '@lucide/vue';

withDefaults(defineProps<{
  variant?: string,
  size?: number,
  avg_rating?: number | null,
  reviews_count?: number | null
}>(), {
  variant: 'product'
});

</script>

<template>
  <div class="flex items-center gap-x-1 font-bold">
    <div class="flex">
      <Star
        v-if="variant === 'mini'"
        :size="size ?? 18"
        fill="#E8A736"
        stroke-width="0"
      />

      <Star
        v-else
        :size="size ?? 18"
        fill="#E8A736"
        stroke-width="0"
        v-for="index in 5"
        :key="index"
      />
    </div>

    <span v-if="variant !== 'person'" class="font-normal">{{ Number(avg_rating).toFixed(1) }}</span>
    <span v-if="variant === 'product'">({{ reviews_count }} Reviews)</span>
  </div>
</template>
