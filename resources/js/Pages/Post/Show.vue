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
                    @addComment="addCom"
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
                                @addComment="addCom"
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

            <pagination v-if="comments.meta" class="mt-6" :links="comments.meta.links" />

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
    mounted() {
        // console.log(this.comments)
    },

    created() {
        window.Echo.channel(`store_comment_${this.post.id}`)
            .listen('.store_comment', res => {
                if (res.comment.parent_id === null) {
                    this.comments.data.unshift(res.comment)
                } else {
                    if (this.selectedParentCommentId === res.comment.parent_id) {
                        this.toggleShowSubComments(res.comment.parent_id)
                        setTimeout(() => {
                            this.toggleShowSubComments(res.comment.parent_id)
                        }, 2000);
                    }
                }
            })
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

        addCom(e) {
            if (e.parent_id === null) {
                this.post.commentsCount++;
                if (this.comments.length === 0) {
                    this.comments.data = [];
                    this.comments.data.push(e);
                } else {
                    this.comments.data.unshift(e)
                    this.commentPostForm = false
                }
            } else {
                this.toggleReplyForm(e.parent_id) // закрити форму
                console.log(e, 'e')
                const parentComment = this.comments.data.find(comment => comment.id === e.parent_id);
                parentComment.subCount++;

                if (this.selectedParentCommentId === e.parent_id) {

                    const parentElement = document.getElementById('parent-' + parentComment.id);

                    // const parentElement = this.$refs['parent-' + parentComment.id];

                    parentElement.appendChild(newElement);
                    console.log(parentComment.id, 'parentComment ')
                    console.log(parentElement, 'parentElement ')

                }

            }

        }

    },

}
</script>

<style>

</style>
