<template>
    <div>
        <NavbarComponent />
        <div class="body">
            <slot />
        </div>

    </div>
</template>

<script>
import NavbarComponent from '../components/NavbarComponent.vue';
export default {
    name: "DefaultLayout",
    components: {
        NavbarComponent,
    }

}
</script>

<style>

</style>