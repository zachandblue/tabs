export const state = () => ({
  title: '',
  posts: []
})

export const mutations = {
  SET_POSTS(state, posts) {
    state.posts = posts
  },
  SET_CPTS(state, cpts) {
    state.cpts = cpts
  }
}

export const actions = {
  async nuxtServerInit({ commit, dispatch }) {
    const loaded = await dispatch('loadApp')

    console.log('LOADED', 'loaded')
  },

  loadApp({ dispatch }) {
    return Promise.all([dispatch('getPosts'), dispatch('getCPTs')])
  },

  async getPosts({ commit, dispatch }) {
    return new Promise(async (resolve, reject) => {
      try {
        const posts = await this.$wp.posts()
        commit('SET_POSTS', posts)
        resolve(posts)
      } catch (error) {
        console.log('error:', error)
      }
    })
  },

  //my example custom post type
  async getCPTs({ commit, dispatch }) {
    return new Promise(async (resolve, reject) => {
      try {
        const cpts = await this.$wp.cpt('CPT')
        commit('SET_CPTS', cpts)
        resolve(cpts)
      } catch (error) {
        console.log('error:', error)
      }
      // await dispatch('getPage')
    })
  }
}
