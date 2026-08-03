<script setup lang="ts">
import { formatCurrency } from '@/lib/utils';

defineProps<{
  price: number
}>();

</script>

<template>
  <span class="text-xl font-black tracking-tight text-foreground">{{
    formatCurrency(price)
    }}</span>
</template>
