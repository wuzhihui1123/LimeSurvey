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
  components: {
    'topbarbutton': TopBarButton,
  },
  props: {
    permissions: Object,
    topbar: Object,
    qid: Number,
    gid: Number,
    type: String,
  },
  data: () => {
    return {}
  },
  computed: {
    ownTopBar() {
      return this.$store.state.topbar;
    },
    ownPermissions() {
      return this.$store.state.permissions;
    },
  },
  methods:  {
    setType(type) {
      this.$store.commit('setType', type);
    },

    setQid(id) {
      this.$store.commit('setQid', id);
    },

    setGid(id) {
      this.$store.commit('setGid', id);
    },

    setQuestionTopBar(questionID, type) {
      this.setQid(questionID);
      this.setType(type);
      this.$store.dispatch('getTopBarButtonsQuestion')
        .then( (data) => {
          console.log('ERFOLGREICH QUESTION');
        })
        .catch( (error) => {
            console.log('FEHLERHAFT QUESTION');
            console.log(error.xhr.responseText);
        });
    },

    setQuestionGroupTopBar(groupID, type) {
      this.setGid(groupID);
      this.setType(type);
      this.$store.dispatch('getTopBarButtonsGroup')
        .then( (data) => {
          console.log('ERFOLGREICH GROUP');
        })
        .catch( (error) => {
          console.log('FEHLERHAFT GROUP');
          console.log(error.xhr.responseText);
        })
    },
  },

  created() {
      console.log('GID: ', this.gid);
      console.log('QID: ', this.qid);
      console.log('TYPE: ', this.type);

      if (this.qid !== 0 && this.type === 'question') {
        this.setQuestionTopBar(this.qid, this.type);
      }

      if (this.gid !== 0 && this.type === 'group') {
        this.setQuestionGroupTopBar(this.gid, this.type);
      }

  },
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
