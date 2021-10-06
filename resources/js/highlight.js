//
// highlight.js
// Dashkit module
//

import hljs from 'highlight.js/lib/core';
import javascript from 'highlight.js/lib/languages/javascript';
import xml from 'highlight.js/lib/languages/xml';
import sql from 'highlight.js/lib/languages/sql';

const highlights = document.querySelectorAll('.highlight');

// Only register the languages we need to reduce the download footprint
hljs.registerLanguage('xml', xml);
hljs.registerLanguage('javascript', javascript);
hljs.registerLanguage('javascsqlript', sql);

highlights.forEach((highlight) => {
  hljs.highlightBlock(highlight);
});

// Make available globally
window.hljs = hljs;
