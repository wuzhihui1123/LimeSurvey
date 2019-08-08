<template>
  <div class="topbarbuttongroup">
    <dropdown-element v-if="list" :list="list" :mainButton="mainButton" />
    <modal-element v-if="modal" :mainButton="mainButton" :modal="modal" />
  </div>
</template>

<script>
  import DropDown from './TopBarDropDown.vue';
  import Modal from './TopBarModal.vue';

  export default {
    name: 'TopBarButtonGroup',
    props: {
      list: Object,
      mainButton: Object,
      modal: Object
    },
    components: {
      'dropdown-element': DropDown,
      'modal-element': Modal,
    },
    data: () => {
      return {}
    },
  }
</script>

<scoped style>

</style>
