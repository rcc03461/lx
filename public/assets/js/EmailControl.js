const { createApp, ref } = Vue

class EmailControl {
    constructor( ref_id ){
        // console.log($('#email-container').length);

        let container = null;
        if ($('#email-container').length) {
            container = document.querySelector('#email-container')
        }else{
            const div = document.createElement('div')
            div.id= 'email-container'
            document.body.appendChild(div)
            container = div
        }
        this.ref_id = ref_id
        this.doms = {
            container
        }
        this.app = createApp(MessageToolBar).mount(this.doms.container)
    }


    view( ref_id ){

    }
    reply( ref_id ){
        console.log(ref_id);
    }
    fetchGmailById( ref_id ){

    }
    fetchEmailById( ref_id ){

    }
    renderEmailForm(){

    }
}



const MessageBoxHeader = {
    props: {
        title: String
    },
    setup() {
        // const title = "123"
        // // const count = ref(0)
        // return { title }
    },
    template: `<div class="flex">
        <div class="">{{title}}</div>
        <div>
            <button>X</button>
        </div>
    </div>`
}
const MessageBox = {
    components:{
        MessageBoxHeader,
        // MessageBoxForm,
        // MessageBoxActions
    },
    setup() {
        // const workingMessage = ref([])
        // return { count }
    },
    template: `<div class="grid grid-flow-col max-w-sm">
        <MessageBoxHeader :title="count"/>

    </div>`
}

const MessageToolBar = {
    components:{
        MessageBox
    },
    setup() {
        const workingMessages = ref([])
        return { workingMessages }
    },
    template: `<div class="flex flex-end">
        <MessageBox v-for="message in workingMessages" :message="message"/>
    </div>`
}
