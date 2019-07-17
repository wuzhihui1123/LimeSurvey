<template>
  <div class="topbarpanel">
    <nav class="navbar navbar-default">
      <div class="ls-flex flex-row" id="navbar-topbar">
        <ul v-if="(this.ownTopBar.alignment.left)" class="nav navbar-nav ls-flex-item text-left">
            <li v-for="button in this.ownTopBar.alignment.left.buttons" :key="button.id">
              <topbarbutton :button="button" />
            </li>
        </ul>
        <ul v-if="(this.ownTopBar.alignment.right)" class="nav navbar-nav ls-flex-item text-center grow-2 padding-left">
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
  props: {

    'permissions': {
      type: Object,
      default: () => {
        return {}
      }
    },

    'topbar': {
      type: Object,
      default: () => {
        return {}
      },
    },

    'qid': {
      type: Number,
      default: () => {
        return 0
      },
    },

    'gid': {
      type: Number,
      default: () => {
        return 0
      }
    },

    type: String,

  },
  components: {
    'topbarbutton': TopBarButton,
  },
  data: () => {
    return {
      'ownPermissions' : {},
      'ownTopBar'      : {
        'alignment': {}
      },
    }
  },
  methods: {
    getTopBar() {
      return this.$store.state.topbar;
    },

    getPermissions() {
      return this.$store.state.permissions;
    },

    setType(type) {
      this.$store.commit('setType', type);
    },

  },

  created() {

      console.log('GID: ', this.gid);
      console.log('QID: ', this.qid);
      console.log('TYPE: ', this.type);

      if (this.qid !== 0 && this.type === 'question') {
        this.$store.commit('setQid', this.qid);
        this.$store.commit('setType', this.type);
        this.$store.dispatch('getTopBarButtonsQuestion')
          .then( (data) => {
              console.log('ERFOLGREICH');
              this.ownTopBar      = this.getTopBar();
              this.ownPermissions = this.getPermissions();
          })
          .catch( (error) => {
              console.log('FEHLERHAFT');
              console.log(error.error.xhr.responseText);
          });
      }

      if (this.gid !== 0 && this.type === 'group') {
        this.$store.commit('setGid', this.gid);
        this.$store.commit('setType', this.type);
        this.$store.dispatch('getTopBarButtonsGroup')
          .then( (data) => {
            this.ownTopBar      = this.getTopBar();
            this.ownPermissions = this.getPermissions();
          })
          .catch( (error) => {
            console.log('FEHLERHAFT');
            console.log(error.error.xhr.responseText);
          })
      }

  },

  mounted() {}
}
</script>

<style lang="scss" scoped>

  .topbarpanel {
    box-shadow: 3px 3px 3px #35363f;
  }

  .padding-left {
    padding-left: 155px;
  }

</style>
