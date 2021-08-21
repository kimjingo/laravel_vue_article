<template>
  <div class="container">
    <h1>{{ greeting }}</h1>
    <form action="" @submit.prevent="addArticle()" class="mb-3">
      <div class="form-group">
        <input
          type="text"
          class="form-control mb-2"
          placeholder="Title"
          v-model="article.title"
        />
      </div>
      <div class="form-group">
        <textarea
          class="form-control mb-2"
          placeholder="body"
          v-model="article.body"
        />
      </div>
      <button type="submit" class="btn btn-light btn-block mb-2">Save</button>
    </form>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li
          v-bind:class="[{ disabled: !pagination.prev_page_url }]"
          class="page-item"
        >
          <a
            class="page-link"
            href="#"
            @click="fetchArticles(pagination.prev_page_url)"
            >Previous</a
          >
        </li>
        <li class="page-item">
          <a class="page-link" href="#"
            >Page {{ pagination.current_page }} of {{ pagination.last_page }}</a
          >
        </li>
        <!-- 
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li> -->
        <li
          v-bind:class="[{ disabled: !pagination.next_page_url }]"
          class="page-item"
        >
          <a
            class="page-link"
            href="#"
            @click="fetchArticles(pagination.next_page_url)"
            >Next</a
          >
        </li>
      </ul>
    </nav>
    <div
      class="card card-body mb-2"
      v-for="article in articles"
      :key="article.id"
    >
      <h3>{{ article.title }}</h3>
      <p>{{ article.body }}</p>
      <hr />
      <button @click="editArticle(article)" class="btn btn-secondary mb-1">
        Edit
      </button>
      <button @click="deleteArticle(article)" class="btn btn-danger">
        Delete
      </button>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      articles: [],
      article: {
        id: "",
        title: "",
        body: "",
      },
      article_id: "",
      pagination: {},
      edit: false,
    };
  },
  setup: () => ({
    greeting: "Create your own articles!!!",
  }),
  methods: {
    fetchArticles(page_url) {
      let vm = this;
      page_url = page_url || "api/articles";
      //   console.log("hi");
      fetch(page_url)
        .then((res) => res.json())
        .then((res) => {
          console.log(res);
          this.articles = res.data;
          vm.makePagination(res.meta, res.links);
        })
        .catch((err) => console.log(err));
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev,
      };
      //   console.log(pagination);
      this.pagination = pagination;
    },
    deleteArticle(id) {
      if (confirm("Are you sure?")) {
        fetch("api/articles/" + id, {
          method: "delete",
        })
          .then((res) => res.json())
          .then((data) => {
            alert("Article removed");
            this.fetchArticles();
          })
          .catch((err) => console.log(err));
      }
    },
    addArticle() {
      if (this.edit === false) {
        fetch("api/articles", {
          method: "post",
          body: JSON.stringify(this.article),
          headers: { "content-type": "application/json" },
        })
          .then((res) => res.json())
          .then((res) => {
            this.article.title = "";
            this.article.body = "";
            alert("Article added");
            this.fetchArticles();
          })
          .catch((err) => console.log(err));
      } else {
        //update
        fetch("api/articles/" + this.article.id, {
          method: "put",
          body: JSON.stringify(this.article),
          headers: { "content-type": "application/json" },
        })
          .then((res) => res.json())
          .then((res) => {
            this.article.title = "";
            this.article.body = "";
            alert("Article updated");
            this.fetchArticles();
          })
          .catch((err) => console.log(err));
      }
    },
    editArticle(article) {
      this.edit = true;
      this.article_id = article.id;
      this.article.id = article.id;
      this.article.title = article.title;
      this.article.body = article.body;
    },
  },
  created() {
    this.fetchArticles();
  },
};
</script>