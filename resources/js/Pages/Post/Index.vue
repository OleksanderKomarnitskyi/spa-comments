<template>
    <h1 class="text-lg"> Posts </h1>
    <div class="mb-4">
        <Link :href="route('post.create')"
              class="hover:bg-red-500 block p-2 w-32 bg-sky-500 rounded-full text-center text-white">Add post
        </Link>
    </div>
    <div class="mb-4">
        <Link :href="route('home')"
              class="hover:bg-red-500 block p-2 w-32 bg-sky-500 rounded-full text-center text-white">Back to home
        </Link>
    </div>
    <div v-if="posts">
        <div class="mt-8 pt-8 border-t border-gray-300" v-for="post in posts">
            <div>ID: {{ post.id }}</div>
            <div>Title: {{ post.title }}</div>
            <div>Content: {{ post.content }}</div>
            <div class="text-sm text-right">{{ post.date }}</div>

            <div class="text-sm text-right text-sky-500">
                <Link :href="route('post.show', post.id)">
                    Show more
                </Link>
            </div>
            <div class="text-sm text-right text-sky-500">
                <Link :href="route('post.edit', post.id)">
                    Edit
                </Link>
            </div>
            <div class="cursor-pinter text-sm text-right text-red-500">
                <p @click="deletePost(post.id)">
                    Delete
                </p>
            </div>

        </div>
    </div>

</template>

<script>

import {Link} from "@inertiajs/vue3";
import PostLayout from "@/Layouts/PostLayout.vue";

export default {
    name: "index",
    layout: PostLayout,

    props: [
        'posts'
    ],
    components: {
        Link
    },
    methods: {
        deletePost(id) {
            this.$inertia.delete(`/posts/${id}`)
        }
    }
}

</script>

<style>

</style>
