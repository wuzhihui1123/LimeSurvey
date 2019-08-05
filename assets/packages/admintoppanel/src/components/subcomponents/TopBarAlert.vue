<template>
  <div class="topbaralert">
    <div v-if="show" v-model="show" class="alert alert-info">
      {{ item.alerttext }}
    </div>
  </div>
</template>

<script>
export default {
  name: 'TopBarAlert',
  props: {
    item: Object,
  },
  data() {
    return {
      show: false,
    }
  },
}
</script>

<style scoped>

</style>
