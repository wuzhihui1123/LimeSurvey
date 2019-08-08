<template>
  <div class="topbarlink">
    <a v-if="item.url  &&
             item.name &&
             item.icon === ''"
      :href="item.url">
      1 {{ item.name }}
    </a>
    <a v-else-if="item.url  &&
                  item.name &&
                  item.icon !== ''"
      :href="item.url">
      <span :class="item.icon + ' icon'" />
      2 {{ item.name }}
    </a>
    <a v-else-if="item.url   &&
                  item.title &&
                  preview_title !== ''"
      :href="item.url">
      3 {{ item.title }} <small><i>{{ preview_title}} {{ item.title }}</i></small>
    </a>
  </div>
</template>

<script>
export default {
  name: 'TopBarLink',
  props: {
    item: Object,
    active: Boolean,
    preview_title: String,
  },
  data() {
    return {}
  },
}
</script>

<style lang="scss" scoped>
  $black: #212529;
  $white: #ffffff;
  $green: #00b248;
  $green-active: #66ffa6;

  .icon {
    margin-right: 2px;
  }

  a {
    display: block;
    padding: 0.55em 1em;
    text-decoration: none;
    color: $black;

    &:hover {
      text-decoration: none;
      color: $white;
      background-color: $green;
    }

    &.active {
      background-color: $green-active;
    }
  }
</style>
