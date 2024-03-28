export function isImage(url) {
  return url.match(/\.(jpeg|jpg|gif|png|svg|webp)$/i);
}

export function isVideo(url) {
  return url.match(/\.(mp4|webm|ogv)$/i);
}

export function isAudio(url) {
  return url.match(/\.(mp3|wav|ogg)$/i);
}

export function isDocument(url) {
  return url.match(/\.(pdf|doc|docx|xls|xlsx|ppt|pptx)$/i);
}

export function isCode(url) {
  return url.match(/\.(html|css|js|json|xml|php|py|rb|java|c|cpp|h|hpp|go|swift|scala|coffee|ts|tsx)$/i);
}

export function isArchive(url) {
  return url.match(/\.(zip|tar|gz|bz2|7z)$/i);
}

export function isFont(url) {
  return url.match(/\.(ttf|otf|eot|woff|woff2)$/i);
}

export function iconUrl(url) {
    const ext = url.split('.').pop().toLowerCase();

}
