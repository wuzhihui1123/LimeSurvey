<template>
    <div class="ls-flex ls-flex-row" :id="itemId">
        <ul
            class="nav navbar-nav ls-flex-item ls-flex-row nowrap text-left grow-3"
        >
            <li v-for="button in leftButtons" :key="button.id">
                <button-group-element
                    v-if="button.dropdown !== undefined &&
                    button.class.includes('btn-group')"
                    :class="button.class"
                    :list="button.dropdown"
                    :mainButton="button.main_button"
                />
                <divider-element v-else-if="button.class.includes('divider')" :button="button" />
                <button-element v-else :button="button" />
            </li>
            <li v-if="slotbutton != null" v-html="slotbutton" />
        </ul>
        <!-- TODO: Breite der Bar dynamisch (FLEX?)-->
        <ul
            v-if="rightButtons.length >= 1"
            class="nav navbar-nav ls-flex-item  ls-flex-row nowrap align-content-flex-end text-right padding-left scoped-switch-floats"
        >
            <li
                v-for="button in rightButtons"
                :key="button.id"
            >
                <button-group
                    v-if="button.dropdown !== undefined &&
                    button.class.includes('btn-group')"
                    :class="button.class"
                    :list="button.dropdown"
                    :mainButton="button.main_button"
                />
                <divider-element v-else-if="button.class.includes('divider')" :button="button" />
                <button-element v-else :button="button" />
            </li>
        </ul>
    </div>
</template>

<script>

import Divider from "./TopBarDivider.vue";
import Button from "./TopBarButton.vue";
import ButtonGroup from "./TopBarButtonGroup.vue";

export default {
    name: "TopBarContent",
    props: {
        itemId: {type: String|Number, default() { return Math.floor(1+Math.random()*10000000); }},
        leftButtons: {type: Array|Object, required: true},
        rightButtons: {type: Array|Object, required: true},
        slotbutton: {type: String, default: false}
    },
    components: {
        'divider-element': Divider,
        'button-element': Button,
        'button-group-element': ButtonGroup
    },
    methods: {}
}
</script>
