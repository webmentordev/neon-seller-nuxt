<template>
    <div>
        <h1 class="text-3xl mb-4">Product Categories</h1>
        <Failed v-if="failed" :text="failed" />
        <Success v-if="success" :text="success" />
        <Processing v-if="processing" :text="processing" />
        <form @submit.prevent="createHandler" class="flex items-center mb-4">
            <Input v-model="name" type="text" placeholder="Category title" />
            <Button class="ml-3" text="Create" />
        </form>
        <table class="w-full rounded-xl overflow-hidden text-sm bg-white shadow-md">
            <tr class="bg-black text-white">
                <th class="text-start p-2">Name</th>
                <th class="text-start">Slug</th>
                <th class="text-start">Products</th>
                <th class="text-start">Active Products</th>
                <th class="text-end">Status</th>
                <th class="text-end p-2">Created</th>
            </tr>
            <tr v-for="item in result" :key="item.id" class="border-b border-gray-100 last:border-none">
                <td class="text-start p-2">{{ item.name }}</td>
                <td class="text-start">{{ item.slug }}</td>
                <td class="text-start">{{ item.products_count }}</td>
                <td class="text-start">{{ item.active_products_count }}</td>
                <td class="text-end cursor-pointer">
                    <span v-if="item" class="bg-green-500/10 text-green-800 py-1 px-2 rounded-lg font-bold">Active</span>
                    <span v-else class="bg-red-500/10 text-red-800 py-1 px-2 rounded-lg font-bold">Inactive</span>
                </td>
                <td class="text-end p-2">{{ item.created_at }}</td>
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

    const result = ref([]);
    const config = useRuntimeConfig().public.api;
    const cookie = useCookie('auth_cookie');

    const data = await $fetch(`${config}/api/auth/categories`, {
        headers: { Authorization: `Bearer ${cookie.value.token}` }
    });
    result.value = data.data;

    const failed = ref(null);
    const success = ref(null);
    const processing = ref(null);

    async function createHandler(){
        failed.value = null;
        success.value = null;
        processing.value = "Logging in ...";
        try{
            const data = await $fetch(`${config}/api/auth/category/create`, {
                method: 'POST',
                headers: { Authorization: `Bearer ${cookie.value.token}` },
                body: {
                    name: name.value
                }
            });
            success.value = data.message;
            result.value.push(data.category);
        }catch(e){
            failed.value = e.data.message;
            processing.value = null;
        }
        processing.value = null;
    }
</script>