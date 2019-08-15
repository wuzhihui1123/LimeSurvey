'use strict'
import Vue from 'vue';
import ConsoleShim from '../../meta/lib/ConsoleShim';

class EventBus extends Vue {
  // Override Vue's $emit to call the custom meddler callback upon each event emission.
  $emit (event, ...args) {
    console.ls.log("Emitting", {event, arguments: args });
    return super.$emit(event, ...args)
  }
  // Override Vue's $emit to call the custom meddler callback upon each event emission.
  $on (event, ...args) {
    console.ls.log("Binding", {event, arguments: args });
    return super.$emit(event, ...args);
  }
}


window.EventBus = window.EventBus || (new EventBus({}));

export default window.EventBus;

