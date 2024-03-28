
export function inlineHtml ( message ) {

    const { html_body, attachments } = message;

    let html = html_body;

    const cids = getCid( html );

    // console.log(cids);
    // replace all "cid:XXX" with the actual content of the attachment

    attachments.forEach( attachment => {

        const { attachment:{ headerDetails }, path } = attachment;


        // console.log(attachment);
        if (headerDetails.hasOwnProperty( 'Content-ID' )) {

            const content_id_string = headerDetails['Content-ID']; // <709ccbab-20e5-4c37-8473-690a1e8ec282>

            // => cid:709ccbab-20e5-4c37-8473-690a1e8ec282

            const content_id = content_id_string.replace( /[<>]/g, '' ); // 709ccbab-20e5-4c37-8473-690a1e8ec282

            const cid = `cid:${content_id}`;

            if ( cids.includes( content_id ) ) {
                // console.log(`replacing ${cid} with ${path}`);
                html = html.replaceAll( cid, '/storage/' + path );
                // console.log(html);
            }

        }

    } );

    return html;
}

function getCid ( html ) {
    const regex = /cid:(.*?)"/g;
    const cids = [];
    let match;
    while ( ( match = regex.exec( html ) ) ) {
        cids.push( match[1] );
    }
    return cids;
}
