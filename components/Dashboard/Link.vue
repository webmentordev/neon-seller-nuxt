<template>
    <nuxt-link class="flex items-center p-1 rounded-lg"><Icon :name="src" class="mr-3 text-[20px]" /><slot /></nuxt-link>
</template>

<script setup>
    defineProps(['src'])
</script>