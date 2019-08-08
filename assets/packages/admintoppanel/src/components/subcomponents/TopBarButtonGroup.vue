<template>
  <div class="topbarbuttongroup">
    <dropdown-element v-if="list" :list="list" :mainButton="mainButton" />
  </div>
</template>

<script>
  import DropDown from './TopBarDropDown.vue';

  export default {
    name: 'TopBarButtonGroup',
    props: {
      list: Object,
      mainButton: Object,
    },
    components: {
      'dropdown-element': DropDown,
    },
    data: () => {
      return {}
    },
  }
</script>

<scoped style>

</style>
