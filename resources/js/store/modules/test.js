import axios from 'axios'
import * as _ from 'lodash'
import * as types from '../mutation-types'
import { objectToRouteParam } from '~/helpers'

// state
export const state = {
  test: null,
}

// getters
export const getters = {
  test: state => state.test,
}

// mutations
export const mutations = {
  [types.GET_TEST_SUCCESS] (state, { data }) {
    state.test = data
  },
  [types.GET_TEST_FAILURE] (state) {
  }
}

// actions
export const actions = {

  async get ({ commit }, data) {
    let url = '/api/tests/' + _.get(data, 'id')
    url += '?' + objectToRouteParam(data)
    try {
      const response = await axios.get(url)
      const data = _.get(response, 'data')
      commit(types.GET_TEST_SUCCESS, { data: data })
    } catch (e) {
      console.log('Error:', e)
      commit(types.GET_TEST_FAILURE, { data: data })
    }
  },

  clear ({ commit }, data) {
    commit(types.GET_TEST_SUCCESS, { data: null })
  }
}
