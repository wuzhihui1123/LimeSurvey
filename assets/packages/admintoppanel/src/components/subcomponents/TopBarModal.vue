<template>
  <div class="topbarmodal">
    <button-element v-if="mainButton" :button="mainButton" />
    <modals-container />
  </div>
</template>

<script>
import Button from './TopBarButton.vue';
import Modal  from './TopBarModalElement.vue';

export default {
  name: 'TopBarModal',
  props: {
    mainButton: Object,
    modal: Object,
  },
  components: {
    'button-element': Button,
    'modal-element': Modal,
  },
  data() {
    return {}
  },
  methods: {
    showModal() {
      this.$modal.show(Modal, {
        item: this.modal,
      }, {
        height: "auto"
      });
    },
    hideModal() {
      this.$modal.hide(this.modal.component_name);
    },
  },
  mounted() {
    LS.EventBus.$on('doOpenModalDisplayExport', () => {
      console.log('Received doOpenModalDisplayExport');
      this.showModal();
    });
  }
}
</script>

<style lang="scss" scoped>

</style>
