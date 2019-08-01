<template>
    <div class="topbarbutton">
        <!-- Button without image and btn-success -->
        <button v-if="button.icon  === undefined &&
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
               <span :class="'icon ' + button.icon" />
               2 {{ button.name }}
       </button>
       <!-- Button with outlined image, so font will be white -->
       <button v-else-if="button.icon.includes('-o')"
                   type="button"
                   :class="'btn btn-default navbar-btn button white ' + button.class"
                   :href="button.url"
                   :id="button.id">
             <span :class="button.icon + ' icon'" />
             3 {{ button.name }}
       </button>

      <!-- Dropdown Button -->
      <button v-else-if="button.class === 'dropdown-toggle'"
              type ="button"
              :class="'btn btn-default navbar-btn button ' + button.class"
              :id ="button.id"
              :data-toggle="button.datatoggle"
              :aria-haspopup="button.ariahaspopup"
              :aria-expanded="button.ariaexpanded">
              <span :class="button.icon + ' icon'" />
              5 {{ button.name }}
              <span :class="button.iconclass + ' icon'" />
      </button>

      <!-- Default Button with image -->
      <button v-else
              type = "button"
              :class = "'btn btn-default navbar-btn button ' + button.class"
              :href = "button.url"
              :target="button.target"
              :access-key="button.accesskey">
              <span :class="button.icon + ' icon'" />
              4 {{ button.name }}
     </button>
    </div>
</template>

<script>
  export default {
      name: 'TopBarButton',
      props: ['button'],
      data: () => {
          return {}
      },
  }
</script>

<style scoped lang="scss">


 .icon {
   margin-right: 2px;
  }

  .button {
    margin-left: 2px;
  }

  .white {
    color: white;
  }

  .btn-danger {
    color: white;
  }
</style>
