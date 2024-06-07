<template>
    <section class="max-w-6xl w-full m-auto py-12">
        <h1 class="text-4xl mb-6">Our Neon Signs collections</h1>
        <div class="grid grid-cols-3 gap-4">
            <nuxt-link v-for="product in products" :title="product.title" :to='`/collection/${product.slug}`' class="p-3 border border-gray-200 rounded-2xl">
                <nuxt-img quality="90" :src="product.image" :alt="product.title" class="rounded-2xl mb-3 w-full" />
                <h3>{{ product.title }}</h3>
                <span class="font-bold text-lg text-blue-600">$25.99</span>
            </nuxt-link>
        </div>
    </section>
</template>

<script setup>
    const products = ref([]);

    const config = useRuntimeConfig().public.api;

    const data = await $fetch(`${config}/api/products`);
    products.value = data.data;

</script>