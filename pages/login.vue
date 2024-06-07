<template>
    <section class="h-[90vh] flex items-center justify-center">
        <div class="max-w-lg w-full m-auto p-8 rounded-2xl shadow-md border border-gray-100">
            <h1 class="text-4xl mb-6">Login into account!</h1>
            <form @submit.prevent="loginHandler">
                <Failed v-if="failed" :text="failed" />
                <Processing v-if="processing" :text="processing" />
                <div class="w-full mb-3">
                    <Label for="email" text="Email Address" />
                    <Input id="email" type="email" v-model="email" />
                    <Error v-if="errors.email" :text="errors.email" />
                </div>
                <div class="w-full mb-3">
                    <Label for="password" text="Password" />
                    <Input id="password" type="password" v-model="password" />
                    <Error v-if="errors.password" :text="errors.password" />
                </div>
                <Button text="Login" />
            </form>
        </div>
    </section>
</template>

<script setup>
    const email = ref("");
    const password = ref("");
    const config = useRuntimeConfig().public.api;
    const cookie = useCookie('auth_cookie');

    definePageMeta({
        middleware: ['guest']
    });
    
    const failed = ref(null);
    const processing = ref(null);

    const errors = ref({
        email: null,
        password: null,
        count: 0
    });

    async function loginHandler(){
        failed.value = null;
        processing.value = "Logging in ...";
        errors.value = {
            email: null,
            password: null,
            count: 0
        };
        if(!email.value || !email.value.includes('@')){
            errors.value.email = "Email format is required!";
            errors.value.count = errors.value.count + 1;
        }
        if(!password.value){
            errors.value.password = "Password is required!";
            errors.value.count = errors.value.count + 1;
        }

        if(errors.value.count == 0){
            try{
                const data = await $fetch(`${config}/api/login`, {
                    method: 'POST',
                    body: {
                        email: email.value,
                        password: password.value
                    }
                });
                cookie.value = data;
                email.value = "";
                password.value = "";
                return navigateTo('/dashboard')
            }catch(e){
                failed.value = e.data.message;
                processing.value = null;
            }
        }
        processing.value = null;
    }
</script>