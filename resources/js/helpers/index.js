export * from './route'
export * from './animation'
export * from './sound'
import * as _ from 'lodash'

export function isLocked(item) {
  return _.get(item, 'is_locked')
}