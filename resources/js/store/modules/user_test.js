import axios from 'axios'
import qs from 'qs';
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

  async takeTest ({ commit }, data) {
    const options = {
      method: 'POST',
      headers: { 'content-type': 'application/x-www-form-urlencoded' },
      data: qs.stringify(data),
      url: '/api/usertests',
    }
    try {
      const response = await axios(options)
      const data = _.get(response, 'data')
      return data;
    } catch (e) {
      console.log('Error:', e)
      return null;
    }
  },

  async finishTest ({ commit }, data) {
    const options = {
      method: 'PUT',
      headers: { 'content-type': 'application/x-www-form-urlencoded' },
      data: qs.stringify(data),
      url: '/api/usertests/'  + _.get(data, 'id'),
    }
    try {
      const response = await axios(options)
      const data = _.get(response, 'data')
      return data;
    } catch (e) {
      console.log('Error:', e)
    }
  },

  clear ({ commit }, data) {
    commit(types.FETCH_USER_TESTS_SUCCESS, { data: null })
  }
}
