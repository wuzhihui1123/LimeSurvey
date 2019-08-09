<template>
    <div class="topbarbutton">
        <!-- Button without image and btn-success -->
        <a v-if="button.icon  === undefined &&
                      button.class === 'btn-success' &&
                      button.id"
                type="button"
                :class="'btn btn-default navbar-btn button white ' + button.class"
                :href="button.url"
                :id="button.id">
                1 {{ button.name }}
       </button>
              
       <!-- Button with image and btn-danger -->
       <button v-else-if="button.class === 'btn-danger' && button.icon !== undefined"
               type="button"
               :class="'btn btn-default navbar-btn button white ' + button.class"
               :href="button.url"
               :id="button.id">
               <span :class="'icon ' + button.icon || ''" />
               2 {{ button.name }}
       </a>

       <!-- Button with outlined image, so font will be white -->
       <button v-else-if="button.icon.includes('-o') &&
                          button.class               &&
                          button.url                 && 
                          button.id"
                   type="button"
                   :class="'btn btn-default navbar-btn button white ' + button.class"
                   :href="button.url"
                   :id="button.id">
             <span :class="button.icon || '' + ' icon'" />
             3 {{ button.name }}
       </a>

      <!-- Dropdown Button -->
      <button v-else-if="button.class === 'dropdown-toggle'"
              type ="button"
              :class="'btn btn-default navbar-btn button ' + button.class"
              :id ="button.id"
              :data-toggle="button.datatoggle"
              :aria-haspopup="button.ariahaspopup"
              :aria-expanded="button.ariaexpanded"
              @click="clicked()">
              <span :class="button.icon || '' + ' icon'" />
              4 {{ button.name }}
              <span :class="button.iconclass + ' icon'" />
      </button>

      <!-- Button with class readonly -->
      <button v-else-if="button.class === 'readonly' && 
                         button.dataplacement === 'bottom'"
              type = "button"
              :data-placement="button.dataplacement"
              :class ="'btn btn-default navbar-btn button ' + button.class"
              :data-toggle="button.datatoggle"
              :title ="button.title">
              <span v-if="button.icon !== undefined" :class="'icon ' + button.icon" />
              {{ button.name }}
              <span v-if="button.iconclass !== undefined" :class="'icon ' + button.iconclass" />
      </button>

      <!-- Default Button with image -->
      <a v-else
              type = "button"
              :class = "'btn btn-default navbar-btn button ' + button.class"
              :href = "button.url"
              :target="button.target"
              :access-key="button.accesskey">
              <span :class="button.icon || '' + ' icon'" />
              5 {{ button.name }}
     </a>
    </div>
</template>

<script>
  export default {
      name: 'TopBarButton',
      props: ['button'],
      data: () => {
          return {}
      },
      methods: {
        clicked(event) {
          this.$emit('click', this.button, event);
        },
      },
  }
</script>

<style scoped lang="scss">


 .icon {
   margin-right: 2px;
  }

  .white {
    color: white;
  }

  .btn-danger {
    color: white;
  }
</style>
