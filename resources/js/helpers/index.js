export * from './route'
export * from './animation'
import * as _ from 'lodash'

export function isLocked(item) {
  return _.get(item, 'is_locked')
}