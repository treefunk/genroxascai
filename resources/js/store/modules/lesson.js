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
  /**
   * Get all from API or Get by specific lesson_id if given
   *
   * @param commit
   * @param data
   * @returns {Promise.<void>}
   */
  async fetchLesson ({ commit }, data) {
    const moduleId = _.get(data, 'id')
    let url = moduleId ? '/api/lessons/' + moduleId : '/api/lessons'
    url += '?' + objectToRouteParam(data)
    try {
      const response = await axios.get(url)
      const data = _.get(response, 'data')
      if (moduleId) {
        commit(types.GET_LESSON_SUCCESS, { data: data })
        return
      }
      commit(types.FETCH_LESSONS_SUCCESS, { data: data })
    } catch (e) {
      console.log('Error:', e)
      if (moduleId) {
        commit(types.GET_LESSON_FAILURE, { data: data })
        return
      }
      commit(types.FETCH_LESSONS_FAILURE)
    }
  },

  clear ({ commit }, data) {
    commit(types.FETCH_LESSONS_SUCCESS, { data: null })
  }
}
