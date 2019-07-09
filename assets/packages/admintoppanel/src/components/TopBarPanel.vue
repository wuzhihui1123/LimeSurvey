<template>
  <div class="topbarpanel">
    <nav class="navbar navbar-default">  
      <div class="collapse navbar-collapse" id="navbar-topbar"> 
          <ul class="nav navbar-nav">
              <li v-for="button in ownButtons" :key="button.id">
                <topbarbutton :button="button" />
              </li>
          </ul>        
      </div>
    </nav>
  </div>
</template>

<script>
import TopBarButton from "./TopBarButton.vue";

export default {
  name: 'TopBarPanel',
  props: ['permissions', 'buttons'],
  components: {
    'topbarbutton': TopBarButton,
  },
  data: () => {
    return {
      'ownPermissions' : Array, 
      'ownButtons'     : Array,
    }
  },
  mounted() {
    this.ownPermissions = JSON.parse(this.permissions);
    this.ownButtons     = JSON.parse(this.buttons);
  }
}
</script>

<style lang="scss" scoped>

</style>
