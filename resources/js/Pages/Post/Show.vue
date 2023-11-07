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
            <div class="hover:bg-red-500 cursor-default  w-24 bg-green-500 rounded-lg text-center text-white"
                 @click="toggleCommentPostForm">To comment</div>

            <div class="text-sm text-right">{{ post.date }}</div>
            <div class="text-sm text-right">comment count {{ post.commentsCount }}</div>

            <div v-if="commentPostForm" >
                <ReplyForm
                    :postId="post.id"
                    :parentId=null
                    :errors=this.errors
                ></ReplyForm>
            </div>

        </div>
        <div class="mx-5" v-if="comments.data">
            <div class="" v-for="comment in comments.data">
                <div class="mt-8 p-2 border border-blue-600 rounded-lg">
                    <div>Comment ID: {{ comment.id }}</div>
                    <div>User: {{ comment.user_name }}</div>
                    <div>Email: {{ comment.user_email }}</div>
                    <div>Body: {{ comment.body }}</div>
                    <div class="hover:bg-red-500 cursor-default  w-24 bg-green-500 rounded-lg text-center text-white"
                         @click="toggleReplyForm(comment.id)">Reply</div>

                    <div class="text-sm text-left">
                        <div v-if="comment.subCount > 0" >
                            <div class="hover:bg-red-500 cursor-default w-32 bg-green-500 rounded-lg text-center text-white"
                                 @click="toggleShowSubComments(comment.id)">Show {{ comment.subCount }} comments </div>
                        </div>
                        <div v-if="comment.subCount < 1" >No comments</div>
                    </div>

                    <div class="text-sm text-right">{{ comment.date }}</div>

                    <div v-if="selectedCommentId === comment.id" >
                        <ReplyForm
                            :postId="post.id"
                            :parentId="comment.id"
                            :errors=this.errors
                        ></ReplyForm>
                    </div>

                </div>

                <div v-if="selectedParentCommentId === comment.id">
                    <ChildComments
                        :postId="post.id"
                        :parentCommentId=comment.id
                        :errors=this.errors
                    ></ChildComments>
                </div>
            </div>

            <pagination class="mt-6" :links="comments.meta.links" />

        </div>
    </div>
</template>

<script>

import {Link} from "@inertiajs/vue3";
import PostLayout from "@/Layouts/PostLayout.vue";
import ChildComments from "@/Components/Comment/СhildСomments.vue";
import ReplyForm from "@/Components/Comment/ReplyForm.vue";
import Pagination from "@/Components/Pagination.vue";

export default {
    name: "Show",
    layout: PostLayout,
    data() {
        return {
            selectedCommentId: null,
            selectedParentCommentId: null,
            commentPostForm: false
        };
    },
    props: [
        'post',
        'errors',
        'comments'
    ],
    components: {
        ReplyForm,
        Link,
        ChildComments,
        Pagination,
    },

    methods: {
        toggleReplyForm(commentId) {
            if (this.selectedCommentId === commentId) {
                this.selectedCommentId = null;
            } else {
                this.selectedCommentId = commentId;
            }
        },
        toggleShowSubComments(parentCommentId) {
            if (this.selectedParentCommentId === parentCommentId) {
                this.selectedParentCommentId = null;
            } else {
                this.selectedParentCommentId = parentCommentId;
            }
        },
        toggleCommentPostForm() {
            this.commentPostForm = this.commentPostForm === false;
        },

    },

}
</script>

<style>

</style>
