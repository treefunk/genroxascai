import axios from 'axios'
import * as _ from 'lodash'
import * as types from '../mutation-types'
import { objectToRouteParam } from '~/helpers'

// state
export const state = {
  all: null,
  module: null
}

// getters
export const getters = {
  all: state => state.all,
  module: state => state.module
}

// mutations
export const mutations = {
  [types.FETCH_MODULES_SUCCESS] (state, { data }) {
    state.all = data
  },
  [types.FETCH_MODULES_FAILURE] (state) {
  },
  [types.GET_MODULE_SUCCESS] (state, { data }) {
    state.module = data
  },
  [types.GET_MODULE_FAILURE] (state) {
  }
}

// actions
export const actions = {

  /**
   * Get all from API or Get by specific module_id if given
   *
   * @param commit
   * @param data
   * @returns {Promise.<void>}
   */
  async fetchModule ({ commit }, data) {
    const moduleId = _.get(data, 'id')
    let url = moduleId ? '/api/modules/' + moduleId : '/api/modules'
    url += '?' + objectToRouteParam(data)
    try {
      const response = await axios.get(url)
      const data = _.get(response, 'data')
      if (moduleId) {
        commit(types.GET_MODULE_SUCCESS, { data: data })
        return
      }
      commit(types.FETCH_MODULES_SUCCESS, { data: data })
    } catch (e) {
      console.log('Error:', e)
      if (moduleId) {
        commit(types.GET_MODULE_FAILURE, { data: data })
        return
      }
      commit(types.FETCH_MODULES_FAILURE)
    }
  },

  clear ({ commit }, data) {
    commit(types.FETCH_MODULES_SUCCESS, { data: null })
  }
}
