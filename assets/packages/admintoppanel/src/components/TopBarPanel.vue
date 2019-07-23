<template>
  <div class="topbarpanel">
    <nav class="navbar navbar-default">
      <div class="ls-flex flex-row" id="topbar">
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

      <div v-if="this.doFade" class="ls-flex flex-row" id="topbarextended">
          <ul v-if="this.doFade && this.fadeTopBar.alignment.left" class="nav navbar-nav ls-flex-item text-left">
            <li v-for="button in this.fadeTopBar.alignment.left.buttons">
              <topbarbutton :button="button" />
            </li>
          </ul>
          <ul v-if="this.doFade && this.fadeTopBar.alignment.right" class="nav navbar-nav ls-flex-item text-center grow-2 padding-left">
            <li v-for="button in this.fadeTopBar.alignment.right.buttons">
              <topbarbutton :button="button" />
            </li>
          </ul>
      </div>
    </nav>
  </div>
</template>

<script>
import TopBarButton from "./subcomponents/TopBarButton.vue";
import runAjax  from '../mixins/runAjax.js';
import EventBus from '../../../event-bus/event-bus.js';

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
    return {
      fadeTopBar: {
        alignment: {
          left: {
            buttons : [
              { name: 'Preview survey', url: '', icon: 'fa fa-cog' },
              { name: 'Preview', url: '', icon: 'fa-cog' },
              { name: 'Preview question group', url: '', icon: 'fa fa-cog' },
            ]
          },
          right: {
            buttons: [
              { name: 'Save', url: '', icon: 'fa fa-floppy-o', backgroundcolor: 'green' },
              { name: 'Save and close', url: '', icon: 'fa fa-check-square' },
              { name: 'Close', url: '', icon: 'fa fa-close', backgroundcolor: 'red' },
            ]
          },
        },
      },
      slide: Boolean,
      doFade: Boolean,
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

    onFade() {
      if (this.slide) {
        $('#topbar').slideDown()
        $('#topbarextended').slideUp();
      } else {
        $('#topbar').slideUp()
        $('#topbarextended').slideDown();
      }
      this.slide = !this.slide;
    }
  },

  // TODO: Wenn Event gefeuert wird, (zum Beispiel slide)
  // TODO: , dann soll dieser fade Effekt erscheinen und die andere TopBar angezeigt werden.
  // TODO: Bar in eigene Komponente schreiben, Hauptkomponente leitet dann nur noch Events und Werte an die
  // TODO: jeweilige Komponente weiter.

  created() {
      console.log('GROUPID: ', this.gid);
      console.log('SURVEYID: ', this.sid);
      console.log('QUESTIONID: ', this.qid);
      console.log('TYPE: ', this.type);

      this.doFade = false;
      this.setSurveyID(this.sid);
      this.setType(this.type);

      if (this.qid !== 0 && this.type === 'question' && this.gid !== 0) {
        this.setQuestionTopBar(this.qid);
      } else if (this.gid !== 0 && this.type === 'group' && this.qid === 0) {
         this.setQuestionGroupTopBar(this.gid);
      }
  },

  mounted() {
    console.log('TopBarPanel Vue Instance: ', this);
    console.log('EventBus ', EventBus);

    EventBus.$on('doFadeEvent', () => {
      console.log('Fade event received');
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

</style>
