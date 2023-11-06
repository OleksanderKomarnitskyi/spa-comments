<template>
        <h1 class="text-lg" > Edit </h1>
        <Link :href="route('post.index')" class="text-lg" > Back </link>
        <form @submit.prevent="update">
            <div class="mb-2" >
                <input v-model="title" type="text" class="w-full rounded-lg border-gray-200" placeholder="title">
            </div>
            <div class="mb-2" >
                <textarea v-model="content" class="w-full rounded-lg border-gray-200" placeholder="content" ></textarea>
            </div>
            <div class="mb-2" >
                <button type="submit" class="ml-auto hover:bg-red-500 block p-2 w-32 bg-sky-500 rounded-lg text-center text-white" >
                    Update
                </button>
            </div>
        </form>
</template>

<script>

import {Link, router} from "@inertiajs/vue3";
import PostLayout from "@/Layouts/PostLayout.vue";

export default {
    name: "edit",
    layout: PostLayout,
    components: {
        Link
    },
    data() {
        return {
            id: this.post.id,
            title: this.post.title,
            content: this.post.content
        }
    },
    props: [
        'post'
    ],
    methods: {
        router() {
            return router
        },
        update() {
            this.$inertia.patch(`/posts/${this.id}`, {
                title: this.title,
                content: this.content
            });
        }
    }
}

</script>



<style>

</style>
