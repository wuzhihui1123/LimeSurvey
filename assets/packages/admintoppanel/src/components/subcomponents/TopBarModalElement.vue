<template>
  <!-- TODO: WIDGET ALS SLOT ANZEIGEN LASSEN, php code über vue komponente -> mit getModal(true)
  <div class="topbarmodalelement">
    <h4><b>{{ item.title }}</b></h4>
    <hr>
    <div v-if="item.items" class="modalitems">
      <link-element v-for="(exportItem, index) in item.items" :key="exportItem.id"
                    :item="exportItem"
                    :preview_title="item.preview_title"
                    @click.native.prevent="showContent(index)" />
    </div>
    <!-- TODO: Modal Content muss rechts neben den Items stehen -->
    <div class="modalcontent">
      <!-- <h5><b>{{ item.preview_title }}</b></h5>
      <div v-if="show">
        <h5> {{ currentSelectedItem.title }}</h5>
        <div v-for="(detail, index) in currentSelectedItem.details" :key="detail.id">
          <p v-if="index === 'p'">{{ detail }}</p>
          <p v-if="index === 'pb'"><b>{{ detail }}</b></p>
          <!-- TODO: Liste Details muss gerendert werden -->
          <!-- <ul v-if="index === 'ul'">

          </ul>
        </div>
      </div>
      <h5 v-else>{{ item.current_selected_item }}</h5>
    </div>
    <hr>
    <div class="content-footer" v-if="item.buttons">
      <button-element v-for="button in item.buttons" :item="button" />
    </div> -->
  </div>
</template>

<script>
import Button from './TopBarButton.vue';
import Link from './TopBarLink.vue';

export default {
  name: 'TopBarModalElement',
  components: {
    'button-element': Button,
    'link-element': Link,
  },
  props: {
    item: {
      component_name: String,
      title: String,
      preview_title: String,
      current_selected_item: String,
      items: Object,
      buttons: Object,
    }
  },
  data() {
    return {
      show: false,
      currentSelectedItem: Object,
    }
  },
  methods: {
    showContent(index) {
      console.log('Inside ShowContent(Index): ', index.toString());
      this.currentSelectedItem = this.item.items[index];
      console.log('currentSelectedItem: ', this.currentSelectedItem);
      this.show = true;
    },
  }
}
</script>

<style lang="scss" scoped>
  $grey: #bdbdbd;
  $white: #ffffff;
  $green: #00b248;

  .modalitems {
    box-sizing: border-box;
    border: 1px solid $grey;
    display: flex;
    flex-direction: column;
    width: 45%;
    margin-left: 5%;
  }

  .modalcontent {
    width: 55%;
    margin-left: 5%;
  }

</style>
