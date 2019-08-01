<template>
  <div class="unsortedlist">
    <ul v-if="list" :class="list.class" :aria-labelledby="list.arialabelledby">
      <li v-for="item in list.items" :key="item.id">
        <button-element :button="item" />
      </li>
    </ul>
  </div>
</template>

<script>
  import Button from './TopBarButton.vue';
  export default {
    name: 'TopBarDropDown',
    components: {
      'button-element': Button
    },
    props: ['list'],
    data: () => {
      return {}
    }
  }
</script>

<scoped style>

</style>
