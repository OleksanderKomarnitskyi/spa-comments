<template>
        <h1 class=" mb-4 text-lg" > Edit </h1>
        <div class="mb-4 py-1 hover:bg-sky-500 w-32 bg-green-500 rounded-lg text-center text-white"  style="cursor: pointer">
            <Link :href="route('post.index')" class="text-lg"> Back</link>
        </div>
        <form @submit.prevent="update">
            <div class="mb-2" >
                <input v-model="title" type="text" class="w-full rounded-lg border-gray-200" placeholder="title">
            </div>
            <div class="mb-2" >
                <textarea v-model="content" class="w-full rounded-lg border-gray-200" placeholder="content" ></textarea>
            </div>
            <div class="mb-2" >
                <button type="submit" class="mb-4 py-1 hover:bg-sky-500 w-32 bg-green-500 rounded-lg text-sm text-center text-white"  style="cursor: pointer" >
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
