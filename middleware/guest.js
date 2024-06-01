export default defineNuxtRouteMiddleware(() => {
    const config = useRuntimeConfig().public.api;
    const cookie = useCookie('auth_cookie');
    if(cookie.value){
        return navigateTo('/dashboard');
    }else{
        cookie.value = null;
    }
})