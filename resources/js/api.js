import { inlineHtml } from '@/utils/message';

export async function fetchMessage( message_id ) {
    const response = await fetch( `/admin/api/emails/${message_id}` );
    const data = await response.json();
    data.html_body = inlineHtml( data )
    return data;
}

