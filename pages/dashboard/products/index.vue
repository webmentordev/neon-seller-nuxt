<template>
    <div>
        <h1>Welcome to Products page!</h1>
    </div>  
</template>

<script setup>
    definePageMeta({
        middleware: ['auth'],
        layout: 'dashboard'
    });
</script>