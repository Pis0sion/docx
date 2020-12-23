const FileType = require('file-type');
const got = require('got');
url = "https://dss1.bdstatic.com/5eN1bjq8AAUYm2zgoY3K/r/www/cache/static/protocol/https/global/js/all_async_search_5abba37.js";
(async () => {
    const stream = got.stream(url);
    console.log(await FileType.fromStream(stream));

    //=> {ext: 'png', mime: 'image/png'}
})();