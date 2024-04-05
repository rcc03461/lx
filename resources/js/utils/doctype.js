
const typeIcons = {
    'image': '/assets/frappe/images/file-icons/image.svg',
    'video': '/assets/frappe/images/file-icons/video.svg',
    'audio': '/assets/frappe/images/file-icons/audio.svg',
    'document': '/assets/frappe/images/file-icons/document.svg',
    'code': '/assets/frappe/images/file-icons/code.svg',
    'archive': '/assets/frappe/images/file-icons/archive.svg',
    'font': '/assets/frappe/images/file-icons/font.svg',
    'file': '/assets/frappe/images/file-icons/file.svg'
}

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
  return url.match(/\.(doc|docx|xls|xlsx|ppt|pptx)$/i);
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

export function isPdf(url) {
  return url.match(/\.pdf$/i);
}

export function fileExtension(url) {
  return url.split('.').pop().toLowerCase();
}

export function fileThumbnail(url, prefix = '/storage/' ) {
    if (isImage(url)) {

        return url.startsWith('http') || url.startsWith('data:') || url.startsWith(prefix) ? url :  prefix + url;
    } else if (isPdf(url)) {
        return '/assets/pdf.svg';
    } else if (isArchive(url)) {
        return '/assets/archive.svg';
    } else if (isDocument(url)) {
        return '/assets/doc.svg';
    } else {
        return '/assets/file.svg';
    }
}

export function getIcon(url) {
  const type = fileType(url);
  return typeIcons[type];
}
