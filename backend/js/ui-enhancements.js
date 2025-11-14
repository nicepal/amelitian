/**
 * Smart School UI Enhancements - JavaScript
 * Interactive features and animations
 */

(function($) {
    'use strict';

    // Wait for DOM to load
    $(document).ready(function() {
        
        // ==========================================
        // 1. ANIMATED NUMBER COUNTERS
        // ==========================================
        function animateCounter(element) {
            const $element = $(element);
            const targetValue = parseInt($element.text().replace(/,/g, ''));
            
            if (isNaN(targetValue)) return;
            
            const duration = 1500;
            const startValue = 0;
            const startTime = Date.now();
            
            function updateCounter() {
                const currentTime = Date.now();
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Easing function for smooth animation
                const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                const currentValue = Math.floor(startValue + (targetValue - startValue) * easeOutQuart);
                
                $element.text(currentValue.toLocaleString());
                
                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    $element.text(targetValue.toLocaleString());
                }
            }
            
            requestAnimationFrame(updateCounter);
        }
        
        // Animate counters in dashboard widgets
        setTimeout(function() {
            $('.small-box .inner h3, .info-box-number').each(function() {
                animateCounter(this);
            });
        }, 200);
        
        // ==========================================
        // 2. SMOOTH SCROLL FOR ANCHOR LINKS
        // ==========================================
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            const $this = $(this);
            
            // Skip Bootstrap components (tabs, modals, dropdowns, etc.)
            if ($this.attr('data-toggle') || $this.attr('role') || $this.hasClass('dropdown-toggle')) {
                return;
            }
            
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') &&
                location.hostname === this.hostname) {
                
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                // Only smooth scroll if target element exists in DOM
                if (target.length && target.is(':visible')) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - 70
                    }, 800, 'swing');
                }
            }
        });
        
        // ==========================================
        // 3. ENHANCED FORM VALIDATION FEEDBACK
        // ==========================================
        $('input.form-control, textarea.form-control, select.form-control').on('blur', function() {
            const $this = $(this);
            
            if ($this.prop('required') && !$this.val()) {
                $this.addClass('error-shake');
                setTimeout(function() {
                    $this.removeClass('error-shake');
                }, 500);
            }
        });
        
        // Add shake animation and loading state CSS
        if (!$('#ui-enhancement-styles').length) {
            $('<style id="ui-enhancement-styles">')
                .text('@keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-5px); } 75% { transform: translateX(5px); } } .error-shake { animation: shake 0.3s ease-in-out; border-color: #dd4b39 !important; } .btn-loading-input { opacity: 0.7; cursor: not-allowed; } @keyframes spin { to { transform: rotate(360deg); } }')
                .appendTo('head');
        }
        
        // ==========================================
        // 4. BUTTON LOADING STATE
        // ==========================================
        window.setButtonLoading = function(button, isLoading) {
            const $btn = $(button);
            const isInput = $btn.is('input');
            
            if (isLoading) {
                $btn.prop('disabled', true);
                
                // Handle input elements differently from buttons
                if (isInput) {
                    $btn.data('original-value', $btn.val());
                    $btn.val('⏳ Loading...');
                    $btn.addClass('btn-loading-input');
                } else {
                    $btn.data('original-html', $btn.html());
                    const spinnerHtml = '<span class="btn-spinner" style="display:inline-block;width:16px;height:16px;border:2px solid rgba(255,255,255,0.3);border-radius:50%;border-top-color:#fff;animation:spin 0.8s linear infinite;margin-right:8px;vertical-align:middle;"></span>';
                    $btn.html(spinnerHtml + 'Loading...');
                    $btn.addClass('btn-loading');
                }
            } else {
                $btn.prop('disabled', false);
                $btn.removeClass('btn-loading btn-loading-input');
                
                // Restore original text/value
                if (isInput) {
                    if ($btn.data('original-value')) {
                        $btn.val($btn.data('original-value'));
                    }
                } else {
                    if ($btn.data('original-html')) {
                        $btn.html($btn.data('original-html'));
                    }
                }
            }
        };
        
        // Auto-add loading state to form submissions
        $('form').on('submit', function(e) {
            const $form = $(this);
            const $submitButtons = $form.find('button[type="submit"], input[type="submit"]');
            
            // Only add loading state if form validation passes
            // Check after a small delay to allow validation to run
            setTimeout(function() {
                // If default was prevented by validation, don't show loading
                if (!e.isDefaultPrevented()) {
                    // Process each submit button/input individually
                    $submitButtons.each(function() {
                        const $btn = $(this);
                        if (!$btn.hasClass('no-loading')) {
                            setButtonLoading($btn, true);
                            
                            // Re-enable button after timeout as safety measure
                            setTimeout(function() {
                                if ($btn.hasClass('btn-loading') || $btn.hasClass('btn-loading-input')) {
                                    setButtonLoading($btn, false);
                                }
                            }, 5000);
                        }
                    });
                }
            }, 10);
        });
        
        // ==========================================
        // 5. TOOLTIP ENHANCEMENTS
        // ==========================================
        if (typeof $.fn.tooltip !== 'undefined') {
            $('[data-toggle="tooltip"]').tooltip({
                container: 'body',
                animation: true,
                delay: { show: 300, hide: 100 }
            });
        }
        
        // ==========================================
        // 6. TABLE ROW CLICK ENHANCEMENT
        // ==========================================
        $('.table tbody tr').on('click', function(e) {
            if (!$(e.target).is('a, button, input, select')) {
                $(this).toggleClass('selected-row');
            }
        });
        
        // Add selected row style
        $('<style>')
            .text('.selected-row { background-color: #e8f4f8 !important; }')
            .appendTo('head');
        
        // ==========================================
        // 7. CARD REFRESH/RELOAD ANIMATION
        // ==========================================
        window.refreshCard = function(cardElement) {
            const $card = $(cardElement);
            const $cardBody = $card.find('.box-body');
            
            $cardBody.css('opacity', '0.5');
            
            setTimeout(function() {
                $cardBody.css('opacity', '1');
            }, 500);
        };
        
        // ==========================================
        // 8. NOTIFICATION FADE-OUT
        // ==========================================
        $('.alert').not('.alert-permanent').each(function() {
            const $alert = $(this);
            setTimeout(function() {
                $alert.fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);
        });
        
        // ==========================================
        // 9. LAZY LOAD IMAGES (if any)
        // ==========================================
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll('img.lazy').forEach(function(img) {
                imageObserver.observe(img);
            });
        }
        
        // ==========================================
        // 10. SIDEBAR MENU ENHANCEMENT
        // ==========================================
        $('.sidebar-menu li.treeview > a').on('click', function(e) {
            const $parent = $(this).parent();
            
            if (!$parent.hasClass('active')) {
                $parent.addClass('menu-opening');
                setTimeout(function() {
                    $parent.removeClass('menu-opening');
                }, 300);
            }
        });
        
        // Add menu opening animation
        $('<style>')
            .text('.menu-opening > .treeview-menu { animation: slideDown 0.3s ease-out; } @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }')
            .appendTo('head');
        
        // ==========================================
        // 11. PAGE TRANSITION
        // ==========================================
        $('.content-wrapper').css('opacity', '0');
        setTimeout(function() {
            $('.content-wrapper').css('transition', 'opacity 0.3s ease-in');
            $('.content-wrapper').css('opacity', '1');
        }, 50);
        
        // ==========================================
        // 12. QUICK ACTION BUTTON (FAB)
        // ==========================================
        // Create FAB if it doesn't exist
        if (!$('.fab-container').length && $('.content-wrapper').length) {
            const fabHtml = `
                <div class="fab-container">
                    <button class="fab" title="Quick Actions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-plus"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" style="bottom: 70px; right: 0; position: absolute;">
                        <li><a href="#"><i class="fa fa-user"></i> Add Student</a></li>
                        <li><a href="#"><i class="fa fa-money"></i> Collect Fee</a></li>
                        <li><a href="#"><i class="fa fa-book"></i> Add Assignment</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                    </ul>
                </div>
            `;
            
            $('body').append(fabHtml);
        }
        
        // ==========================================
        // 13. SEARCH HIGHLIGHT
        // ==========================================
        $('.dataTables_filter input').on('keyup', function() {
            const searchTerm = $(this).val();
            if (searchTerm.length > 0) {
                $(this).css('background-color', '#fff3cd');
            } else {
                $(this).css('background-color', '#ffffff');
            }
        });
        
        // ==========================================
        // 14. RESPONSIVE TABLE WRAPPER
        // ==========================================
        $('.table').each(function() {
            if (!$(this).parent().hasClass('table-responsive')) {
                $(this).wrap('<div class="table-responsive"></div>');
            }
        });
        
        // ==========================================
        // 15. PRINT PAGE ENHANCEMENT
        // ==========================================
        $('[data-toggle="print"]').on('click', function(e) {
            e.preventDefault();
            window.print();
        });
        
        // ==========================================
        // 16. COPY TO CLIPBOARD
        // ==========================================
        window.copyToClipboard = function(text) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(function() {
                    showToast('Copied to clipboard!', 'success');
                });
            } else {
                const $temp = $('<input>');
                $('body').append($temp);
                $temp.val(text).select();
                document.execCommand('copy');
                $temp.remove();
                showToast('Copied to clipboard!', 'success');
            }
        };
        
        // ==========================================
        // 17. TOAST NOTIFICATION HELPER
        // ==========================================
        window.showToast = function(message, type) {
            type = type || 'info';
            const bgColor = {
                'success': '#00a65a',
                'info': '#00c0ef',
                'warning': '#f39c12',
                'danger': '#dd4b39'
            }[type] || '#00c0ef';
            
            const toast = $('<div class="toast-notification">')
                .css({
                    'position': 'fixed',
                    'top': '20px',
                    'right': '20px',
                    'background': bgColor,
                    'color': 'white',
                    'padding': '15px 20px',
                    'border-radius': '8px',
                    'box-shadow': '0 4px 12px rgba(0,0,0,0.15)',
                    'z-index': '9999',
                    'animation': 'slideInRight 0.3s ease-out',
                    'min-width': '200px',
                    'max-width': '400px'
                })
                .html('<i class="fa fa-check-circle"></i> ' + message);
            
            $('body').append(toast);
            
            setTimeout(function() {
                toast.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        };
        
        // Add toast animation
        $('<style>')
            .text('@keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }')
            .appendTo('head');
        
        // ==========================================
        // 18. PREVENT DOUBLE SUBMISSION
        // ==========================================
        $('form').on('submit', function(e) {
            const $form = $(this);
            
            // Check if form was already submitted
            if ($form.data('submitted') === true) {
                e.preventDefault();
                return false;
            }
            
            // Mark as submitted only if validation passes
            // Use a short delay to let other submit handlers run
            setTimeout(function() {
                if (!e.isDefaultPrevented()) {
                    $form.data('submitted', true);
                    
                    // Reset after reasonable timeout
                    setTimeout(function() {
                        $form.data('submitted', false);
                    }, 5000);
                }
            }, 10);
        });
        
        // ==========================================
        // 19. DATEPICKER ENHANCEMENT (if exists)
        // ==========================================
        if (typeof $.fn.datepicker !== 'undefined') {
            $('.datepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                orientation: 'bottom auto'
            });
        }
        
        // ==========================================
        // 20. INITIALIZE ALL
        // ==========================================
        console.log('Smart School UI Enhancements Loaded ✓');
    });
    
})(jQuery);
