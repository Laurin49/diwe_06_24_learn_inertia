<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, useForm } from "@inertiajs/vue3";

defineProps({
    posts: {
        type: Object,
    },
    can: {
        type: Object,
    }
});

const form = useForm("StorePost", {
    'body': '',
});


const createPost = () => {
    form.post(route('posts.store'), {
        onSuccess: () => {
            form.reset();
            // toast.success('Post created successfully');
        },
    });
};

const refreshPosts = () => {
    console.log('refreshPosts');
    router.get(
        route("posts.index"),
        {},
        {
            only: ["posts"],
            preserveScroll: true,
            preserveState: true,
        }
    );
};
</script>

<template>
    <Head title="Posts/Index" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Posts/Index
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <!-- {{ form }} -->
                <!-- Username: {{ page.props.auth.user.name }} -->
                <form 
                    v-if="can.post_create" 
                    @submit.prevent="createPost"
                    class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <label for="body" class="sr-only">Body</label>
                    <textarea 
                        v-model="form.body"
                        v-on:focus="form.clearErrors('body')"
                        name="body" id="body"
                        cols="30" rows="5"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    </textarea>
                    <p v-if="form.errors.body"
                         class="text-sm text-red-500"
                    >
                        {{ form.errors.body }}
                    </p>
                    <button 
                        :disabled="form.processing"
                        type="submit"
                        class="px-4 py-2 mt-2 font-medium text-white bg-gray-700 rounded-md"
                        :class="{ 'opacity-50': form.processing }"
                    >
                        Post
                    </button>
                </form>
                <div class="flex justify-center py-3">
                    <button
                        @click="refreshPosts"
                        class="text-sm text-indigo-700"
                        type="button"
                    >
                        Refresh posts
                    </button>
                </div>
                <div v-for="post in posts.data" :key="post.id">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="font-semibold">
                                {{ post.user.name }}
                            </div>
                            <p clas="mt-1">{{ post.body }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
