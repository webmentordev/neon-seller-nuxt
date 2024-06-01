<template>
    <div>
        <h1 class="text-3xl mb-4">Contacts</h1>
        <table class="w-full rounded-xl overflow-hidden text-sm bg-white shadow-md">
            <tr class="bg-black text-white">
                <th class="text-start p-2">Name</th>
                <th class="text-start">Email</th>
                <th class="text-start">Subject</th>
                <th class="text-start">Message</th>
                <th class="text-end p-2">Created</th>
            </tr>
            <tr v-for="item in result" :key="item.id" class="border-b border-gray-100 last:border-none">
                <td class="text-start p-2">{{ item.name }}</td>
                <td class="text-start">{{ item.email }}</td>
                <td class="text-start">{{ item.subject }}</td>
                <td class="text-start">
                    <DashboardCard :text="item.message" />
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

    const result = ref([]);
    const config = useRuntimeConfig().public.api;
    const cookie = useCookie('auth_cookie');

    const data = await $fetch(`${config}/api/auth/contacts`, {
        headers: { Authorization: `Bearer ${cookie.value.token}` }
    });
    result.value = data.data;
</script>