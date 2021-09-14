<template>
    <div>
        <h1>the number is: {{views}}</h1>
        <button @click="updateCounter(1);">Increment</button>
        <button @click="updateCounter(-1);">Decrement</button>
        <br/>
        <br/>
        <br/>
        <div v-for="(blog, i) in blogs" :key="i" v-if="blogs.length">
            <h1>{{blog.title}}</h1>
            <p>{{blog.post}}</p>
        </div>
        <br/>
        <br/>
        <br/>
        <div>
            <h1 v-if="showItem">show when true</h1>
            <h1 v-else>show when false</h1>
        </div>

        <button @click="showItem = !showItem">Change</button>
    </div>
</template>
<script>
export default{
    data(){
        return {
            views: 0,
            blogs: [
                {title: 'This is blog title', post: "this is the blog post", id: 1},
            ],
            showItem: false
        }
    },
    methods: {
        updateCounter(number){
            this.views += number
        }
    },

    created(){
        // get data from api
        this.views = 100;
        let posts = [
                {title: 'This is blog dsfdsf', post: "this is the blog post", id: 1},
                {title: 'This is blog sdfa', post: "this is the blog post", id: 2},
                {title: 'This is blog asdf', post: "this is the blog post", id: 3},
                {title: 'This is fgsfdg title', post: "this is the blog post", id: 4},
                {title: 'This is gfhj title', post: "this is the blog post", id: 5},
            ];

            this.blogs = posts;
    }
}
</script>