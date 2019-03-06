import axios from 'axios'
import * as _ from 'lodash'
import * as types from '../mutation-types'
import { objectToRouteParam } from '~/helpers'

// state
export const state = {
  all: null,
  drill: null,
}

// getters
export const getters = {
  all: state => state.all,
  drill: state => state.drill,
}

// mutations
export const mutations = {
  [types.FETCH_DRILLS_SUCCESS] (state, { data }) {
    state.all = data
  },
  [types.FETCH_DRILLS_FAILURE] (state) {
  },
  [types.GET_DRILL_SUCCESS] (state, { data }) {
    state.drill = data
  },
  [types.GET_DRILL_FAILURE] (state) {
  }
}

// actions
export const actions = {

  async fetch ({ commit }, data) {
    let url = '/api/drills'
    url += '?' + objectToRouteParam(data)
    try {
      const response = await axios.get(url)
      const data = _.get(response, 'data')
      commit(types.FETCH_DRILLS_SUCCESS, { data: data })
    } catch (e) {
      console.log('Error:', e)
      commit(types.FETCH_DRILLS_FAILURE)
    }
  },

  async get ({ commit }, data) {
    let url = '/api/drills/' + _.get(data, 'id')
    url += '?' + objectToRouteParam(data)
    try {
      const response = await axios.get(url)
      const data = _.get(response, 'data')
      commit(types.GET_DRILL_SUCCESS, { data: data })
    } catch (e) {
      console.log('Error:', e)
      commit(types.GET_DRILL_FAILURE, { data: data })
    }
  },

  clear ({ commit }, data) {
    commit(types.GET_DRILL_SUCCESS, { data: null })
    commit(types.FETCH_DRILLS_SUCCESS, { data: null })
  }
}
