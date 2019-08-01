<template>
  <div class="topbarbuttongroup">
    <!-- Main Dropdown Button -->
    <button-element :button="mainButton" />

    <!-- Dropdown -->
    <dropdown-element v-if="list" :list="list" />
  </div>
</template>

<script>
  import Button from './TopBarButton.vue';
  import DropDown from './TopBarDropDown.vue';

  export default {
    name: 'TopBarButtonGroup',
    props: ['list', 'mainButton'],
    components: {
      'button-element': Button,
      'dropdown-element': DropDown,
    },
    data: () => {
      return {}
    },
  }
</script>

<scoped style>

</style>
