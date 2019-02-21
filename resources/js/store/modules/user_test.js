import axios from 'axios'
import * as _ from 'lodash'
import * as types from '../mutation-types'
import { objectToRouteParam } from '~/helpers'

// state
export const state = {
  all: null,
}

// getters
export const getters = {
  all: state => state.all,
}

// mutations
export const mutations = {
  [types.FETCH_USER_TESTS_SUCCESS] (state, { data }) {
    state.all = data
  },
  [types.FETCH_USER_TESTS_FAILURE] (state) {
  }
}

// actions
export const actions = {
  async fetch ({ commit }, data) {
    let url = '/api/usertests'
    url += '?' + objectToRouteParam(data)
    try {
      const response = await axios.get(url)
      const data = _.get(response, 'data')
      commit(types.FETCH_USER_TESTS_SUCCESS, { data: data })
    } catch (e) {
      console.log('Error:', e)
      commit(types.FETCH_USER_TESTS_FAILURE, { data: data })
    }
  },

  clear ({ commit }, data) {
    commit(types.FETCH_USER_TESTS_SUCCESS, { data: null })
  }
}
