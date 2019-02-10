<template>
    <div>
        teacher dashboard
        {{ $t('you_are_logged_in') }}
    </div>
</template>

<script>
    export default {
        middleware:"teacher"
    }
</script>

<style scoped>

</style>