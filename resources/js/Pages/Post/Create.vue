<template>
        <h1 class="text-lg" > Posts Create </h1>
        <Link :href="route('post.index')" class="text-lg" > Back </link>
        <form @submit.prevent="store">
            <div class="mb-2" >
                <input v-model="title" type="text" class="w-full rounded-full border-gray-200" placeholder="title">
                <div v-if="errors.title" class="text-red-600 text-sm" >{{errors.title}}</div>
            </div>
            <div class="mb-2" >
                <textarea v-model="content" class="w-full rounded-full border-gray-200" placeholder="content" ></textarea>
                <div v-if="errors.content" class="text-red-600 text-sm"  >{{errors.content}}</div>
            </div>
            <div class="mb-2" >
                <button type="submit" class="ml-auto hover:bg-red-500 block p-2 w-32 bg-sky-500 rounded-full text-center text-white" >
                    Store
                </button>
            </div>
        </form>
</template>

<script>

import {Link, router} from "@inertiajs/vue3";
import PostLayout from "@/Layouts/PostLayout.vue";

export default {
    name: "create",
    layout: PostLayout,
    components: {
        Link
    },
    data() {
        return {
            title: '',
            content: ''
        }
    },
    props: [
      'errors'
    ],
    methods: {
        router() {
            return router
        },
        store() {
            this.$inertia.post('/posts', {
                title: this.title,
                content: this.content
            });
        }
    }
}

</script>



<style>

</style>
