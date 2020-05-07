<template>
  <main class="wp__content">
    <h2>Hey Collin, I've listed the posts right here</h2>
    <p>These come from the 'posts' array in the vuex store</p>
    <ul>
      <li v-for="post in posts" :key="post.id">
        <nuxt-link :to="`/${post.slug}`">{{post.title.rendered}}</nuxt-link>
      </li>
    </ul>

    <h2>Hey Collin, I've listed the custom posts, "CPTS", right here</h2>
    <p>These also come from the vuex store</p>
    <ul>
      <li v-for="post in cpts" :key="post.id">
        <nuxt-link :to="`/${post.slug}`">{{post.title.rendered}}</nuxt-link>
      </li>
    </ul>

    <h2>Here is an ACF Example field</h2>
    <p>{{exampleACF}}</p>

    <p>
      <span class="bold">Wuxt</span> combines
      <span class="bold italic">WordPress</span>, the worlds biggest CMS with
      <span class="bold italic">nuxt.js</span>, the most awesome front-end application framework yet.
    </p>
    <p>The goal is to provide a ready to use development environment, which makes the full power of WordPress easily available to your front-and app. Included in Wuxt are:</p>

    <ul>
      <li>
        Fully dockerized
        <span class="bold italic">WordPress</span> and
        <span class="bold italic">nuxt.js</span> container configuration,
        <code>docker-compose up -d</code> sets up everything needed in one command and you can start working
      </li>
      <li>Extended Rest API to give the front-end easy access to meta-fields, featured media menus or the front-page configuration.</li>
      <li>
        The newest nuxt.js version, extended with a WordPress
        <code>$wp</code> object, to connect to the extended
        <span class="bold italic">WordPress</span> Rest API.
      </li>
    </ul>

    <p>
      All together the
      <span class="bold italic">Wuxt</span> features get you started with your front-end with just one command, you just need to work with the intuitive
      <span
        class="bold italic"
      >WordPress</span> admin interface and can skip all back-end coding. But if you know your way around WordPress you are able to easily extend the back-end as well.
    </p>
  </main>
</template>

<script>
import axios from 'axios'

export default {
  async asyncData(context) {
    const { route, app, error } = context

    try {
      const frontPage = await app.$wp.frontPage()

      return { frontPage }
    } catch (e) {
      error(e)
    }
  },
  data() {
    return {
      site: null
    }
  },
  head() {
    return {
      title: this.site ? this.site.name : this.frontPage.title.rendered,
      meta: [
        {
          // pretty sure these get overwritten in nuxt.confic.js for the home page
          hid: 'description',
          id: 'description',
          name: 'description',
          content: this.frontPage._yoast_wpseo_metadesc
        }
      ]
    }
  },
  beforeMount() {
    this.test()
  },
  methods: {
    async test() {
      const site = await axios.get('http://' + process.env.baseUrl + '/wp-json')
      this.$set(this, 'site', site.data)
    }
  },

  computed: {
    posts() {
      return this.$store.state.posts
    },
    cpts() {
      return this.$store.state.cpts
    },
    exampleACF() {
      let field = ''
      try {
        field = this.frontPage.meta.example_field[0]
      } catch (err) {}
      return field
    }
  }
}
</script>

<style lang="scss" scoped>
p {
  &:nth-child(1n + 2) {
    margin-top: 1rem;
  }
}

ul {
  margin-top: 1rem;

  li {
    &:nth-child(1n + 2) {
      margin-top: 1rem;
    }
  }
}

.bold {
  font-weight: 700;
}

.italic {
  font-style: italic;
}

code {
  padding: 3px 10px;

  background-color: #37495c;
  border-radius: 4px;

  color: #fff;
}
</style>
