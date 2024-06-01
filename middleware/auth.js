export default defineNuxtRouteMiddleware(() => {
    const config = useRuntimeConfig().public.api;
    const cookie = useCookie('auth_cookie');
    if(!cookie.value){
        cookie.value = null;
        return navigateTo('/login');
    }
})