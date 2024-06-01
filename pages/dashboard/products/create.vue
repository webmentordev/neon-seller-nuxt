<template>
    <div>
        <h1 class="text-3xl mb-4">Create new products</h1>
        <form @submit.prevent="createProduct" method="post" enctype="multipart/form-data">
            <Failed v-if="failed" :text="failed" />
            <Success v-if="success" :text="success" />
            <Processing v-if="processing" :text="processing" />
            <div class="grid grid-cols-2 gap-4">
                <div class="w-full mb-3">
                    <Label for="title" text="Product Title" />
                    <Input id="title" type="text" v-model="title" />
                    <Error v-if="errors.title" :text="errors.title" />
                </div>
                <div class="w-full mb-3">
                    <Label for="name" text="Product name (big title with keywords)" />
                    <Input id="name" type="text" v-model="name" />
                    <Error v-if="errors.name" :text="errors.name" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="w-full mb-3">
                    <Label for="slug" text="Product slug" />
                    <Input id="slug" type="text" v-model="slug" />
                    <Error v-if="errors.slug" :text="errors.slug" />
                </div>
                <div class="w-full mb-3">
                    <Label for="image" text="Product image" />
                    <Input id="image" type="file" @change="uploadFile" accept="image/*" />
                    <Error v-if="errors.image" :text="errors.image" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="w-full mb-3">
                    <Label for="seo" text="Product SEO" />
                    <Input id="seo" type="text" v-model="seo" />
                    <Error v-if="errors.seo" :text="errors.seo" />
                </div>
                <div class="w-full mb-3">
                    <Label for="seo" text="Product Category" />
                    <Select v-model="category">
                        <option v-if="categories.length" value="" selected>Please select category!</option>
                        <option v-else value="" selected>Categories does not exist!</option>
                        <option v-for="category in categories" :value="category.slug" selected>{{ category.name }}</option>
                    </Select>
                    <Error v-if="errors.category" :text="errors.category" />
                </div>
            </div>
            <div class="w-full mb-3">
                <Label for="description" text="Product description" />
                <Quill id="description" v-model:content="description"/>
                <Error v-if="errors.description" :text="errors.description" />
            </div>
            <div class="w-full mb-3">
                <Label for="body" text="Product body" />
                <Quill id="body" v-model:content="body"/>
                <Error v-if="errors.body" :text="errors.body" />
            </div>
            <Button text="Create product" />
        </form>
    </div>  
</template>

<script setup>
    definePageMeta({
        middleware: ['auth'],
        layout: 'dashboard'
    });

    const name = ref("");
    const title = ref("");
    const slug = ref("");
    const description = ref("");
    const seo = ref("");
    const body = ref("");
    const image = ref("");
    const category = ref("");
    
    
    const config = useRuntimeConfig().public.api;
    const cookie = useCookie('auth_cookie');
    const formData = new FormData();
    
    const categories = ref([]);
    const failed = ref(null);
    const success = ref(null);
    const processing = ref(null);

    const data = await $fetch(`${config}/api/auth/categories`, {
        headers: { Authorization: `Bearer ${cookie.value.token}` }
    });
    categories.value = data.data;

    const errors = ref({
        name: null,
        title: null,
        slug: null,
        description: null,
        seo: null,
        body: null,
        category: null,
        image: null,
        count: 0
    });

    function uploadFile(e){
        formData.append('image', e.target.files[0]);
    }

    async function createProduct(){
        failed.value = null;
        success.value = null;
        processing.value = "Creating a new product ...";
        errors.value = {
            name: null,
            title: null,
            slug: null,
            description: null,
            seo: null,
            body: null,
            category: null,
            image: null,
            count: 0
        };
        formData.append('name', name.value);
        formData.append('title', title.value);
        formData.append('slug', slug.value);
        formData.append('description', description.value);
        formData.append('seo', seo.value);
        formData.append('body', body.value);
        formData.append('category', category.value);
        try{
            const data = await $fetch(`${config}/api/auth/product/create`, {
                method: 'POST',
                headers: { Authorization: `Bearer ${cookie.value.token}` },
                body: formData
            });
            success.value = data.message;
        }catch(e){
            failed.value = e.data.message;
            processing.value = null;
        }
        processing.value = null;
    }
</script>