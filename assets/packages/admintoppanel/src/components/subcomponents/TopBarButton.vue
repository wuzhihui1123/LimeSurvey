<template>
    <div class="topbarbutton">
        <button type ="button" class="btn btn-default navbar-btn button" :href="button.url">
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
   margin-right: 2px;
  }
  .button {
    margin-left: 2px;
  }
</style>
