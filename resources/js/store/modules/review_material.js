import axios from 'axios'
import * as _ from 'lodash'
import * as types from '../mutation-types'
import { objectToRouteParam } from '~/helpers'

// state
export const state = {
  all: null,
  review_material: null,
}

// getters
export const getters = {
  all: state => state.all,
  review_material: state => state.review_material,
}

// mutations
export const mutations = {
  [types.FETCH_REVIEW_MATERIALS_SUCCESS] (state, { data }) {
    state.all = data
  },
  [types.FETCH_REVIEW_MATERIALS_FAILURE] (state) {
  },
  [types.GET_REVIEW_MATERIAL_SUCCESS] (state, { data }) {
    state.review_material = data
  },
  [types.GET_REVIEW_MATERIAL_FAILURE] (state) {
  }
}

// actions
export const actions = {

  async fetch ({ commit }, data) {
    let url = '/api/review-materials'
    url += '?' + objectToRouteParam(data)
    try {
      const response = await axios.get(url)
      const data = _.get(response, 'data')
      commit(types.FETCH_REVIEW_MATERIALS_SUCCESS, { data: data })
    } catch (e) {
      console.log('Error:', e)
      commit(types.FETCH_REVIEW_MATERIALS_FAILURE)
    }
  },

  async get ({ commit }, data) {
    let url = '/api/review-materials/' + _.get(data, 'id')
    url += '?' + objectToRouteParam(data)
    try {
      const response = await axios.get(url)
      const data = _.get(response, 'data')
      commit(types.GET_REVIEW_MATERIAL_SUCCESS, { data: data })
    } catch (e) {
      console.log('Error:', e)
      commit(types.GET_REVIEW_MATERIAL_FAILURE, { data: data })
    }
  },

  clear ({ commit }, data) {
    commit(types.GET_REVIEW_MATERIAL_SUCCESS, { data: null })
    commit(types.FETCH_REVIEW_MATERIALS_SUCCESS, { data: null })
  }
}
