import axios from 'axios'
import * as _ from 'lodash'
import * as types from '../mutation-types'
import { objectToRouteParam } from '~/helpers'

// state
export const state = {
  all: null,
  ebook: null,
}

// getters
export const getters = {
  all: state => state.all,
  ebook: state => state.ebook,
}

// mutations
export const mutations = {
  [types.FETCH_EBOOKS_SUCCESS] (state, { data }) {
    state.all = data
  },
  [types.FETCH_EBOOKS_FAILURE] (state) {
  },
  [types.GET_EBOOK_SUCCESS] (state, { data }) {
    state.ebook = data
  },
  [types.GET_EBOOK_FAILURE] (state) {
  }
}

// actions
export const actions = {

  async fetch ({ commit }, data) {
    let url = '/api/ebooks'
    url += '?' + objectToRouteParam(data)
    try {
      const response = await axios.get(url)
      const data = _.get(response, 'data')
      commit(types.FETCH_EBOOKS_SUCCESS, { data: data })
    } catch (e) {
      console.log('Error:', e)
      commit(types.FETCH_EBOOKS_FAILURE)
    }
  },

  async get ({ commit }, data) {
    let url = '/api/ebooks/' + _.get(data, 'id')
    url += '?' + objectToRouteParam(data)
    try {
      const response = await axios.get(url)
      const data = _.get(response, 'data')
      commit(types.GET_EBOOK_SUCCESS, { data: data })
    } catch (e) {
      console.log('Error:', e)
      commit(types.GET_EBOOK_FAILURE, { data: data })
    }
  },

  async finish ({ commit }, data) {
    let url = '/api/student-ebooks'
    url += '?' + objectToRouteParam(data)
    try {
      const response = await axios.post(url, data)
      const data = _.get(response, 'data')
      return data
    } catch (e) {
      console.log('Error:', e)
    }
  },

  clear ({ commit }, data) {
    commit(types.GET_EBOOK_SUCCESS, { data: null })
    commit(types.FETCH_EBOOKS_SUCCESS, { data: null })
  }
}
