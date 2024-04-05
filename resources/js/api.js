import { inlineHtml } from '@/utils/message';

export async function fetchMessage( message_id ) {
    const response = await fetch( `/admin/api/emails/${message_id}` );
    const data = await response.json();
    data.html_body = inlineHtml( data )
    return data;
}

export async function fetchUpload( files ) {
    const data = new FormData();
    for ( let i = 0; i < files.length; i++ ) {
        data.append( `files${i}`, files[i] );
    }
    const response = await fetch( '/api/upload', {
        method: 'POST',
        body: data
    });
    return await response.json();
}

export async function fetchSend( {
    to,
    cc,
    bcc,
    subject,
    message,
    attachments,
} ) {
    const response = await fetch( '/api/mail/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            to,
            cc,
            bcc,
            subject,
            message,
            attachments,
        })
    });

    return await response.json();
}
