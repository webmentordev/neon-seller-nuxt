<template>
    <section class="max-w-lg w-full m-auto py-12">
        <h1 class="text-4xl mb-6">Contact us!</h1>
        <form @submit.prevent="messageHandler">
            <Failed v-if="failed" :text="failed" />
            <Success v-if="success" :text="success" />
            <Processing v-if="processing" :text="processing" />
            <div class="w-full mb-3">
                <Label for="name" text="Full name" />
                <Input id="name" type="text" v-model="name" />
                <Error v-if="errors.name" :text="errors.name" />
            </div>
            <div class="w-full mb-3">
                <Label for="email" text="Email Address" />
                <Input id="email" type="email" v-model="email" />
                <Error v-if="errors.email" :text="errors.email" />
            </div>
            <div class="w-full mb-3">
                <Label for="subject" text="Subject" />
                <Input id="subject" type="text" v-model="subject" />
                <Error v-if="errors.subject" :text="errors.subject" />
            </div>
            <div class="w-full mb-3">
                <Label for="message" text="Message" />
                <Textarea id="message" v-model="message" />
                <Error v-if="errors.message" :text="errors.message" />
            </div>
            <Button text="Send Message" />
        </form>
    </section>
</template>

<script setup>
    const name = ref("");
    const email = ref("");
    const subject = ref("");
    const message = ref("");
    const config = useRuntimeConfig().public.api;
    const cookie = useCookie('auth_cookie');
    
    const failed = ref(null);
    const success = ref(null);
    const processing = ref(null);

    const errors = ref({
        name: null,
        email: null,
        subject: null,
        message: null,
        count: 0
    });

    async function messageHandler(){
        failed.value = null;
        success.value = null;
        processing.value = "Sending ...";
        errors.value = {
            name: null,
            email: null,
            subject: null,
            message: null,
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
        if(!subject.value){
            errors.value.subject = "Subject is required!";
            errors.value.count = errors.value.count + 1;
        }
        if(!message.value){
            errors.value.message = "Message is required!";
            errors.value.count = errors.value.count + 1;
        }
        if(errors.value.count == 0){
            try{
                const data = await $fetch(`${config}/api/contact/create`, {
                    method: 'POST',
                    body: {
                        name: name.value,
                        email: email.value,
                        subject: subject.value,
                        message: message.value
                    }
                });
                name.value = "";
                email.value = "";
                subject.value = "";
                message.value = "";
                success.value = data.message;
            }catch(e){
                failed.value = e.data.message;
                processing.value = null;
            }
        }
        processing.value = null;
    }
</script>