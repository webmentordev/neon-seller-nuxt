<template>
  <div>
    <h2>{{ error.statusCode }}</h2>
    <p>{{ error }}</p>
    <button @click="handleError">Clear errors</button>
  </div>
</template>

<script setup>
    const props = defineProps({
        error: Object
    });
    const handleError = () => clearError({ redirect: '/' })
    onUnmounted(() => {
        handleError();
    })
</script>