<template>
    <div>
        <h1 ref="myref">Hook tutorial</h1>
        <p>My Name is: {{name}}</p> 
    </div>
</template>

<script>
export default {
    data(){
        return {
            name: 'sdfsfd'
        }
    },
    beforeCreate(){
        console.log(this.name);
    },
    created(){
        console.log("data and other function is available but not html", this.name);
    },
    mounted(){
        console.log(this.$refs.myref);
    }
}
</script>