<template>
    <div class="topbarbutton">
        <!-- Button without image and btn-success -->
        <a
            v-if="buttonIcon  === '' &&
                      button.class === 'btn-success' &&
                      button.id"
            type="button"
            :class="'btn btn-default navbar-btn button white ' + button.class"
            :href="button.url"
            :id="button.id"
            data-btntype="1"
        >
            {{ button.name }}
            <span
                v-if="button.iconclass !== undefined"
                :class="'icon ' + button.iconclass"
            />
        </a>

        <!-- Button with image and btn-danger -->
        <a
            v-else-if="button.class === 'btn-danger' && buttonIcon !== ''"
            type="button"
            :class="'btn btn-default navbar-btn button white ' + button.class"
            :href="button.url"
            :id="button.id"
            data-btntype="2"
        >
            <span :class="'icon ' + buttonIcon" />
            {{ button.name }}
            <span
                v-if="button.iconclass !== undefined"
                :class="'icon ' + button.iconclass"
            />
        </a>

        <!-- Button with outlined image, so font will be white -->
        <a
            v-else-if="buttonIcon.includes('-o') &&
                          button.class               &&
                          button.url                 && 
                          button.id"
            type="button"
            :class="'btn btn-default navbar-btn button white ' + button.class"
            :href="button.url"
            :id="button.id"
            data-btntype="3"
        >
            <span :class="buttonIcon + ' icon'" />
            {{ button.name }}
        </a>

        <!-- Dropdown Button -->
        <button
            v-else-if="button.class === 'dropdown-toggle'"
            type="button"
            :class="'btn btn-default navbar-btn button ' + button.class"
            :id="button.id"
            :data-toggle="button.datatoggle"
            :aria-haspopup="button.ariahaspopup"
            :aria-expanded="button.ariaexpanded"
            @click="clicked()"
            data-btntype="4"
        >
            <span :class="buttonIcon + ' icon'" />
            {{ button.name }}
            <span :class="button.iconclass + ' icon'" />
        </button>

        <!-- Button with class readonly -->
        <button
            v-else-if="button.class === 'readonly' && 
                         button.dataplacement === 'bottom'"
            type="button"
            :data-placement="button.dataplacement"
            :class="'btn btn-default navbar-btn button ' + button.class"
            :data-toggle="button.datatoggle"
            :title="button.title"
            data-btntype="5ro"
        >
            <span v-if="buttonIcon !== ''" :class="'icon ' + button.icon" />
            {{ button.name }}
            <span
                v-if="button.iconclass !== undefined"
                :class="'icon ' + button.iconclass"
            />
        </button>

        <!-- Default Button with image -->
        <a
            v-else
            type="button"
            :class="'btn btn-default navbar-btn button ' + button.class"
            :href="button.url"
            :target="button.target"
            :access-key="button.accesskey"
            data-btntype="5"
        >
            <span :class="buttonIcon + ' icon'" />
            {{ button.name }}
            <span
                v-if="button.iconclass !== undefined"
                :class="'icon ' + button.iconclass"
            />
        </a>
    </div>
</template>

<script>
export default {
    name: "TopBarButton",
    props: ["button"],
    data: () => {
        return {};
    },
    computed: {
        buttonIcon() {
            return this.button.icon || "";
        }
    },
    methods: {
        clicked(event) {
            this.$emit("click", this.button, event);
        }
    }
};
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
