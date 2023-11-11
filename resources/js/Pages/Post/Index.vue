<template>
    <h1 class="mb-4 text-lg"> Posts </h1>
    <div class=" pl-4 btn_row_grouper">
        <div class="mb-4">
            <Link :href="route('post.create')"
                  class="py-2 px-2 hover:bg-sky-500 w-32 bg-green-500 rounded-lg text-sm text-center text-white"  style="cursor: pointer">Add post
            </Link>
        </div>
        <div class="mb-4">
            <Link :href="route('home')"
                  class="py-2 px-2 hover:bg-sky-500 w-32 bg-green-500 rounded-lg text-sm text-center text-white"  style="cursor: pointer">Back to home
            </Link>
        </div>
    </div>

    <div v-if="posts">
        <div class="mt-8 pt-8 border-t border-gray-300" v-for="post in posts">
            <div class="mb-4 pl-4 btn_row_grouper" >
                <div class="py-1 hover:bg-sky-500 w-24 bg-green-500 rounded-lg text-sm text-center text-white"  style="cursor: pointer">
                    <Link :href="route('post.show', post.id)">Show more</Link>
                </div>
                <div class="py-1 hover:bg-sky-500 w-24 bg-green-500 rounded-lg text-sm text-center text-white"  style="cursor: pointer">
                    <Link :href="route('post.edit', post.id)">Edit</Link>
                </div>
                <div class="py-1 hover:bg-red-500 w-24 bg-green-500 rounded-lg text-sm text-center text-white"  style="cursor: pointer">
                    <Link @click="deletePost(post.id)">Delete</Link>
                </div>
                <div class="text-sm text-right">
                    {{ post.date }}
                </div>
            </div>
            <div class="mb-4 py-4 pl-4 bg-gray-100 rounded-lg">{{ post.title }}</div>
            <div class="mb-4 pl-4" >{{ post.content }}</div>
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

.btn_row_grouper {
    display: flex;
    gap: 20px;
}
</style>
