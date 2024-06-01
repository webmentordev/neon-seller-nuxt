<template>
    <section class="max-w-2xl w-full m-auto py-12">
        <h1 class="text-4xl mb-6">Create an account!</h1>
        <form @submit.prevent="signupHandler">
            <Failed v-if="failed" :text="failed" />
            <Processing v-if="processing" :text="processing" />
            <div class="w-full mb-3">
                <Label for="name" text="Full name" />
                <Input id="name" type="text" v-model="name" />
                <Error v-if="errors.name" :text="errors.name" />
            </div>
            <div class="w-full mb-3">
                <Label for="email" text="Email Address" />
                <Input id="email" type="text" v-model="email" />
                <Error v-if="errors.email" :text="errors.email" />
            </div>
            <div class="w-full mb-3">
                <Label for="password" text="Password" />
                <Input id="password" type="password" v-model="password" />
                <Error v-if="errors.password" :text="errors.password" />
            </div>
            <div class="w-full mb-3">
                <Label for="confirm_password" text="Confirm password" />
                <Input id="confirm_password" type="password" v-model="confirm_password" />
                <Error v-if="errors.confirm_password" :text="errors.confirm_password" />
            </div>
            <Button text="Signup" />
        </form>
    </section>
</template>

<script setup>
    const name = ref("");
    const email = ref("");
    const password = ref("");
    const confirm_password = ref("");
    const config = useRuntimeConfig().public.api;
    const cookie = useCookie('auth_cookie');

    definePageMeta({
        middleware: ['guest']
    });

    const failed = ref(null);
    const processing = ref(null);

    const errors = ref({
        name: null,
        email: null,
        password: null,
        confirm_password: null,
        count: 0
    });

    async function signupHandler(){
        failed.value = null;
        processing.value = "Creating account ...";
        errors.value = {
            name: null,
            email: null,
            password: null,
            confirm_password: null,
            count: 0
        };

        if(!name.value){
            errors.value.name = "Name is required!";
            errors.value.count = errors.value.count + 1;
        }
        if(!email.value || !email.value.includes('@')){
            errors.value.email = "Email format is required!";
            errors.value.count = errors.value.count + 1;
        }
        if(!password.value){
            errors.value.password = "Password is required!";
            errors.value.count = errors.value.count + 1;
        }
        if(!confirm_password.value){
            errors.value.confirm_password = "Confirm password is required!";
            errors.value.count = errors.value.count + 1;
        }
        if(password.value !=  confirm_password.value){
            errors.value.count = errors.value.count + 1;
        }
        if(errors.value.count == 0){
            try{
                const data = await $fetch(`${config}/api/signup`, {
                    method: 'POST',
                    body: {
                        name: name.value,
                        email: email.value,
                        password: password.value,
                        password_confirmation: confirm_password.value
                    }
                });
                cookie.value = data;
                name.value = "";
                email.value = "";
                password.value = "";
                confirm_password.value = "";
                return navigateTo('/dashboard')
            }catch(e){
                failed.value = e.data.message;
                processing.value = null;
            }
        }
        processing.value = null;
    }
</script>