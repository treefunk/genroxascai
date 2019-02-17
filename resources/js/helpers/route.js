import * as _ from 'lodash'
import { ROUTE_NAMES } from '~/constants'

export function getLessonsRoute (module) {
  return {
    name: ROUTE_NAMES.LESSONS,
    params: {
      module_id: _.get(module, 'id')
    }
  }
}