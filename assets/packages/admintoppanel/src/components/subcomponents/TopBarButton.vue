<template>
    <div class="topbarbutton">
        <!-- Button without image and btn-success -->
        <button v-if="button.icon === undefined && button.class === 'btn-success'"
                type="button"
                :class="'btn btn-default navbar-btn white ' + button.class"
                :href="button.href"
                :id="button.id">
                {{ button.name }}
       </button>

      <!-- Button with image and btn-danger -->
      <button v-if="button.class === 'btn-danger' && button.icon !== undefined"
              type="button"
              :class="'btn btn-default navbar-btn white ' + button.class"
              :href="button.url"
              :id="button.id">
              <span :class="'icon ' + button.icon" />
                {{ button.name }}
      </button>

      <button v-if="button.class && button.icon.includes('-o')"
                  type="button"
                  :class="'btn btn-default navbar-btn white ' + button.class"
                  :href="button.url"
                  :id="button.id">
            <span :class="button.icon + ' icon'" />
            {{ button.name }}
      </button>
      <button v-else-if="button.class"
                  type="button"
                  :class="'btn btn-default navbar-btn ' + button.class"
                  :href="button.url"
                  :id="button.id"
                  :target="button.target">
                  <span :class="button.icon + ' icon'" />
                  {{ button.name }}
      </button>
      <!-- Default Button with Image -->
      <button v-else-if="button.url !== '' && button.class !== '' && button.icon !== undefined"
              type ="button" class="btn btn-default navbar-btn button" :href="button.url">
              <span :class="button.icon + ' icon'" />
              {{ button.name }}
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
