<template>
	<div>
	<app-breadcrumbs></app-breadcrumbs>
    <app-test :test_type="getTestType()"></app-test>
	</div>
</template>
<script>
  import { TEST_TYPES } from '~/constants'
  import Breadcrumbs from '~/components/breadcrumbs/index'
  import Test from '~/components/test/index'

export default {
	metaInfo() {
	  return { title: 'Pre Test' };
	},
	watch: {
	},
	components: {
	  'app-breadcrumbs': Breadcrumbs,
	  'app-test': Test
	},

	methods: {
		getTestType () {
			return TEST_TYPES.PRETEST
		}
	},
  async mounted () {
  }
}
</script>
