<template>
  <div class="topbarlink">
    <a v-if="item.url && item.name && item.icon === ''"
      :href="item.url">
      1 {{ item.name }}
    </a>
    <a v-else-if="item.url &&
                  item.name &&
                  item.icon !== ''"
      :href="item.url">
      <span :class="item.icon + ' icon'" />
      2 {{ item.name }}
    </a>
  </div>
</template>

<script>
export default {
  name: 'TopBarLink',
  props: {
    item: Object,
    active: Boolean
  },
  data() {
    return {}
  },
}
</script>

<scoped style>
  .icon {
    margin-right: 2px;
  }
</style>
