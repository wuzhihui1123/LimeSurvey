<template>
  <div class="topbardropdown">
    <button-element v-if="mainButton" :button="mainButton" @click.native="handleClick()" />
    <ul v-if="list" :class="list.class" :aria-labelledby="list.arialabelledby">
      <li v-for="(item, index) in list.items" :key="item.id">
        <link-element :item="item" @click="" />
      </li>
    </ul>
    <ul v-if="isOpen" class="dropdown-box list.class" :aria-labelledby="list.arialebelledby">
      <li v-for="(item, index) in list.items" :key="item.id">
        <link-element v-if="isActive":active="isActive":item="item" @click="handleLinkClick()"/>
        <link-element v-else :item="item" @click="handleLinkClick()"/>
      </li>
    </ul>

    <p>Dropdown is open: {{ isOpen }}</p>
  </div>
</template>

<script>
  import Button from './TopBarButton.vue';
  import Link from './TopBarLink.vue';

  export default {
    name: 'TopBarDropDown',
    components: {
      'button-element': Button,
      'link-element': Link,
    },
    props: ['list', 'mainButton'],
    data: () => {
      return {
        isOpen: false,
        isActive: false,
        selectedItem: 0,
      }
    },
    methods: {
      handleClick() {
        this.isOpen = !this.isOpen;

        if (this.isOpen) {
          console.log('Dropdown is open');
        } else {
          console.log('Dropdown is closed');
        }
      },
      handleLinkClick() {
        this.isActice = true;
      },
    },
  }
</script>

<style scoped lang="scss">

$white: #ffffff;
$green: #00e676;
$green-active: #66ffa6;

  ul {
    list-style-type: none;
    li {
      position: relative;
      margin: 0.25em;
      text-align: center;

      a {
        display: block;
        padding: 0.55em 1em;
        text-decoration: none;

        &:hover {
          color: $white;
          background-color: $green;
        }
        &.active {
          background-color: $green-active;
        }
      }
    }
  }

  *, ::before,
  ::after {
    box-sizing: border-box;
    padding: 0;
    margin: 0;
  }
</style>
