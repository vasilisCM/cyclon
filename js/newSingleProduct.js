(function() {
    'use strict';

    // Configuration
    const TRUNCATE_WORDS = 40;

    function initContentTruncation() {
        const contentElement = document.querySelector('.single-product-new__content');
        const toggleButton = document.querySelector('.single-product-new__toggle-content');
        
        if (!contentElement || !toggleButton) {
            return;
        }

        const fullContent = contentElement.innerHTML;
        const plainText = contentElement.textContent || contentElement.innerText || '';
        const words = plainText.trim().split(/\s+/).filter(word => word.length > 0);

        // If content is short enough, hide button and return
        if (words.length <= TRUNCATE_WORDS) {
            toggleButton.style.display = 'none';
            return;
        }

        // Create truncated version
        const truncatedText = words.slice(0, TRUNCATE_WORDS).join(' ') + '...';
        contentElement.innerHTML = '<p>' + truncatedText + '</p>';

        // Toggle on button click
        toggleButton.addEventListener('click', function() {
            const isExpanded = toggleButton.getAttribute('aria-expanded') === 'true';
            
            if (isExpanded) {
                contentElement.innerHTML = '<p>' + truncatedText + '</p>';
                toggleButton.textContent = 'Show more';
                toggleButton.setAttribute('aria-expanded', 'false');
            } else {
                contentElement.innerHTML = fullContent;
                toggleButton.textContent = 'Show less';
                toggleButton.setAttribute('aria-expanded', 'true');
            }
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initContentTruncation);
    } else {
        initContentTruncation();
    }

})();
