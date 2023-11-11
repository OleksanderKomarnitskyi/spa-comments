<template>

    <div class="mb-4 pl-4" >
        <form @submit.prevent="recaptcha">
            <div class="mb-2">
                <input v-model="user_name" type="text" class="w-full rounded-lg border-gray-200" placeholder="Yor Full name">
                <div v-if="errors.user_name" class="text-red-600 text-sm">{{ errors.user_name[0] }}</div>
            </div>
            <div class="mb-2">
                <input v-model="user_email" type="text" class="w-full rounded-lg border-gray-200" placeholder="Contact email">
                <div v-if="errors.user_email" class="text-red-600 text-sm">{{ errors.user_email[0]  }}</div>
            </div>
            <div class="mb-2">
                <input v-model="url" type="text" class="w-full rounded-lg border-gray-200" placeholder="Link to yor site">
                <div v-if="errors.url" class="text-red-600 text-sm">{{ errors.url[0]  }}</div>
            </div>
            <div class="mb-2">
                <textarea v-model="body" class="w-full rounded-lg border-gray-200" placeholder="content"></textarea>
                <div v-if="errors.body" class="text-red-600 text-sm">{{ errors.body[0]  }}</div>
            </div>

            <jet-input-error :message="errors.captcha_token" class="mt-2" />

                    <div class="mb-2" >
                        <button type="submit" class=" mb-4 py-1  hover:bg-sky-500 w-48 bg-green-500 rounded-lg text-sm  text-center text-white" style="cursor: pointer" >
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
    ],
    data() {
        return {
            postId: this.postId,
            parentId: this.parentId,
            body: '',
            user_name: '',
            user_email: '',
            url: '',
            captcha_token: null,
            errors: []
        }
    },
    emits: [
        'addComment'
    ],

    methods: {
        router() {
            return router
        },

        async recaptcha() {
            await this.$recaptchaLoaded()
            this.captcha_token = await this.$recaptcha('login')
            this.store()
        },

        store() {
            const commentObject = {
                parent_id: this.parentId,
                user_name: this.user_name,
                user_email: this.user_email,
                url: this.url,
                body: this.body,
                captcha_token: this.captcha_token
            }

            axios.post(`/posts/${this.postId}/comment`, commentObject)
                .then(res => {
                    this.$emit('addComment', res.data)
                }) .catch(error => this.handleError(error))
        },

        handleError(error) {
            if (error.response.status === 422) {
                this.errors = error.response.data.errors;
            }
        }

    }
}
</script>
<style>

</style>
