<template>
    <div>
        <h1>Welcome to Single Neon Page!</h1>
        <div v-if="pending">
            <Loading />
        </div>

        <div v-else>
            <div>
                <img :src="product.image" alt="">
            </div>
        </div>
    </div>  
</template>

<script setup>
    const product = ref(null);

    const config = useRuntimeConfig().public.api;
    const slug = useRoute().params.slug;

    const { pending, data, error } = await useLazyFetch(`${config}/api/product/${slug}`);
    
    watch(data, (newProduct) => {
        product.value = newProduct.data;
    })
    if(error.value){
        throw createError({
            statusCode: 404,
            statusMessage: error.value
        })
    }
</script>