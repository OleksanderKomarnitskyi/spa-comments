<template>
        <h1 class=" mb-4 text-lg" > Posts Create </h1>
        <div class="mb-4 py-1 hover:bg-sky-500 w-32 bg-green-500 rounded-lg text-center text-white"  style="cursor: pointer">
            <Link :href="route('post.index')" class="text-lg"> Back</link>
        </div>
        <form @submit.prevent="store">
            <div class="mb-2" >
                <input v-model="title" type="text" class="w-full rounded-lg border-gray-200" placeholder="title">
                <div v-if="errors.title" class="text-red-600 text-sm" >{{errors.title}}</div>
            </div>
            <div class="mb-2" >
                <textarea v-model="content" class="w-full rounded-lg border-gray-200" placeholder="content" ></textarea>
                <div v-if="errors.content" class="text-red-600 text-sm"  >{{errors.content}}</div>
            </div>
            <div class="mb-2" >
                <button type="submit" class="mb-4 py-1 hover:bg-sky-500 w-32 bg-green-500 rounded-lg text-sm text-center text-white"  style="cursor: pointer">
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
