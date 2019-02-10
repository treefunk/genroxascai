<template>
    <div>
        teacher dashboard
        {{ $t('you_are_logged_in') }}

        <router-link :to="{ name: 'modules_index'}">{{ $t('Modules') }}</router-link>
    </div>
</template>

<script>
    export default {
        middleware:"teacher"
    }
</script>

<style scoped>

</style>