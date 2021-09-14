export default {
    data(){
        return{

        }
    },
    methods: {
        async callApi(method, url, dataObj){
            try{
                const ax_var = axios({
                    method: method,
                    url: url,
                    data: dataObj
                  }).catch(function (error) {
                    return error.response;
                  });
                return ax_var;
            }catch(e){
                console.log(e);
                return e.response;
            }
        },
        i (title = "Notification title", nodesc = "Description") {
            this.$Notice.info({
                title: title,
                desc: nodesc
            });
        },
        s (title = "Notification title", nodesc = "Description") {
            this.$Notice.success({
                title: title,
                desc: nodesc
            });
        },
        w (title = "Notification title", nodesc = "Description") {
            this.$Notice.warning({
                title: title,
                desc: nodesc
            });
        },
        e (title = "Notification title", nodesc = "Description") {
            this.$Notice.error({
                title: title,
                desc: nodesc
            });
        }
    },
};