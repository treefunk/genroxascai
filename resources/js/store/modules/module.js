import axios from 'axios'
import * as _ from 'lodash'
import * as types from '../mutation-types'

// state
export const state = {
  modules: null,
}

// getters
export const getters = {
  modules: state => state.modules,
}

// mutations
export const mutations = {
  [types.FETCH_MODULES_SUCCESS] (state, { data }) {
    state.modules = data
  },

  [types.FETCH_MODULES_FAILURE] (state) {
  }
}

// actions
export const actions = {
  async fetchModules ({ commit }, data) {
    const url = '/api/modules'
    try {
      const response = await axios.get(url)
      const data = _.get(response, 'data')
      commit(types.FETCH_MODULES_SUCCESS, { data: data })
    } catch (e) {
      console.log('Error:', e)
      commit(types.FETCH_MODULES_FAILURE)
    }
  }
}
