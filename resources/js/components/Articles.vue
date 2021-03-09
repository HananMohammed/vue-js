<template>
    <div>
        <h1>Articles</h1>
        <form class="mb-3" @submit.prevent="addArticle">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="title"
                       v-model="article.title">
            </div>
            <div class="form-group">
                <textarea class="form-control" placeholder="Body"
                          v-model="article.body"></textarea>
            </div>
            <button class="btn btn-info btn-block" style="width: 20%; margin-left: 40%;">Add Article</button>
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]"
                    class="page-item">
                    <a class="page-link" href="#"
                       @click="fetchArticles(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled">
                    <a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                 <li v-bind:class="[{disabled: !pagination.next_page_url}]"
                    @click="fetchArticles(pagination.next_page_url)"
                    class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
        <div class="card card-body mb-3"
             v-for="article in articles"
             v-bind:key="article.id">
            <h3>{{ article.title }}</h3>
            <p>{{ article.body }}</p>
            <hr>
            <button @click="deleteArticle(article.id)"
                class="btn btn-danger mb-3" style="width: 20%;">Delete</button>
            <button @click="editArticle(article)"
                    class="btn btn-warning" style="width: 20%; ">Edit</button>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            articles:[],
            article: {
                id:'',
                title:'',
                body:''
            },
            article_id:'',
            pagination:{},
            edit:false
        }
    },
    created(){
        this.fetchArticles();
    },
    methods:{
        fetchArticles(page_url){
            let vm = this;
            console.log(page_url)
            page_url = page_url || `/api/articles`
             fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.articles = res.data
                    console.log(res.data)
                    vm.makePagination(res.meta, res.links)
                })
            .catch(err => console.log(err))
        },
        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            }
            this.pagination = pagination;
        },
        deleteArticle(id){
            if (confirm('Are you Sure')){
                fetch(`api/article/${id}`,{
                    method: 'delete'
                })
                .then(res => res.json())
                .then(data => {
                    alert(`Article Removed`);
                    this.fetchArticles();
                })
            }
        },
        addArticle(){
            if (this.edit === false){
                //Add
                fetch('api/article',{
                    method:'post',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(err => console.log(err))
                .then(data => {
                    this.article.title = '';
                    this.article.body = '';
                    alert('Article Added Successfully ');
                    this.fetchArticles();
                })
            }else{
                //update
                 fetch('api/articles',{
                    method:'put',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(err => console.log(err))
                    .then(data => {
                        this.article.title = '';
                        this.article.body = '';
                        alert('Article Updated Successfully ');
                        this.fetchArticles();
                    })
            }
        },
        editArticle(article){
            this.edit = true;
            this.article.id = article.id;
            this.article.article_id = article.id;
            this.article.title = article.title;
            this.article.body = article.body;
        }
    }
}
</script>

