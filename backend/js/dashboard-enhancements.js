/**
 * Dashboard Enhancements JavaScript
 * Interactive animations and dynamic effects for Super Admin Dashboard
 * Compatible with existing Chart.js and AdminLTE
 * Version: 1.0
 */

(function($) {
    'use strict';

    // ==========================================
    // 1. ANIMATED COUNTER
    // ==========================================
    function animateCounter($element, start, end, duration) {
        if (!$element.length) return;
        
        const startTime = performance.now();
        const difference = end - start;
        
        function updateCounter(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            // Easing function: easeOutExpo
            const easeProgress = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
            
            const current = Math.floor(start + (difference * easeProgress));
            $element.text(current);
            
            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                $element.text(end);
            }
        }
        
        requestAnimationFrame(updateCounter);
    }

    // ==========================================
    // 2. CIRCULAR PROGRESS ANIMATION
    // ==========================================
    function animateCircularProgress($svg, percentage, duration) {
        if (!$svg.length) return;
        
        const circle = $svg.find('.progress-circle-fill')[0];
        if (!circle) return;
        
        const radius = 40; // SVG circle radius
        const circumference = 2 * Math.PI * radius;
        const offset = circumference - (percentage / 100) * circumference;
        
        // Animate using CSS custom property
        circle.style.strokeDashoffset = offset;
    }

    // ==========================================
    // 3. COMPARISON BAR ANIMATION
    // ==========================================
    function animateComparisonBar($bar, percentage) {
        if (!$bar.length) return;
        
        setTimeout(function() {
            $bar.css('width', percentage + '%');
        }, 100);
    }

    // ==========================================
    // 4. INITIALIZE KEY METRICS CARDS
    // ==========================================
    function initializeKeyMetrics() {
        // Student Attendance Card
        const $studentCard = $('.key-metric-card.student-attendance');
        if ($studentCard.length) {
            const studentPresent = parseInt($studentCard.data('present') || 0);
            const studentTotal = parseInt($studentCard.data('total') || 1);
            const studentPercentage = Math.round((studentPresent / studentTotal) * 100);
            
            animateCounter($studentCard.find('.metric-count'), 0, studentPresent, 2000);
            animateCircularProgress($studentCard.find('.metric-circular-progress'), studentPercentage, 2000);
            $studentCard.find('.circular-progress-text').text(studentPercentage + '%');
        }
        
        // Staff Attendance Card
        const $staffCard = $('.key-metric-card.staff-attendance');
        if ($staffCard.length) {
            const staffPresent = parseInt($staffCard.data('present') || 0);
            const staffTotal = parseInt($staffCard.data('total') || 1);
            const staffPercentage = Math.round((staffPresent / staffTotal) * 100);
            
            animateCounter($staffCard.find('.metric-count'), 0, staffPresent, 2000);
            animateCircularProgress($staffCard.find('.metric-circular-progress'), staffPercentage, 2000);
            $staffCard.find('.circular-progress-text').text(staffPercentage + '%');
        }
        
        // Fee Collection Card
        const $feeCard = $('.key-metric-card.fee-collection');
        if ($feeCard.length) {
            const collected = parseFloat($feeCard.data('collected') || 0);
            const pending = parseFloat($feeCard.data('pending') || 0);
            const total = collected + pending;
            const collectedPercent = total > 0 ? Math.round((collected / total) * 100) : 0;
            const pendingPercent = total > 0 ? Math.round((pending / total) * 100) : 0;
            
            // Animate collected amount
            const $collectedValue = $feeCard.find('.comparison-value.collected-amount');
            if ($collectedValue.length) {
                animateCounter($collectedValue.find('.amount-number'), 0, Math.round(collected), 2000);
            }
            
            // Animate pending amount
            const $pendingValue = $feeCard.find('.comparison-value.pending-amount');
            if ($pendingValue.length) {
                animateCounter($pendingValue.find('.amount-number'), 0, Math.round(pending), 2000);
            }
            
            // Animate bars
            animateComparisonBar($feeCard.find('.comparison-bar-fill.collected'), collectedPercent);
            animateComparisonBar($feeCard.find('.comparison-bar-fill.pending'), pendingPercent);
        }
    }

    // ==========================================
    // 5. ENHANCED PROGRESS BARS
    // ==========================================
    function enhanceProgressBars() {
        $('.progress-minibar .progress-bar').each(function() {
            const $bar = $(this);
            const width = $bar.attr('style') ? $bar.attr('style').match(/width:\s*(\d+)/) : null;
            
            if (width && width[1]) {
                const targetWidth = width[1] + '%';
                $bar.css('width', '0%');
                
                setTimeout(function() {
                    $bar.css('width', targetWidth);
                }, 200);
            }
        });
    }

    // ==========================================
    // 6. CHART LOADING ENHANCEMENT
    // ==========================================
    function enhanceChartLoading() {
        // Wait for charts to render, then add loaded class
        setTimeout(function() {
            $('#barChart, #lineChart, #doughnut-chart, #doughnut-chart1').each(function() {
                const $canvas = $(this);
                const $container = $canvas.closest('.box');
                
                if ($container.length) {
                    $container.addClass('chart-loaded');
                }
            });
        }, 500);
    }

    // ==========================================
    // 7. INTERSECTION OBSERVER FOR SCROLL ANIMATIONS
    // ==========================================
    function initScrollAnimations() {
        // Check if IntersectionObserver is supported
        if (!('IntersectionObserver' in window)) {
            return;
        }
        
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        // Observe dashboard elements
        document.querySelectorAll('.box, .topprograssstart').forEach(function(el) {
            observer.observe(el);
        });
    }

    // ==========================================
    // 8. CARD HOVER EFFECTS
    // ==========================================
    function initCardHoverEffects() {
        $('.key-metric-card').on('mouseenter', function() {
            $(this).addClass('card-hover');
        }).on('mouseleave', function() {
            $(this).removeClass('card-hover');
        });
    }

    // ==========================================
    // 9. SMOOTH SCROLL TO TOP BUTTON
    // ==========================================
    function initScrollToTop() {
        // Check if button already exists
        if ($('#scroll-to-top').length) {
            return;
        }
        
        // Create scroll to top button
        const $scrollBtn = $('<button>')
            .attr('id', 'scroll-to-top')
            .addClass('btn btn-primary')
            .css({
                'position': 'fixed',
                'bottom': '30px',
                'right': '30px',
                'width': '50px',
                'height': '50px',
                'border-radius': '50%',
                'display': 'none',
                'z-index': '9999',
                'box-shadow': '0 4px 12px rgba(0,0,0,0.15)',
                'transition': 'all 0.3s ease'
            })
            .html('<i class="fa fa-arrow-up"></i>')
            .appendTo('body');
        
        // Show/hide button on scroll
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                $scrollBtn.fadeIn();
            } else {
                $scrollBtn.fadeOut();
            }
        });
        
        // Smooth scroll to top
        $scrollBtn.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, 600);
        });
    }

    // ==========================================
    // 10. DASHBOARD OVERVIEW COUNTER ANIMATION
    // ==========================================
    function animateDashboardNumbers() {
        // Animate all numeric values in overview cards
        $('.topprograssstart').each(function() {
            const $card = $(this);
            
            // Find numbers in the card and animate them
            $card.find('p.text-uppercase').each(function() {
                const $text = $(this);
                const text = $text.html();
                const numberMatch = text.match(/^(\d+)/);
                
                if (numberMatch) {
                    const number = parseInt(numberMatch[1]);
                    const $numberSpan = $('<span class="animated-number">' + number + '</span>');
                    $text.html(text.replace(numberMatch[1], '<span class="animated-number">0</span>'));
                    
                    setTimeout(function() {
                        animateCounter($text.find('.animated-number'), 0, number, 1500);
                    }, 300);
                }
            });
        });
    }

    // ==========================================
    // 11. RESPONSIVE CHART RESIZE
    // ==========================================
    function handleChartResize() {
        let resizeTimer;
        $(window).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                // Trigger chart resize if Chart.js is available
                if (typeof Chart !== 'undefined') {
                    Chart.helpers.each(Chart.instances, function(instance) {
                        instance.resize();
                    });
                }
            }, 250);
        });
    }

    // ==========================================
    // 12. LOADING STATE MANAGEMENT
    // ==========================================
    function hideLoadingSkeletons() {
        $('.chart-loading-skeleton').fadeOut(300, function() {
            $(this).remove();
        });
    }

    // ==========================================
    // 13. TOOLTIP ENHANCEMENT
    // ==========================================
    function enhanceTooltips() {
        // Add tooltips to metric cards if not already present
        $('.key-metric-card').each(function() {
            const $card = $(this);
            if (!$card.attr('title') && !$card.attr('data-original-title')) {
                let title = 'Click for details';
                if ($card.hasClass('student-attendance')) {
                    title = 'View student attendance report';
                } else if ($card.hasClass('staff-attendance')) {
                    title = 'View staff attendance report';
                } else if ($card.hasClass('fee-collection')) {
                    title = 'View fee collection details';
                }
                
                $card.attr('data-toggle', 'tooltip')
                     .attr('data-placement', 'top')
                     .attr('title', title);
            }
        });
        
        // Initialize Bootstrap tooltips if available
        if ($.fn.tooltip) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    }

    // ==========================================
    // 14. INITIALIZE ALL FEATURES
    // ==========================================
    function initializeDashboard() {
        // Initialize key metrics with delay for smooth loading
        setTimeout(function() {
            initializeKeyMetrics();
        }, 300);
        
        // Enhance progress bars
        setTimeout(function() {
            enhanceProgressBars();
        }, 500);
        
        // Animate dashboard numbers
        setTimeout(function() {
            animateDashboardNumbers();
        }, 700);
        
        // Other initializations
        enhanceChartLoading();
        initScrollAnimations();
        initCardHoverEffects();
        initScrollToTop();
        handleChartResize();
        enhanceTooltips();
        
        // Hide loading skeletons after everything is loaded
        setTimeout(function() {
            hideLoadingSkeletons();
        }, 1000);
        
        console.log('Dashboard enhancements initialized successfully');
    }

    // ==========================================
    // 15. DOCUMENT READY
    // ==========================================
    $(document).ready(function() {
        // Check if we're on the dashboard page
        if ($('.content-wrapper').find('.dashboard-key-metrics').length || 
            window.location.href.indexOf('admin/dashboard') > -1) {
            initializeDashboard();
        }
    });

    // ==========================================
    // 16. EXPORT FUNCTIONS FOR MANUAL USE
    // ==========================================
    window.DashboardEnhancements = {
        animateCounter: animateCounter,
        animateCircularProgress: animateCircularProgress,
        refresh: initializeDashboard
    };

})(jQuery);
