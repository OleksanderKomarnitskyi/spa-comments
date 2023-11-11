<template>

    <h1 class="text-lg"> Post Show</h1>
    <div class="mb-4 py-1 hover:bg-sky-500 w-32 bg-green-500 rounded-lg text-center text-white"  style="cursor: pointer">
        <Link :href="route('post.index')" class="text-lg"> Back</link>
    </div>
    <div v-if="post">
        <div class="mt-8 pt-8 border-t border-gray-300">
            <div class="mb-4 py-4 pl-4 bg-gray-100 rounded-lg ">{{ post.title }}</div>
            <div class="mb-4 pl-4" >{{ post.content }}</div>
            <div class=" pl-4 btn_row_grouper">
                <div class="mb-4 py-1 hover:bg-sky-500 w-32 bg-green-500 rounded-lg text-center text-white"  style="cursor: pointer"
                     @click="toggleCommentPostForm">To comment
                </div>
                <div class="text-lg text-right">{{ post.date }}</div>
                <div class="text-lg text-right">comment count {{ post.commentsCount }}</div>
            </div>
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
                    <div class="mb-4  px-4 py-4 user_info_group bg-gray-100 rounded-lg" >
                        <div class="user_name_mail" >
                            <div>{{ comment.user_name }}</div>
                            <div>{{ comment.user_email }}</div>
                        </div>
                        <div class="text-sm">{{ comment.date }}</div>
                    </div>
                    <div class="mb-4 pl-2" >Body: {{ comment.body }}</div>
                    <div class="btn_row_grouper">
                        <div class="mb-4 py-1 hover:bg-sky-500 w-32 bg-green-500  rounded-lg text-sm  text-center text-white"  style="cursor: pointer"
                             @click="toggleReplyForm(comment.id)">Reply
                        </div>
                        <div v-if="comment.subCount > 0" >
                            <div class="mb-4 py-1 hover:bg-sky-500 w-32 bg-green-500 rounded-lg text-sm  text-center text-white"  style="cursor: pointer"
                                 @click="toggleShowSubComments(comment.id)">Show {{ comment.subCount }} comments
                            </div>
                        </div>
                        <div v-if="comment.subCount < 1" >No comments</div>
                    </div>
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
                        :key=randNum
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
            commentPostForm: false,
            randNum: null
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

    created() {
        window.Echo.channel(`store_comment_${this.post.id}`)
            .listen('.store_comment', res => {
                if (res.comment.parent_id === null) {
                    this.post.commentsCount++;
                    if (this.comments.length === 0) {
                        this.comments.data = [];
                        this.comments.data.push(res.comment);
                    } else {
                        this.comments.data.unshift(res.comment)
                        this.commentPostForm = false
                    }
                } else {
                    const parentComment = this.comments.data.find(comment => comment.id === res.comment.parent_id );
                    if (parentComment) {
                        parentComment.subCount++;
                    }

                    if (this.selectedParentCommentId === res.comment.parent_id ) {
                        this.randNum = Math.random()
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
                this.toggleReplyForm(e.parent_id)
                const parentComment = this.comments.data.find(comment => comment.id === e.parent_id);
                parentComment.subCount++;

                if (this.selectedParentCommentId === e.parent_id) {
                    this.randNum = Math.random()
                }

            }

        }

    },

}
</script>

<style>

.user_info_group {
    display: flex;
    gap: 20px;
    justify-content: space-between;
}

.btn_row_grouper {
    display: flex;
    gap: 20px;
}

.user_name_mail {
    display: flex;
    gap: 20px;
}

</style>
