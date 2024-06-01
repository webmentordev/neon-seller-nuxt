<template>
    <div>
        <button @click="show = !show" class="underline text-blue-500">Read</button>
        <div v-show="show" class="fixed top-0 left-0 w-full h-full bg-black/20 backdrop-blur-sm z-20">
            <div class="w-full h-full flex items-center justify-center" @click.self="show = !show">
                <div class="bg-white p-6 rounded-xl max-w-3xl w-full" v-html="text"></div>
            </div>
        </div>
    </div>
</template>

<script setup>
    defineProps(['text'])
    const show = ref(false);
</script>