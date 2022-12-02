// import Vue from 'vue'
// import _ from 'lodash'

Vue.directive('click-outside', {
    bind: function (el, binding, vnode) {
        el.clickOutsideEvent = function (event) {
        // here I check that click was outside the el and his children
        if (!(el == event.target || el.contains(event.target))) {
            // and if it did, call method provided in attribute value
            vnode.context[binding.expression](event);
        }
        };
        document.body.addEventListener('click', el.clickOutsideEvent)
    },
    unbind: function (el) {
        document.body.removeEventListener('click', el.clickOutsideEvent)
    },
});

Vue.component('selec-with-ajax-search', {
    props: [
        'value',
    ],
    data() {
        return {
            showSearch: false,
            options: [],
            selected: {},
        }
    },
    watch:{
        value(val) {
            const {value} = this;
            if (value) {
                this.ajaxGet(value);
            }
        }
    },
    mounted(){
        if(this.value){
            this.ajaxGet(this.value);
        }
    },
    methods: {
        clickOutside: function (e) {
            this.showSearch = false;
        },
        async ajaxGet( id ) {
            let {data} = await axios.get('/admin/api/tasks/' + id);
            this.selected = data;
        },
        ajaxSearch: _.debounce(async function (e) {
            this.showSearch = true;
            if (e.target.value) {
                let res = await axios.get('/admin/api/tasks?q=' + e.target.value);
                this.options = res.data;
            }
        }, 300),
        select(e) {
            // console.log(e);
            this.$emit('input', e.id);
            this.selected = e;
            this.showSearch = false;
        },
        focusInput(e) {
            this.showSearch = true;
            // console.log(this.$refs);
            setTimeout(() => {
                this.$refs.searchinput.focus();
            }, 100);
        },
        clearResult() {
            this.selected = {};
            this.$emit('input', null);
        }
    },
    template: `<div class="relative w-full" v-click-outside="clickOutside">
        <div class="flex items-center">
            <input ref="searchinput" v-show="showSearch" class="form-control w-full outline-none px-1 focus:border-b bg-gray-100 " type="text" @keyup="ajaxSearch" @focus="showSearch = true"/>
            <div v-show="!showSearch" class="flex-1 form-control cursor-pointer hover:bg-gray-50" @click="focusInput">
                <slot name="selected" :selected="selected">
                    @{{selected.title}}
                </slot>
            </div>
            <div @click="clearResult" class="w-12 text-center hover:bg-gray-50 cursor-pointer">Clear</div>
        </div>
        <div v-show="showSearch" class="absolute border shadow-lg left-0 bg-white w-full max-h-72 overflow-y-auto px-1 py-1 z-10" style="top:110%">
            <div v-if="options.length == 0" class="text-center">Type to search...</div>
            <ul v-else>
                <li class="hover:bg-gray-100 cursor-pointer py-0.5 px-0.5" v-for="item in options" @click="select(item)">
                    <slot name="item" :item="item">
                        @{{item.title}}
                    </slot>
                </li>
            </ul>
        </div>
    </div>`
})

Vue.component('lx-input', {
    props: [
        'value',
        'type',
        'datalist'
    ],
    data() {
        return {
            editing: false,
            // date: dayjs().format('YYYY-MM-DD'),
        }
    },
    mounted(){

    },
    methods: {
        clickOutside: function (e) {
            this.editing = false;
        },

        select(e) {
            console.log(e);
            this.$emit('input', e.target.value);
            this.editing = false;
        },
        focusInput(e) {
            this.editing = true;
            // console.log(this.$refs);
            setTimeout(() => {
                this.$refs.refinput.focus();
            }, 100);
        }
    },
    template: `<div class="relative w-full" v-click-outside="clickOutside">
        <input ref="refinput" v-show="editing" class="form-control w-full outline-none px-1 focus:border-b bg-gray-100" :type="type" @input="select" @focus="editing = true"/>
        <div v-show="!editing" class="form-control cursor-pointer hover:bg-gray-50" @click="focusInput">
            {{value || ' - '}}
        </div>

    </div>`
})
