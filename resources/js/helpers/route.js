import * as _ from 'lodash'
import { ROUTE_NAMES } from '~/constants'

export function objectToRouteParam (data, excludeId = true) {
  const uriData = _.reduce(data, (result, val, key) => {
    if (excludeId && key === 'id') {
      return
    }
    result += key + '=' + encodeURIComponent(val)
    return result
  }, '')
  return uriData || ''
}

export function getLessonsRoute (module) {
  return {
    name: ROUTE_NAMES.LESSONS,
    params: {
      module_id: _.get(module, 'id')
    }
  }
}

export function getLessonItemsRoute (lesson) {
  return {
    name: ROUTE_NAMES.LESSONS_OPTIONS,
    params: {
      lesson_id: _.get(lesson, 'id'),
      module_id: _.get(lesson, 'module_id')
    }
  }
}
