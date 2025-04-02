<?php

use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Show;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */


// Admin::js('https://code.jquery.com/ui/1.13.0/jquery-ui.min.js');
Admin::js('//cdnjs.cloudflare.com/ajax/libs/dayjs/1.9.8/dayjs.min.js');
// Admin::js('/vendor/dcat-admin/dcat/plugins/moment/moment-with-locales.min.js?v2.2.2-beta');
// Admin::js('/vendor/dcat-admin/dcat/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js?v2.2.2-beta');

Admin::js('//cdnjs.cloudflare.com/ajax/libs/axios/1.0.0-alpha.1/axios.min.js');
Admin::js('//cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js');
// Admin::js('//cdn.jsdelivr.net/npm/vue@2/dist/vue.js');
// Admin::js('//cdn.jsdelivr.net/npm/vue@2.7.13');
Admin::js('//unpkg.com/vue@3/dist/vue.global.js');
// Admin::js('/assets/js/vue.component.js');
Admin::js('//code.jquery.com/ui/1.10.4/jquery-ui.js');
Admin::js('//cdn.tailwindcss.com');
// <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
// Admin::js('//cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js');
// Admin::js('//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.20.0/vuedraggable.umd.min.js');
// // Admin::js('//cdnjs.cloudflare.com/ajax/libs/vue/2.5.2/vue.min.js');
// Admin::js('//unpkg.com/vue-multiselect@2.1.4');

// Admin::css('//cdn.jsdelivr.net/npm/tailwindcss@3.1.8/base.css');
Admin::css('//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css');
// Admin::css('//cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css');





Admin::js('//cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.9.2/jquery.ui.position.js');
Admin::js('//cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.9.2/jquery.contextMenu.min.js');
Admin::css('//cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.9.2/jquery.contextMenu.css');
Admin::css('/assets/css/email_control.css');

Admin::js('//cdnjs.cloudflare.com/ajax/libs/vue/3.5.13/vue.global.min.js');
// Admin::js('//unpkg.com/vue@3/dist/vue.global.js');
// Admin::js('/assets/js/EmailControl.js');
Admin::js('/assets/js/main.js');
Admin::css('/build/assets/app.css');
// Admin::css('//unpkg.com/element-plus/dist/index.css');
Admin::js('/build/assets/app.js');
// Admin::css('//unpkg.com/vue-multiselect@2.1.4/dist/vue-multiselect.min.css');

Admin::style(<<<CSS

    .collapse{
        visibility: inherit;
    }

    table#grid-table.custom-data-table.data-table.table-slim tr[data-message-id] td{
        line-height: 1 ;
        height: auto ;
    }
    .row-labels{
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        padding: 0.125rem 0.375rem;
        box-sizing: border-box;
    }

    [type=button].btn.btn-primary:not(.btn-outline),[type=submit].btn.btn-primary:not(.btn-outline) {
        background-color: #586cb1;
        border-color: #586cb1;
    }

    .contextmenu-max-height .context-menu-list{
        max-height: 300px;
        overflow-y: auto;

    }

    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }


CSS);

Admin::script(<<<JS

    tailwind.config = {
        corePlugins: {
            preflight: false,
        }
    }

JS);
