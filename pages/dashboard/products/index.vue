<template>
    <div>
        <h1 class="text-3xl mb-4">Products</h1>
        <table class="w-full rounded-xl overflow-hidden text-sm bg-white shadow-md">
            <tr class="bg-black text-white">
                <th class="text-start p-2">StripeID</th>
                <th class="text-start">Title</th>
                <th class="text-start">Name</th>
                <th class="text-start">Category</th>
                <th class="text-start">SEO</th>
                <th class="text-start">Description</th>
                <th class="text-start">Slug</th>
                <th class="text-start">Image</th>
                <th class="text-start">Prices</th>
                <th class="text-end">Active</th>
                <th class="text-end">Featured</th>
                <th class="text-end p-2">Created</th>
                <th class="text-end p-2">Updated</th>
            </tr>
            <tr v-for="item in result" :key="item.id" class="border-b border-gray-100 last:border-none">
                <td class="text-start p-2">{{ item.stripe_id }}</td>
                <td class="text-start">{{ item.title }}</td>
                <td class="text-start">{{ item.name }}</td>
                <td class="text-start">{{ item.category.name }}</td>
                <td class="text-start">
                    <DashboardCard :text="item.seo" />
                </td>
                <td class="text-start">
                    <DashboardCard :text="item.description" />
                </td>
                <td class="text-start">
                    <DashboardCard :text="item.slug" />
                </td>
                <td class="text-start"><nuxt-link :to="item.image" class="text-blue-600 underline" target="_blank">View</nuxt-link></td>
                <th class="text-start">{{ item.prices.length }}</th>
                <td class="text-end cursor-pointer">
                    <span v-if="item.is_active" class="bg-green-500/10 text-green-800 py-1 px-2 rounded-lg font-bold">Active</span>
                    <span v-else class="bg-red-500/10 text-red-800 py-1 px-2 rounded-lg font-bold">InActive</span>
                </td>
                <td class="text-end cursor-pointer">
                    <span v-if="item.is_feature" class="bg-green-500/10 text-green-800 py-1 px-2 rounded-lg font-bold">Featured</span>
                    <span v-else class="bg-red-500/10 text-red-800 py-1 px-2 rounded-lg font-bold">Ignored</span>
                </td>
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

    const result = ref([]);
    const config = useRuntimeConfig().public.api;
    const cookie = useCookie('auth_cookie');

    const data = await $fetch(`${config}/api/auth/products/`, {
        headers: { Authorization: `Bearer ${cookie.value.token}` }
    });
    result.value = data.data;
</script>