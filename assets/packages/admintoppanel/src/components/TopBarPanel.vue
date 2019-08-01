<template>
  <div class="topbarpanel">
    <nav class="navbar navbar-default">
      <transition name="fade">
      <div v-if="this.slide" class="ls-flex flex-row" id="topbarextended">
          <ul v-if="this.slide && this.ownTopBarExtended.alignment.left" class="nav navbar-nav ls-flex-item text-left">
            <li v-for="button in this.ownTopBarExtended.alignment.left.buttons">
              <topbarbutton :button="button" />
            </li>
          </ul>
          <ul v-if="this.slide && this.ownTopBarExtended.alignment.right" class="nav navbar-nav ls-flex-item right">
            <li v-for="button in this.ownTopBarExtended.alignment.right.buttons">
              <topbarbutton :button="button" />
            </li>
          </ul>
      </div>
    </transition>
    <transition name="fade">
      <div v-if="!this.slide" class="ls-flex flex-row" id="topbar">
        <ul v-if="(this.ownTopBar.alignment.left)" class="nav navbar-nav ls-flex-item text-left">
            <li v-for="button in this.ownTopBar.alignment.left.buttons" :key="button.id">
              <topbarbuttongroup v-if="button.class !== undefined && button.class.includes('btn-group')" :class="button.class" :list="button.dropdown" :mainButton="button.main_button" />
              <topbarbutton v-else :button="button" />
            </li>
        </ul>
        <ul v-if="(this.ownTopBar.alignment.right)" class="nav navbar-nav ls-flex-item text-center grow-2 padding-left">
            <li v-for="button in this.ownTopBar.alignment.right.buttons" :key="button.id">
              <topbarbutton :button="button" />
            </li>
        </ul>
      </div>
    </transition>
    </nav>
  </div>
</template>

<script>
import TopBarButton from "./subcomponents/TopBarButton.vue";
import TopBarButtonGroup from "./subcomponents/TopBarButtonGroup.vue";
import runAjax  from '../mixins/runAjax.js';
import EventBus from '../../../event-bus/event-bus.js';

export default {
  name: 'TopBarPanel',
  components: {
    'topbarbutton': TopBarButton,
    'topbarbuttongroup': TopBarButtonGroup,
  },
  props: {
    qid: Number,
    gid: Number,
    sid: Number,
    type: String,
  },

  // TODO: Für jede Topbar muss eine eigene Struktur für die TopBarExtended erstellt werden.
  data: () => {
    return {
      slide: false,
    }
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
    ownTopBarExtended: {
      get() {
        return this.$store.state.topbarextended;
      }
    },
    ownPermissions: {
      get() {
        return this.$store.state.permissions;
      },
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

        })
        .catch( (error) => {
          console.log('ERROR GROUP');
          console.log(error.xhr.responseText);
        })
    },

    setSurveyTopBar(surveyID) {
        this.setSurveyID(surveyID);
        this.$store.dispatch('getTopBarButtonsSurvey')
          .then( (data) => {

          })
          .catch( (error) => {
            console.log('ERROR SURVEY');
            console.log(error.error.xhr.responseText);
          })
    },

    onFade(slideable) {
      this.slide = slideable;

      if (slideable) {
        $('#topbarextended').slideDown();
      } else {
        $('#topbar').slideUp();
      }
    }
  },
  created() {
      // this.setSurveyID(this.sid);
      this.setType(this.type);

      if (this.qid !== 0 && this.type === 'question' && this.gid !== 0) {
        this.setQuestionTopBar(this.qid);
      } else if (this.gid !== 0 && this.type === 'group' && this.qid === 0) {
         this.setQuestionGroupTopBar(this.gid);
      } else if (this.sid !== 0 && this.type == 'survey') {
        this.setSurveyTopBar(this.sid);
      }
  },
  mounted() {
    EventBus.$on('doFadeEvent', (slideable) => {
      this.onFade(slideable);
    });
  }
}
</script>

<style lang="scss" scoped>

  .topbarpanel {
    box-shadow: 3px 3px 3px #35363f;
  }

  .padding-left {
    padding-left: 155px;
  }

  .right {
    padding-left: 40%;
  }
</style>
