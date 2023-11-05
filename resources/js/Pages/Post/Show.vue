<template>
    <div class="w-96 mx-auto pt-8" >
        <h1 class="text-lg" > Post</h1>
        <div class="mb-4" >
            <Link :href="route('post.index')" class="text-lg" > Back </link>
        </div>
        <div v-if="post" >
            <div class="mt-8 pt-8 border-t border-gray-300">
                <div>ID: {{post.id}}</div>
                <div>Title: {{post.title}}</div>
                <div>Content: {{post.content}}</div>
                <div class="text-sm text-right" >{{post.date}}</div>
                <div>Comments: {{post.comments}} </div>
            </div>
        </div>
    </div>

</template>

<script>

import {Link} from "@inertiajs/vue3";

export default {
    name: "show",

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
