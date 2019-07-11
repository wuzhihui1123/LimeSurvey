<template>
    <div class="topbarbutton">
        <button v-if="button.align === 'right'" type="button" class="btn btn-default navbar-btn button navbar-right" :href="button.url">
          <span :class="button.icon + ' icon'" />
          {{ button.name }}
        </button>
        <button v-else type ="button" class="btn btn-default navbar-btn button" :href="button.url">
            <span :class="button.icon + ' icon'" />
            {{ button.name }}
        </button>
    </div>
</template>

<script>
    export default {
        name: 'TopBarButton',
        props: ['button'],
        data: () => {
            return {}
        },
    }
</script>

<style scoped lang="scss">
 .icon {
    margin-right: 5px;
  }
  .button {
    margin-left: 2px;
  }
</style>
