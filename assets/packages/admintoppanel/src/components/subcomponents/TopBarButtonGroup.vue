<template>
  <div class="topbarbuttongroup">
    <!-- Main Dropdown Button -->
    <button-element :button="mainButton" />

    <!-- Dropdown -->
    <ul v-if="list" :class="list.class">
      <li v-for="item in list.items" :key="item.id">
        <button-element :button="item" />
      </li>
    </ul>
  </div>
</template>

<script>
  import Button from './TopBarButton.vue';

  export default {
    name: 'TopBarButtonGroup',
    props: ['list', 'mainButton'],
    components: {
      'button-element': Button,
    },
    data: () => {
      return {}
    },
  }
</script>

<scoped style>

</style>
