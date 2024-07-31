$(document).off('click.popup').on('click.popup', '[data-popup]', function(event){
    event.preventDefault();
    window.open($(this).attr('href'), '_blank', 'width=1200,height=980');
})

$(document).off('click.popover').on('click.popover',  '.ie-content-settlement_date input, .ie-content-end_date input, .ie-content-settled_at input, .ie-content-wip_at input', function(event){
    event.preventDefault();
    $( this )
    .datepicker({
        dateFormat: "yy-mm-dd",
    })
    .datepicker('show');
    console.log('datepicker')
})

// const all_labels = @json(\App\Models\Label::all()->pluck('name', 'ref_id'));
let all_labels = []

$.ajax({
    url: '/admin/api/labels',
    type: 'GET',
    success: function(data){
        all_labels = data
        // all_labels_options = data
        // console.log(data);
        // Dcat.loading.done();
    }
})

$(document).off('click.label-select').on('click.label-select', '.email-subject', function(event){
    event.preventDefault();
    const message_id = $(this).closest('tr').attr('data-message-id');
    readEmail(message_id);
})

$.contextMenu({
    // define which elements trigger this menu
    className: 'contextmenu-max-height',
    selector: "tr[data-message-id]",
    build: function(trigger, e) {
        e.preventDefault();
        // Dcat.loading.start();
        // $.ajax({
        //     url: '/admin/api/emails/' + trigger.attr('data-message-id'),
        //     type: 'GET',
        //     success: function(data){
        //         console.log(data);
        //         // Dcat.loading.done();
        //     }
        // })
        // trigger.data('runCallbackThingie')()
        // pull a callback from the trigger
        const id = trigger.attr('data-message-id');
        const ref = trigger.attr('data-ref') || "";
        const guessCode = trigger.attr('data-guess');
        const labels = JSON.parse(trigger.attr('data-message-labels'));
        // console.log(id, JSON.parse(labels));


        const labels_items = all_labels
        .sort(function(a, b){
            return a.name.localeCompare(b.name);
        })
        .filter((f)=>{
            return f.type === 'user'
        })
        .map((label) => {
            return {
                name: label.name,
                ref_id: label.ref_id,
                type: 'checkbox',
                selected: labels.includes(label.ref_id)
            }
        }).reduce((a, v) => ({...a, [v.ref_id]: v}), {})

        // console.log(labels_items);

        return {
            items:{
                task: {
                    name: "Ref: " + ref,
                    // items: labels_items
                    callback: function(itemKey, opt){
                        const mew_ref = window.prompt("Enter task number:", ref || guessCode);
                        if( mew_ref ){
                            updateEmail(id, {
                                ref: mew_ref
                            })
                        }
                    }
                },
                // items : {
                //     name: "textfield",
                //     type: "text",
                //     value: "welcome!"
                // },
                // reply_all: {
                //     name: "Reply All",
                //     callback: function( itemKey, opt, e ){
                //         triggerRowAction(opt.$trigger, 'Reply All');
                //     }
                // },
                // reply: {
                //     name: "Reply",
                //     callback: function( itemKey, opt, e ){
                //         triggerRowAction(opt.$trigger, 'Reply');
                //     }
                // },
                // forwards: {
                //     name: "Forward",
                //     callback: function( itemKey, opt, e ){
                //         triggerRowAction(opt.$trigger, 'Forward');
                //     }
                // },
                labels: {
                    name: "Labels",
                    items: labels_items
                },
            },
            // items:labels_items,
        };
    },
    events: {
        // show: function(opt) {
        //     $.contextMenu.setInputValues(opt, this.data());
        //     console.log(opt, this.data());
        // },
        hide: function(opt) {
            $.contextMenu.getInputValues(opt, this.data());
            // console.log( opt, 'hide', this.data() );

            let {messageId, messageLabels, contextMenu, ...selected} = this.data();
            // console.log(messageId, messageLabels, 'selected', selected);

            const label_ids = []
            Object.entries(selected).map(function([key, value]){
                if( value == true ){
                    // console.log(key, value);
                    label_ids.push(key)
                }
            })
            const excepts = ['CATEGORY_PERSONAL', 'IMPORTANT', 'INBOX', 'UNREAD']
            messageLabels = messageLabels.filter(function(label){
                return !excepts.includes(label)
            })

            // console.log(messageLabels, "messageLabels");


            // console.log(label_ids, messageLabels, arraysAreEqual(label_ids, messageLabels));
            const equal = arraysAreEqual(label_ids, messageLabels)
            // console.log(equal);
            if (!equal) {
                updateLabels( messageId, label_ids );
            }

        }
    }
    // there's more, have a look at the demos and docs...
});


function triggerRowAction(element, action) {
    $(element).closest('tr').find('.grid__actions__ a').each(function(i, v){
        if($(v).text().trim() === action){
            $(v).click();
            return false;
        }
    })
}

function arraysAreEqual(array1, array2) {
    const arr1 = array1.sort();
    const arr2 = array2.sort();
    console.log(array1, array2, "eq");

    if (arr1.length !== arr2.length) {
        return false;
    }

    return arr1.every((value, index) => value === arr2[index]);
}

function updateLabels( id, labels = [] ){
    console.log('updateLabels', id, labels);
    $.ajax({
        url: `/admin/api/emails/` + id + `/labels`,
        type: 'PUT',
        data: {
            labels : labels
        },
        success: function(data){
            if( data?.status  ){
                Dcat.reload()
            }

            if( data?.message ){
                Dcat.success(data.message)
            }
            // console.log(data);
            // Dcat.reload()
            // Dcat.loading.done();
        }
    })
}

function updateEmail( id, playload ){
    // console.log('updateLabels', id, labels);
    $.ajax({
        url: `/admin/api/emails/` + id,
        type: 'PUT',
        data: playload,
        success: function(data){
            // console.log(data);
            Dcat.reload()
            // Dcat.loading.done();
        }
    })
}
// $(document).off('contextmenu.message').on('contextmenu.message',  'tr[data-message-id]', function(event){
//     event.preventDefault();
//     const message_id = $(this).attr('data-message-id');
//     console.log('message', message_id)

// })
