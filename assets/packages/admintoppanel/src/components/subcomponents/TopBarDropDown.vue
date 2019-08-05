<template>
  <div class="topbardropdown">
    <button-element v-if="mainButton" :button="mainButton" @click.native="handleClick()" />
    <ul v-if="isOpen && list" :class="'dropdown-box ' + list.class" :aria-labelledby="list.arialabelledby">
      <li v-for="(item, index) in list.items" :key="item.id">
        <link-element v-if="isActive":active="isActive":item="item" @click="handleLinkClick()"/>
        <link-element v-else :item="item" @click="handleLinkClick()"/>
      </li>
    </ul>
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

$black: #212529;
$white: #ffffff;
$green: #00b248;
$green-active: #66ffa6;

ul {
  list-style-type: none;
  li {
    position: relative;
    margin: 0.20em;
    text-align: left;
  }
}

* {
  box-sizing: border-box;
}

.dropdown-box {
  position: absolute;
  top: 100%;
  left: 0;
  display: block;
  float: left;
  border:  1px solid rgba(0,0,0,0.15);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
  background-color: $white;
  width: 200px;
}


</style>
