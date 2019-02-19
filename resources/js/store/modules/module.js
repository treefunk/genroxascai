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

  async fetch ({ commit }, data) {
    let url = '/api/modules'
    url += '?' + objectToRouteParam(data)
    try {
      const response = await axios.get(url)
      const data = _.get(response, 'data')
      commit(types.FETCH_MODULES_SUCCESS, { data: data })
    } catch (e) {
      console.log('Error:', e)
      commit(types.FETCH_MODULES_FAILURE)
    }
  },

  async get ({ commit }, data) {
    let url = '/api/modules/' + _.get(data, 'id')
    url += '?' + objectToRouteParam(data)
    try {
      const response = await axios.get(url)
      const data = _.get(response, 'data')
      commit(types.GET_MODULE_SUCCESS, { data: data })
    } catch (e) {
      console.log('Error:', e)
      commit(types.GET_MODULE_FAILURE, { data: data })
    }
  },

  clear ({ commit }, data) {
    commit(types.GET_MODULE_SUCCESS, { data: null })
    commit(types.FETCH_MODULES_SUCCESS, { data: null })
  }
}
