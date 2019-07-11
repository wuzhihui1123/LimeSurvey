import Vue from 'vue';
import TopBarPanel from './components/TopBarPanel.vue';
import getAppState from "./storage/store.js";
import {PluginLog} from "./mixins/logSystem.js";
import Loader from './helperComponents/loader.vue';

//Ignore phpunits testing tags
Vue.config.ignoredElements = ["x-test"];
Vue.config.devtools = true;

Vue.use( PluginLog );

Vue.component('loader-widget', Loader);

Vue.mixin({
  methods: {
      translate: (value) => {
          return window.TopBarData.i10N[value] || value;
      }
  },
  filters: {
      translate: (value) => {
          return window.TopBarData.i10N[value] || value;
      }
  }
});

let surveyid = 'newSurvey';
if(window.LS != undefined) {
    surveyid = window.LS.parameters.$GET.surveyid || window.LS.parameters.keyValuePairs.surveyid;
}

const AppState = getAppState(LS.globalUserId, surveyid);

const topBarVue =  new Vue({
  el: "#vue-topbar-container",
  store: AppState,
  components: {
      topbar: TopBarPanel,
  },
});
