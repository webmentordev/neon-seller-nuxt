<template>
    <div>
        <h1>Orders</h1>
    </div>
</template>

<script setup>
    definePageMeta({
        middleware: ['auth'],
        layout: 'dashboard'
    });
</script>