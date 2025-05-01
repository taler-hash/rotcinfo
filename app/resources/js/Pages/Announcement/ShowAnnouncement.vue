<template>
    <List />
</template>
<script lang="ts" setup>
import { ref,computed, provide  } from 'vue';
import List from './components/ShowAnnouncementList.vue';
import Login from './components/ShowAnnouncementLogin.vue'
import {Toast} from 'primevue';
const isLoggedIn = ref<boolean>(false)

provide('setIsLoggedIn', (value: boolean) => {
    isLoggedIn.value = value;
});
</script>