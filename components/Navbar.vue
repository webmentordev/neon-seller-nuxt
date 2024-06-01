<template>
    <nav class="w-full top-0 left-0 sticky border-b border-gray-200">
        <div class="max-w-6xl m-auto flex items-center justify-between py-3 px-4">
            <NuxtLink to="/">Logo</NuxtLink>
            <ul class="font-semibold flex items-center">
                <NuxtLink class="px-6" to="/">Home</NuxtLink>
                <NuxtLink class="px-6" to="/">Products</NuxtLink>
                <NuxtLink class="px-6" to="/">Contact</NuxtLink>
                <div v-if="!isAuth">
                    <NuxtLink class="px-6" to="/login">Login</NuxtLink>
                    <NuxtLink class="px-6" to="/signup">Signup</NuxtLink>
                </div>
                <div class="flex items-center" v-else>
                    <NuxtLink class="px-6" to="/dashboard">Dashboard</NuxtLink>
                    <form @submit.prevent="logoutHandler">
                        <Button text="Logout" />
                    </form>
                </div>
            </ul>
        </div>
    </nav>
</template>

<script setup>
    const cookie = useCookie('auth_cookie');
    const config = useRuntimeConfig().public.api;
    const isAuth = ref(false);

    watchEffect(() => {
        if(cookie.value){
            isAuth.value = true;
        }else{
            isAuth.value = false;
        }
    })
    async function logoutHandler(){
        try{
            await $fetch(`${config}/api/auth/logout`, {
                method: 'DELETE',
                headers: { Authorization: `Bearer ${cookie.value.token}` }
            });
            cookie.value = null;
            return navigateTo('/login')
        }catch(e){
            console.log(e.data.message);
        }
    }
</script>