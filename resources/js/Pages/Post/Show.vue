<template>

    <h1 class="text-lg"> Post Show</h1>
    <div class="mb-4">
        <Link :href="route('post.index')" class="text-lg"> Back</link>
    </div>
    <div v-if="post">
        <div class="mt-8 pt-8 border-t border-gray-300">
            <div>Post ID: {{ post.id }}</div>
            <div>Title: {{ post.title }}</div>
            <div>Content: {{ post.content }}</div>
            <div class="text-sm text-right">{{ post.date }}</div>
            <div class="text-sm text-right">comment count {{ post.commentsCount }}</div>
        </div>
        <div class="mx-5" v-if="post.commentsCount > 0">
            <div class="" v-for="comment in post.comments">
                <div class="mt-8 p-2 border border-blue-600 rounded-lg">
                    <div>Comment ID: {{ comment.id }}</div>
                    <div>User: {{ comment.user_name }}</div>
                    <div>Email: {{ comment.user_email }}</div>
                    <div>Body: {{ comment.body }}</div>
                    <div class="text-sm text-right">{{ comment.date }}</div>
                    <div class="text-sm text-right"> Sab comment count {{ comment.subCount }}</div>
                </div>

                <div v-if="comment.subCount > 0">
                    <div class="ml-10 mb-4" v-for="com in comment.subCount">
                        <div class="mt-8 p-2 border border-blue-600 rounded-lg">
                            <div>Sub Comment ID:</div>
                            <div>User:</div>
                            <div>Email:</div>
                            <div>Body:</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

import {Link} from "@inertiajs/vue3";
import PostLayout from "@/Layouts/PostLayout.vue";

export default {
    name: "show",
    layout: PostLayout,

    props: [
        'post'
    ],
    components: {
        Link
    }
}

</script>

<style>

</style>
