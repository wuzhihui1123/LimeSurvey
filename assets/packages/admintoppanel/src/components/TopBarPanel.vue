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
    sid: Number,
    type: String,
  },
  data: () => {
    return {}
  },
  computed: {
    ownTopBar: {
      get() {
        return this.$store.state.topbar;
      },
      set(topbar) {
        this.$store.commit('setTopBar', topbar);
      }
    },
    ownPermissions: {
      get() {
        return this.$store.state.permissions;
      },
    },
  },
  watch: {
    ownTopBar: function (newValue) {
      console.log('oldValue : ', this.ownTopBar);
      console.log('newValue : ', newValue);
      this.ownTopBar = newValue;
    },
  },
  methods:  {
    setType(type) {
      this.$store.commit('setType', type);
    },

    setSurveyID(id) {
      this.$store.commit('setSid', id);
    },

    setQuestionID(id) {
      this.$store.commit('setQid', id);
    },

    setGroupID(id) {
      this.$store.commit('setGid', id);
    },

    setQuestionTopBar(questionID) {
      this.setQuestionID(questionID);
      this.$store.dispatch('getTopBarButtonsQuestion')
        .then( (data) => {
          console.log('SUCCESS QUESTION');
          console.log('TOPBAR :' , data);
        })
        .catch( (error) => {
            console.log('ERROR QUESTION');
            console.log(error.xhr.responseText);
        });
    },

    setQuestionGroupTopBar(groupID) {
      this.setGroupID(groupID);
      this.$store.dispatch('getTopBarButtonsGroup')
        .then( (data) => {
          console.log('SUCCESS GROUP');
          console.log('TOPBAR :' , data);
        })
        .catch( (error) => {
          console.log('ERROR GROUP');
          console.log(error.xhr.responseText);
        })
    },
  },

  created() {
      console.log('GROUPID: ', this.gid);
      console.log('SURVEYID: ', this.sid);
      console.log('QUESTIONID: ', this.qid);
      console.log('TYPE: ', this.type);

      this.setSurveyID(this.sid);
      this.setType(this.type);

      if (this.qid !== 0 && this.type === 'question' && this.gid !== 0) {
        this.setQuestionTopBar(this.qid);
      } else if (this.gid !== 0 && this.type === 'group' && this.qid === 0) {
         this.setQuestionGroupTopBar(this.gid);
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
