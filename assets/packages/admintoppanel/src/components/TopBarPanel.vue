<template>
    <div class="topbarpanel">
        <loader-widget v-if="loading" />
        <nav class="navbar navbar-default scoped-topbar-nav" v-if="!loading" >
            <transition name="fade">
                <div v-if="slide" class="ls-flex ls-flex-row" id="topbarextended">
                    <ul
                        v-if="ownTopBarExtended.alignment.left"
                        class="nav navbar-nav ls-flex-item ls-flex-row nowrap text-left"
                    >
                        <li
                            v-for="button in ownTopBarExtended.alignment.left.buttons"
                            :key="button.id"
                        >
                            <button-element :button="button" />
                        </li>
                    </ul>
                    <ul
                        v-if="ownTopBarExtended.alignment.right"
                        class="nav navbar-nav ls-flex-item ls-flex-row align-content-flex-end nowrap right"
                    >
                        <li
                            v-for="button in ownTopBarExtended.alignment.right.buttons"
                            :key="button.id"
                        >
                            <button-element :button="button" />
                        </li>
                    </ul>
                </div>
            </transition>
            <transition name="fade">
                <div v-if="!slide" class="ls-flex ls-flex-row" id="topbar">
                    <ul
                        v-if="(ownTopBar.alignment.left)"
                        class="nav navbar-nav ls-flex-item ls-flex-row nowrap text-left grow-3"
                    >
                        <li v-for="button in getLeftButtons" :key="button.id">
                            <button-group-element
                                v-if="button.dropdown !== undefined &&
                                button.class.includes('btn-group')"
                                :class="button.class"
                                :list="button.dropdown"
                                :mainButton="button.main_button"
                            />
                            <button-group-element
                                v-if="button.class === 'btn-group'"
                                :class="button.class"
                                :mainButton="button.main_button"
                            />
                            <button-element v-else :button="button" />
                        </li>
                        <li v-if="slotbutton != null" v-html="slotbutton" />
                    </ul>
                    <!-- TODO: Breite der Bar dynamisch (FLEX?)-->
                    <ul
                        v-if="(ownTopBar.alignment.right) && ownTopBar.alignment.right.buttons.length >= 1"
                        class="nav navbar-nav ls-flex-item  ls-flex-row nowrap align-content-flex-end text-right padding-left scoped-switch-floats"
                    >
                        <li
                            v-for="button in ownTopBar.alignment.right.buttons"
                            :key="button.id"
                        >
                            <button-element :button="button" />
                        </li>
                    </ul>
                </div>
            </transition>
        </nav>
    </div>
</template>

<script>
import filter from "lodash/filter";
import empty from "lodash/isEmpty";
import Button from "./subcomponents/TopBarButton.vue";
import ButtonGroup from "./subcomponents/TopBarButtonGroup.vue";
import runAjax from "../mixins/runAjax.js";

const EventBus = window.EventBus;

export default {
    name: "TopBarPanel",
    components: {
        "button-element": Button,
        "button-group-element": ButtonGroup,
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
            return filter(
                this.ownTopBar.alignment.left.buttons,
                button => !empty(button.name)
            );
        }
    },
    methods: {
        setType() {
            if (this.qid !== 0 && this.type === "question" && this.gid !== 0) {
                this.setQuestionTopBar(this.qid);
            } else if (
                this.gid !== 0 &&
                this.type === "group" &&
                this.qid === 0
            ) {
                this.setQuestionGroupTopBar(this.gid);
            } else if (this.sid !== 0 && this.type == "survey") {
                this.setSurveyTopBar(this.sid);
            } else if (this.sid !== 0 && this.type == "tokens") {
                this.setTokenTopBar(this.sid);
            }
        },

        setQuestionTopBar(questionID) {
            this.qid = questionID;
            this.$store
                .dispatch("getTopBarButtonsQuestion")
                .then(data => {})
                .catch(error => {
                    this.$log.error("ERROR QUESTION");
                    this.$log.error(error.xhr.responseText);
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        setQuestionGroupTopBar(groupID) {
            this.gid = groupID;
            this.$store
                .dispatch("getTopBarButtonsGroup")
                .then(data => {})
                .catch(error => {
                    this.$log.error("ERROR GROUP");
                    this.$log.error(error.xhr.responseText);
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        setSurveyTopBar(surveyID) {
            this.sid = surveyID;
            this.$store
                .dispatch("getTopBarButtonsSurvey")
                .then(data => {})
                .catch(error => {
                    this.$log.error("ERROR SURVEY");
                    this.$log.error(error.error.xhr.responseText);
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        setTokenTopBar(surveyID) {
            this.sid = surveyID;
            this.$store
                .dispatch("getTopBarButtonsTokens")
                .then(data => {})
                .catch(error => {
                    this.$log.error("ERROR SURVEY");
                    this.$log.error(error.error.xhr.responseText);
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
        readGlobalObject(globalObject) {
            
            this.sid = globalObject.sid;
            this.gid = globalObject.gid;
            this.qid = globalObject.qid;
            this.type = globalObject.type;
            this.showSaveButton = globalObject.showSaveButton;
        }
    },
    created() {
        this.sid = this.initialSid;
        this.type = this.initialType;

        EventBus.$on("slotbuttonSet", payload => {
            this.slotbutton = payload.html || null;
        });

        EventBus.$on("reloadTopBar", () => {
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
