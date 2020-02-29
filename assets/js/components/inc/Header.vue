<template>
    <div class="col-sm-12">
        <div class="breadcrumbs-area">
            <h3>{{ title }}</h3>
            <ul>
                <li>
                    <router-link to="/" as="a">Home</router-link>
                </li>
                <li>{{ title2 }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: ['title', 'title2']
}
</script>

<style>

</style>