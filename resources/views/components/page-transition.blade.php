<script>
    (function() {
        var transitionColor = sessionStorage.getItem('gmaTransitionColor');
        var scanlinesJson = sessionStorage.getItem('gmaScanlines');
        if (transitionColor && scanlinesJson) {
            try {
                var scanlines = JSON.parse(scanlinesJson);
                var overlayHtml = '<div id="gma-transition-overlay" style="position: fixed; inset: 0; z-index: 99999; pointer-events: none; overflow: hidden; background: transparent; display: flex; flex-direction: column; justify-content: flex-start;">';
                
                for (var i = 0; i < scanlines.length; i++) {
                    var strip = scanlines[i];
                    var mt = i === 0 ? '0' : '-1px';
                    overlayHtml += '<div class="gma-scanline" style="width: 100vw; height: ' + strip.height + 'px; background: ' + transitionColor + '; transform: translateX(0); flex-shrink: 0; will-change: transform; margin-top: ' + mt + ';"></div>';
                }
                
                overlayHtml += '</div>';
                document.write(overlayHtml);
            } catch (e) {
                console.error("Scanline parse error", e);
            }
        }
    })();
</script>
