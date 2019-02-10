<template>
    <div>
        admin dashboard
        {{ $t('you_are_logged_in') }}
    </div>
</template>

<script>
    export default {
        middleware:'admin'
    }
</script>

<style scoped>

</style>