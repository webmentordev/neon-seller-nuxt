<template>
    <div>
        <h1>Welcome to Update Product page!</h1>
    </div>  
</template>

<script setup>
    definePageMeta({
        middleware: ['auth'],
        layout: 'dashboard'
    });
</script>