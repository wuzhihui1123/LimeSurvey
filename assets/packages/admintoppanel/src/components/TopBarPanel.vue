<template>
  <div class="topbarpanel">
    <nav class="navbar navbar-default">
      <div class="ls-flex" id="navbar-topbar">
        <ul v-if="(this.ownTopBar.alignment.left)" class="nav navbar-nav ls-flex-item align-content-flex-begin">
            <li v-for="button in this.ownTopBar.alignment.left.buttons" :key="button.id">
              <topbarbutton :button="button" />
            </li>
        </ul>
        <ul v-if="(this.ownTopBar.alignment.right)" class="nav navbar-nav ls-flex-item align-content-flex-end">
            <li v-for="button in this.ownTopBar.alignment.right.buttons" :key="button.id">
              <topbarbutton :button="button" />
            </li>
        </ul>
      </div>
    </nav>
  </div>
</template>

<script>
import TopBarButton from "./subcomponents/TopBarButton.vue";

export default {
  name: 'TopBarPanel',
  props: ['permissions', 'topbar'],
  components: {
    'topbarbutton': TopBarButton,
  },
  data: () => {
    return {
      'ownPermissions' : Array,
      'ownTopBar'      : {
        'alignment': {}
      },
    }
  },
  methods: {
    setPermissions(permissions) {
      this.$store.commit('setPermissions', permissions);
    },

    setTopBar(topbar) {
      this.$store.commit('setTopBar', topbar);
    },

  },
  mounted() {
    this.ownPermissions = this.permissions;
    this.ownTopBar = this.topbar;

    this.setPermissions(this.ownPermissions);
    this.setTopBar(this.topbar);
  }
}
</script>

<style lang="scss" scoped>
  .nav {
    width: 100%;
  }
</style>
