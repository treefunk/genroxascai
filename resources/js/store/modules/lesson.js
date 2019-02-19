import axios from 'axios'
import * as _ from 'lodash'
import * as types from '../mutation-types'
import { objectToRouteParam } from '~/helpers'

// state
export const state = {
  all: null,
  lesson: null
}

// getters
export const getters = {
  all: state => state.all,
  lesson: state => state.lesson
}

// mutations
export const mutations = {
  [types.FETCH_LESSONS_SUCCESS] (state, { data }) {
    state.all = data
  },

  [types.FETCH_LESSONS_FAILURE] (state) {
  },

  [types.GET_LESSON_SUCCESS] (state, { data }) {
    state.lesson = data
  },

  [types.GET_LESSON_FAILURE] (state) {
  }
}

// actions
export const actions = {

  async fetch ({ commit }, data) {
    let url = '/api/lessons'
    url += '?' + objectToRouteParam(data)
    try {
      const response = await axios.get(url)
      const data = _.get(response, 'data')
      commit(types.FETCH_LESSONS_SUCCESS, { data: data })
    } catch (e) {
      console.log('Error:', e)
      commit(types.FETCH_LESSONS_FAILURE)
    }
  },

  async get ({ commit }, data) {
    let url = '/api/lessons/' + _.get(data, 'id')
    url += '?' + objectToRouteParam(data)
    try {
      const response = await axios.get(url)
      const data = _.get(response, 'data')
      commit(types.GET_LESSON_SUCCESS, { data: data })
    } catch (e) {
      console.log('Error:', e)
      commit(types.GET_LESSON_FAILURE, { data: data })
    }
  },

  clear ({ commit }, data) {
    commit(types.GET_LESSON_SUCCESS, { data: null })
    commit(types.FETCH_LESSONS_SUCCESS, { data: null })
  }
}
