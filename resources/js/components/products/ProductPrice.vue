<script setup lang="ts">
import { formatCurrency } from '@/lib/utils';

withDefaults(defineProps<{
  price: number
  variant?: string
}>(), {
  variant: 'large',
});

</script>

<template>
  <span :class="{
    'font-black tracking-tight text-foreground': true,
    'text-xl': variant === 'large',
    'text-base': variant === 'base'

  }">{{
    formatCurrency(price)
    }}</span>
</template>
<!-- text-xl  -->