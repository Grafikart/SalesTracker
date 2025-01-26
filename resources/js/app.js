import '../css/app.css';
import htmx from 'htmx.org';

htmx.config.allowNestedOobSwaps = false;

function maybeRemoveMe(elt) {
    const timing = elt.getAttribute('remove-me') || elt.getAttribute('data-remove-me')
    if (timing) {
        setTimeout(function() {
            elt.setAttribute('data-leaving', 'leaving')
            setTimeout(() => {
                elt.parentElement.removeChild(elt)
            }, 1000)
        }, htmx.parseInterval(timing))
    }
}

htmx.defineExtension('remove-me', {
    onEvent: function(name, evt) {
        if (name === 'htmx:afterProcessNode') {
            const elt = evt.detail.elt
            if (elt.getAttribute) {
                maybeRemoveMe(elt)
                if (elt.querySelectorAll) {
                    const children = elt.querySelectorAll('[remove-me], [data-remove-me]')
                    for (let i = 0; i < children.length; i++) {
                        maybeRemoveMe(children[i])
                    }
                }
            }
        }
    }
})

let api;
htmx.defineExtension('multi-swap', {
    init: function (apiRef) {
        api = apiRef;
    },
    isInlineSwap: function (swapStyle) {
        return swapStyle.indexOf('multi:') === 0;
    },
    handleSwap: function (swapStyle, target, fragment, settleInfo) {
        if (swapStyle.indexOf('multi:') === 0) {
            const selectorToSwapStyle = {};
            const elements = swapStyle.replace(/^multi\s*:\s*/, '').split(/\s*,\s*/);

            elements.map(function (element) {
                const split = element.split(/\s*:\s*/);
                const elementSelector = split[0];
                const elementSwapStyle = typeof (split[1]) !== "undefined" ? split[1] : "innerHTML";

                if (elementSelector.charAt(0) !== '#') {
                    console.error("HTMX multi-swap: unsupported selector '" + elementSelector + "'. Only ID selectors starting with '#' are supported.");
                    return;
                }

                selectorToSwapStyle[elementSelector] = elementSwapStyle;
            });

            for (const selector in selectorToSwapStyle) {
                const swapStyle = selectorToSwapStyle[selector];
                const elementToSwap = fragment.querySelector(selector);
                if (elementToSwap) {
                    api.oobSwap(swapStyle, elementToSwap, settleInfo);
                } else {
                    console.warn("HTMX multi-swap: selector '" + selector + "' not found in source content.");
                }
            }

            return true;
        }
    }
});

document.body.addEventListener('htmx:beforeOnLoad', function (evt) {
    console.log(evt.detail)
    if (evt.detail.xhr.status === 403) {
        evt.detail.el = null;
        evt.detail.target = document.createElement('div');
        evt.detail.shouldSwap = true;
        evt.detail.successful = false;
        evt.detail.isError = true;
    }
});
