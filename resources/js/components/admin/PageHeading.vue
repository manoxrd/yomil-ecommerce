<script setup lang='ts'>

defineProps<{
  title: string;
  description?: string
}>();

</script>

<template>
  <div class="mb-8 flex flex-col sm:flex-row gap-y-4 justify-between">
    <div>
      <h1 class="text-2xl font-semibold tracking-tight text-foreground">{{ title }}</h1>
      <p v-if="description" class="mt-1 text-sm text-muted-foreground">{{ description }}</p>
    </div>

    <slot />
    
  </div>
</template>