<template>
    <div class="ml-10 mb-4">
        <div v-for="comment in comments" :key="comment.id">
            <div class="mt-8 p-2 border border-blue-600 rounded-lg">
                <div class="pl-2 my-2 border-l-4 border-gray-600 bg-green-200">
                    {{ comment.parent_body }}
                </div>
                <div>Sub Comment ID: {{ comment.id }}</div>
                <div>User: {{ comment.user_name }}</div>
                <div>Email: {{ comment.user_email }}</div>
                <div>Body: {{ comment.body }}</div>
                <div class="hover:bg-red-500 cursor-default  w-24 bg-green-500 rounded-lg text-center text-white"
                     @click="toggleReplyForm(comment.id)">Reply
                </div>
                <div class="text-sm text-left">
                    <div v-if="comment.subCount > 0">
                        <div class="hover:bg-red-500 cursor-default w-32 bg-green-500 rounded-lg text-center text-white"
                             @click="toggleShowSubComments(comment.id)">Show {{ comment.subCount }} comments
                        </div>
                    </div>
                    <div v-if="comment.subCount < 1">No comments</div>
                </div>
                <div class="text-sm text-right">{{ comment.date }}</div>
                <div v-if="selectedCommentId === comment.id">
                    <ReplyForm
                        :postId="this.postId"
                        :parentId="comment.id"
                        :errors=this.errors
                        @addComment="addSubCom"
                    ></ReplyForm>
                </div>
            </div>
            <div v-if="selectedParentCommentId === comment.id">
                <ChildComments
                    :key=randNum
                    :postId="this.postId"
                    :parentCommentId=comment.id
                    :errors=this.errors
                ></ChildComments>
            </div>
        </div>
    </div>
</template>

<script>
import ReplyForm from "@/Components/Comment/ReplyForm.vue";

export default {
    name: "ChildComments",
    components: {ReplyForm},
    data() {
        return {
            comments: [],
            postId: this.postId,
            selectedCommentId: null,
            selectedParentCommentId: null,
            randNum: null
        };
    },
    props: [
        "parentCommentId",
        "postId",
        "errors",
    ],

    created() {
        window.Echo.channel(`store_comment_${this.postId}`)
            .listen('.store_comment', res => {
                const subComment = this.comments.find(comment => comment.id === res.comment.parent_id);
                if (subComment) {
                    subComment.subCount++;
                }
                if (this.selectedParentCommentId === res.comment.parent_id) {
                    this.randNum = Math.random()
                }
            })
    },


    mounted() {
        this.getComments(this.parentCommentId);
    },
    methods: {
        async getComments(parentCommentId) {
            try {
                const response = await fetch(`/api/comments/children/${parentCommentId}`);
                if (response.ok) {
                    this.comments = await response.json();
                } else {
                    console.error("Помилка при отриманні даних");
                }
            } catch (error) {
                console.error("Помилка при виконанні запиту:", error);
            }
        },
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

        addSubCom(e) {
            this.toggleReplyForm(e.parent_id)
            const parentComment = this.comments.find(comment => comment.id === e.parent_id);
            parentComment.subCount++;
            if (this.selectedParentCommentId === e.parent_id) {
                this.randNum = Math.random()
            }
        }

    },


};
</script>

<style scoped>

</style>
