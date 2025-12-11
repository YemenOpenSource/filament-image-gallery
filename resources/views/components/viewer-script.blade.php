@once
    <!-- Viewer.js CDN assets -->
    <link rel="stylesheet" href="https://unpkg.com/viewerjs@1.11.6/dist/viewer.min.css" />
    <script src="https://unpkg.com/viewerjs@1.11.6/dist/viewer.min.js"></script>
    <script>
        (function() {
            function initOne(el) {
                if (!el || el._viewer || !window.Viewer) return;
                el._viewer = new Viewer(el, {
                    toolbar: {
                        zoomIn: 1,
                        zoomOut: 1,
                        oneToOne: 1,
                        reset: 1,
                        prev: 1,
                        play: 0,
                        next: 1,
                        rotateLeft: 1,
                        rotateRight: 1,
                        flipHorizontal: 1,
                        flipVertical: 1,
                    },
                    navbar: false,
                    inline: false,
                    movable: true,
                    rotatable: true,
                    scalable: true,
                    fullscreen: true,
                    transition: true,
                    title: false,
                });
            }
            
            function destroyOne(el) {
                if (el && el._viewer) {
                    try {
                        el._viewer.destroy();
                    } catch(e) {}
                    el._viewer = null;
                }
            }

            function scan() {
                document.querySelectorAll('[data-viewer-gallery]').forEach(function(el) {
                    // Destroy and reinitialize to handle SPA navigation
                    destroyOne(el);
                    initOne(el);
                });
            }

            // Run on various lifecycle events
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', scan);
            } else {
                // DOM is already ready
                scan();
            }

            // Filament/Livewire 3.x SPA navigation
            document.addEventListener('livewire:navigated', function() {
                setTimeout(scan, 100);
            });
            
            // Livewire 3.x morph updates
            document.addEventListener('livewire:init', function() {
                if (window.Livewire) {
                    Livewire.hook('morph.updated', function({ el }) {
                        setTimeout(scan, 100);
                    });
                }
            });
            
            // For Livewire 2.x compatibility
            document.addEventListener('livewire:load', scan);
            if (window.Livewire && window.Livewire.hook) {
                try {
                    window.Livewire.hook('message.processed', function() {
                        setTimeout(scan, 100);
                    });
                } catch (e) {}
            }

            // Turbolinks/Turbo compatibility
            document.addEventListener('turbo:load', scan);
            document.addEventListener('turbolinks:load', scan);
            
            // Alpine.js x-init hook
            document.addEventListener('alpine:init', function() {
                Alpine.directive('image-gallery-init', function(el) {
                    initOne(el);
                });
            });

            // MutationObserver for dynamic content
            const observer = new MutationObserver(function(mutations) {
                let shouldScan = false;
                mutations.forEach(function(mutation) {
                    if (mutation.addedNodes.length) {
                        mutation.addedNodes.forEach(function(node) {
                            if (node.nodeType === 1) {
                                if (node.hasAttribute && node.hasAttribute('data-viewer-gallery')) {
                                    shouldScan = true;
                                }
                                if (node.querySelectorAll) {
                                    const galleries = node.querySelectorAll('[data-viewer-gallery]');
                                    if (galleries.length) {
                                        shouldScan = true;
                                    }
                                }
                            }
                        });
                    }
                });
                if (shouldScan) {
                    setTimeout(scan, 100);
                }
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        })();
    </script>
@endonce
