<template>
  <main>
    <h1 v-html="post.title.rendered" class="wp__title"></h1>
    <div v-html="post.content.rendered" class="wp__content"></div>
  </main>
</template>

<script>
export default {
  head() {
    return {
      title: this.post.title.rendered,
      meta: [
        {
          hid: 'description',
          id: 'description',
          name: 'description',
          content: this.post._yoast_wpseo_metadesc
        }
      ]
    }
  },
  props: {
    post: {
      type: Object,
      required: true
    }
  }
}
</script>
