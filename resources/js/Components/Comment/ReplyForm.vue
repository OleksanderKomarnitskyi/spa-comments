<template>

        <div>
                <form @submit.prevent="store">
                    <div class="mb-2" >
                        <input v-model="userName" type="text" class="w-full rounded-lg border-gray-200" placeholder="Yor Full name">
                        <div v-if="errors.user_name" class="text-red-600 text-sm" >{{errors.user_name}}</div>
                    </div>
                    <div class="mb-2" >
                        <input v-model="userEmail" type="text" class="w-full rounded-lg border-gray-200" placeholder="Contact email">
                        <div v-if="errors.user_email" class="text-red-600 text-sm" >{{errors.user_email}}</div>
                    </div>
                    <div class="mb-2" >
                        <input v-model="url" type="text" class="w-full rounded-lg border-gray-200" placeholder="Link to yor site">
                        <div v-if="errors.url" class="text-red-600 text-sm" >{{errors.url}}</div>
                    </div>
                    <div class="mb-2" >
                        <textarea v-model="body" class="w-full rounded-lg border-gray-200" placeholder="content" ></textarea>
                        <div v-if="errors.body" class="text-red-600 text-sm"  >{{errors.body}}</div>
                    </div>

                    <div class="mb-2" >
                        <button type="submit" class="hover:bg-red-500 cursor-default w-48 bg-green-500 rounded-lg text-center text-white">
                            Submit your comment
                        </button>
                    </div>
                </form>
        </div>

</template>

<script>

import {router} from "@inertiajs/vue3"
export default {
    name: "ReplyForm",
    props: [
        'postId',
        'parentId',
        'errors'
    ],
    data() {
        return {
            postId: this.postId,
            parentId: this.parentId,
            body: '',
            userName: '',
            userEmail: '',
            url: ''
        }
    },
    methods: {
        router() {
            return router
        },
        store() {

            const commentObject = {
                parent_id: this.parentId,
                user_name: this.userName,
                user_email: this.userEmail,
                url: this.url,
                body: this.body,
            }

            this.$inertia.post(`/posts/${this.postId}/comment`, commentObject);
        }

    }
}
</script>
<style>

</style>
