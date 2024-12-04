<script setup lang="ts">
const props = defineProps(['message'])

</script>

<template>
    <div v-show="message">
        <template v-if="typeof props.message === 'string'">
            <p class="text-sm text-red-600">
                {{ props.message }}
            </p>
        </template>
        <template v-if="Array.isArray(props.message)">
            <p v-for="message in props.message" class="text-sm text-red-600">
                {{ message }}
            </p>
        </template>
    </div>
</template>
