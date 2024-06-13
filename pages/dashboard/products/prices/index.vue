<template>
    <div>
        <h1 class="text-3xl mb-4">Product Prices</h1>
        <Failed v-if="failed" :text="failed" />
        <Success v-if="success" :text="success" />
        <Processing v-if="processing" :text="processing" />
        <form @submit.prevent="createHandler" class="flex items-center mb-4">
            <Input v-model="name" type="text" placeholder="Neon Size" />
            <Select v-model="product" class="ml-3">
                <option v-if="products.length == 0" value="" selected>Please add a product</option>
                <option v-else value="" selected>Select product</option>
                <option v-if="products.length" v-for="product in products" :value="product.slug">{{ product.name }}</option>
            </Select>
            <Input v-model="price" type="numeric" setp="0.01" placeholder="Price" class="ml-3" />
            <Button class="ml-3" text="Create" />
        </form>
        <table class="w-full rounded-xl overflow-hidden text-sm bg-white shadow-md">
            <tr class="bg-black text-white">
                <th class="text-start p-2">Name</th>
                <th class="text-start">Price</th>
                <th class="text-start">Product</th>
                <th class="text-end p-2">Created</th>
                <th class="text-end p-2">Updated</th>
            </tr>
            <tr v-for="item in prices" :key="item.id" class="border-b border-gray-100 last:border-none">
                <td class="text-start p-2">{{ item.name }}</td>
                <td class="text-start">{{ item.price }}</td>
                <td class="text-start">{{ item.product.name }}</td>
                <td class="text-end p-2">{{ item.created }}</td>
                <td class="text-end p-2">{{ item.updated }}</td>
            </tr>
        </table>
    </div>  
</template>

<script setup>
    definePageMeta({
        middleware: ['auth'],
        layout: 'dashboard'
    });

    const name = ref("");
    const product = ref("");
    const price = ref(0.00);

    const products = ref([]);
    const prices = ref([]);
    const config = useRuntimeConfig().public.api;
    const cookie = useCookie('auth_cookie');

    const data = await $fetch(`${config}/api/auth/prices`, {
        headers: { Authorization: `Bearer ${cookie.value.token}` }
    });
    prices.value = data.prices;
    products.value = data.products;

    const failed = ref(null);
    const success = ref(null);
    const processing = ref(null);

    async function createHandler(){
        failed.value = null;
        success.value = null;
        processing.value = "Creating new price ...";
        try{
            const data = await $fetch(`${config}/api/auth/price/create`, {
                method: 'POST',
                headers: { Authorization: `Bearer ${cookie.value.token}` },
                body: {
                    name: name.value,
                    price: price.value,
                    product: product.value,
                }
            });
            success.value = data.message;
        }catch(e){
            failed.value = e.data.message;
            processing.value = null;
        }
        processing.value = null;
    }
</script>