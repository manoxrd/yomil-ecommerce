<script setup lang='ts'>
import { Link } from '@inertiajs/vue3';

defineProps<{
  title: string;
  description?: string;
  link?: string;
  linkName?: string;
}>();

</script>

<template>
  <div class="mb-8 flex flex-col sm:flex-row gap-y-4 justify-between">
    <div>
      <h1 class="text-2xl font-semibold tracking-tight text-foreground">
        {{ title }}
        <span v-if="link && linkName">
          : 
          <Link :href="link" class="text-blue-400 hover:text-blue-500 pl-1">{{ linkName }}</Link>
        </span>
      </h1>
      <p v-if="description" class="mt-1 text-sm text-muted-foreground">{{ description }}</p>
    </div>

    <slot />

  </div>
</template>