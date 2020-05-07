<template>
  <main>
    <h1 v-html="page.title.rendered" class="wp__title"></h1>
    <div v-html="page.content.rendered" class="wp__content"></div>
  </main>
</template>

<script>
export default {
  head() {
    return {
      title: this.page.title.rendered,
      meta: [
        {
          hid: 'description',
          id: 'description',
          name: 'description',
          content: this.page._yoast_wpseo_metadesc
        }
      ]
    }
  },
  props: {
    page: {
      type: Object,
      required: true
    }
  }
}
</script>
