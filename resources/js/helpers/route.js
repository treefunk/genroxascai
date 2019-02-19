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

export function getModulesRoute () {
  return {
    name: ROUTE_NAMES.MODULES
  }
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

// Material (single)
export function getReviewMaterialRoute (reviewMaterial, module) {
  return {
    name: ROUTE_NAMES.REVIEW_MATERIAL,
    params: {
      module_id: _.get(module, 'id'),
      lesson_id: _.get(reviewMaterial, 'lesson_id'),
      review_material_id: _.get(reviewMaterial, 'id')
    }
  }
}

// Materials (plural)
export function getReviewMaterialsRoute (lesson) {
  return {
    name: ROUTE_NAMES.REVIEW_MATERIALS,
    params: {
      module_id: _.get(lesson, 'module_id'),
      lesson_id: _.get(lesson, 'id'),
    }
  }
}

