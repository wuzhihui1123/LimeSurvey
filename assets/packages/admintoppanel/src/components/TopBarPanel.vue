<template>
    <div class="topbarpanel">
        <nav class="navbar navbar-default scoped-topbar-nav" >
            <transition name="fade">
                <loader-widget v-if="loading" />
            </transition>
            <template v-if="!loading">
                <transition name="fade">
                    <top-bar-content 
                        v-if="slide" 
                        item-id="topbar-extended" 
                        :leftButtons="getLeftButtonsExtended"
                        :rightButtons="getRightButtonsExtended"
                        :slotbutton="slotbutton"
                    />
                </transition>
                <transition name="fade">
                    <top-bar-content 
                        v-if="!slide" 
                        item-id="topbar-regular" 
                        :leftButtons="getLeftButtons"
                        :rightButtons="getRightButtons"
                        :slotbutton="slotbutton"
                    />
                </transition>
            </template>
        </nav>
    </div>
</template>

<script>
import filter from "lodash/filter";
import empty from "lodash/isEmpty";
import TopBarContent from "./subcomponents/TopBarContent.vue";
import runAjax from "../mixins/runAjax.js";

const EventBus = window.EventBus;

export default {
    name: "TopBarPanel",
    components: {
        TopBarContent
    },
    props: {
        initialSid: {type: Number|String, default: 0},
        initialType: {type: String, default: ''}
    },
    // TODO: Für jede Topbar muss eine eigene Struktur für die TopBarExtended erstellt werden.
    data: () => {
        return {
            slide: false,
            loading: true,
            slotbutton: null
        };
    },
    computed: {
        qid: {
            get() {
                return this.$store.state.qid;
            },
            set(newValue) {
                this.$store.commit("setQid", newValue);
            }
        },
        gid: {
            get() {
                return this.$store.state.gid;
            },
            set(newValue) {
                this.$store.commit("setGid", newValue);
            }
        },
        sid: {
            get() {
                return this.$store.state.sid;
            },
            set(newValue) {
                this.$store.commit("setSid", newValue);
            }
        },
        type: {
            get() {
                return this.$store.state.type;
            },
            set(newValue) {
                this.$store.commit("setType", newValue);
            }
        },
        showSaveButton: {
            get() {
                return this.$store.state.showSaveButton;
            },
            set(newValue) {
                this.$store.commit("setShowSaveButton", newValue);
            }
        },
        closeButtonUrl: {
            get() {
                return this.$store.state.closeButtonUrl;
            },
            set(newValue) {
                this.$store.commit("setCloseButtonUrl", newValue);
            }
        },

        ownTopBar() {
            return this.$store.state.topbar;
        },
        ownTopBarExtended() {
            return this.$store.state.topbarextended;
        },
        ownPermissions() {
            return this.$store.state.permissions;
        },
        getLeftButtons() {
            if(this.ownTopBar.alignment.left != undefined) {
                return filter(
                    this.ownTopBar.alignment.left.buttons,
                    button => !empty(button.name) || !empty(button.main_button.name)
                );
            }
            return [];
        },
        getRightButtons() {
            if(this.ownTopBar.alignment.right != undefined) {
                return filter(
                    this.ownTopBar.alignment.right.buttons,
                    button =>!(!this.showSaveButton && button.isSaveButton)
                );
            }
            return [];
        },
        getLeftButtonsExtended() {
            if(this.ownTopBarExtended.alignment.left != undefined) {
                return filter(
                    this.ownTopBarExtended.alignment.left.buttons,
                    button => !empty(button.name) || !empty(button.main_button.name)
                );
            }
            return [];
        },
        getRightButtonsExtended() {
            if(this.ownTopBarExtended.alignment.right != undefined) {
                return filter(
                    this.ownTopBarExtended.alignment.right.buttons,
                    button =>!(!this.showSaveButton && button.isSaveButton)
                );
            }
            return [];
        }
    },
    methods: {
        setType() {
            this.loading = true;
            let promise = null;
            let errorHeader = '';
            if (this.qid !== 0 && this.type === "question" && this.gid !== 0) {
                promise = this.$store.dispatch("getTopBarButtonsQuestion")
                errorHeader = "ERROR QUESTION";
            } else if (
                this.gid !== 0 &&
                this.type === "group" &&
                this.qid === 0
            ) {
                promise = this.$store.dispatch("getTopBarButtonsGroup");
                errorHeader = "ERROR GROUP";
            } else if (this.sid !== 0 && this.type == "survey") {
                promise = this.$store.dispatch("getTopBarButtonsSurvey");
                errorHeader = "ERROR SURVEY";
            } else if (this.sid !== 0 && this.type == "tokens") {
                promise = this.$store.dispatch("getTopBarButtonsTokens");
                errorHeader = "ERROR TOKEN";
            }

            promise
                .then(data => {})
                .catch(error => {
                    this.$log.error(errorHeader);
                    this.$log.error(error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        onFade(slideable) {
            this.slide = slideable;

            if (slideable) {
                $("#topbarextended").slideDown();
            } else {
                $("#topbar").slideUp();
            }
        },
        unsetThis() {
            this.sid = 0
            this.gid = 0;
            this.qid = 0;
            this.type = 'survey';
            this.showSaveButton = false;
            this.closeButtonUrl = "#";
        },
        readGlobalObject(globalObject) {
            this.unsetThis();
            this.sid = globalObject.sid;
            this.gid = globalObject.gid;
            this.qid = globalObject.qid;
            this.type = globalObject.type;
            this.showSaveButton = globalObject.showSaveButton;
            this.closeButtonUrl = globalObject.closeButtonUrl || LS.createUrl('admin/survey/sa/view/', {sid: this.sid});
        }
    },
    created() {
        this.sid = this.initialSid;
        this.type = this.initialType;

        EventBus.$on("slotbuttonSet", payload => {
            this.slotbutton = payload.html || null;
        });

        EventBus.$on("reloadTopBar", (data) => {
            this.$log.log("reloadTopBar triggered with -> ", data)
            this.readGlobalObject(window.TopBarData);
            this.setType();
        });
    },
    mounted() {
        this.readGlobalObject(window.TopBarData);
        this.setType();
        EventBus.$on("doFadeEvent", slideable => {
            this.onFade(slideable);
        });
    }
};
</script>

<style lang="scss" scoped>
.topbarpanel {
    position: relative;
    padding-right:6px;
    min-height: 50px;
}

.scoped-topbar-nav {
    .navbar {
        white-space: nowrap;
        flex-wrap: nowrap;
    }
}

.navbar,
.navbar-default {
    padding-left: 15px;
    border: none;
}

.scoped-switch-floats {
    .navbar-nav {
        li {
            float: right;
        }
    }
}

.nav > li {
    margin-left: 2px;
}

.padding-left {
    padding-left: 5px;
}

.right {
    align-self: flex-end;
}
</style>
