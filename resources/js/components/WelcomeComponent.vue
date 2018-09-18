<template>
    <div class="container">
        <div v-if="posts.length" v-for="item in posts" class="row justify-content-center">
            <div class="col-lg-8">
                <article>
                    <h1>{{item.title}}</h1>
                    <div class="created-at">{{item.created_at}}</div>
                    <div v-html="item.content" class="content"></div>
                </article>
            </div>
        </div>
        <div v-if="!posts.length" class="row justify-content-center">
            <h1>Posts coming soon ... Stay tuned!</h1>
        </div>
    </div>
</template>

<script>
  export default {
    props: ['posts']
  }
</script>
