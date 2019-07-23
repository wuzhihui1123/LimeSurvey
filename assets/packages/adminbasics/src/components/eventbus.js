import Vue from 'vue';
export default function getEventBus() {
    if(!(window.EventBus instanceof Vue)) {
        const EventBus = new Vue();
        window.EventBus = EventBus;
    }
    return window.EventBus;
}
