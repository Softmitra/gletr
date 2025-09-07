/**
 * Admin Sidebar Enhancement Script
 * Enhances search functionality and menu interactions
 */

$(document).ready(function() {
    
    // Enhanced Sidebar Search Functionality
    function initializeSidebarSearch() {
        const searchInput = $('.sidebar-search-form .form-control-sidebar');
        const searchResults = $('.sidebar-search-results');
        const menuItems = $('.nav-sidebar .nav-link');
        
        // Create search results container if it doesn't exist
        if (searchResults.length === 0) {
            $('.sidebar-search-form').append('<div class="sidebar-search-results list-group"></div>');
        }
        
        // Search functionality
        searchInput.on('input', function() {
            const query = $(this).val().toLowerCase().trim();
            const resultsContainer = $('.sidebar-search-results');
            
            if (query.length === 0) {
                resultsContainer.removeClass('show').empty();
                return;
            }
            
            if (query.length < 2) {
                return;
            }
            
            // Search through menu items
            const results = [];
            menuItems.each(function() {
                const $item = $(this);
                const text = $item.find('p, span').text().toLowerCase();
                const url = $item.attr('href');
                
                if (text.includes(query) && url && url !== '#') {
                    results.push({
                        text: $item.find('p, span').text(),
                        url: url,
                        icon: $item.find('i').attr('class') || 'fas fa-link'
                    });
                }
            });
            
            // Display results
            if (results.length > 0) {
                let html = '';
                results.slice(0, 8).forEach(function(item) {
                    html += `
                        <a href="${item.url}" class="list-group-item list-group-item-action">
                            <i class="${item.icon} mr-2"></i>
                            ${item.text}
                        </a>
                    `;
                });
                resultsContainer.html(html).addClass('show');
            } else {
                resultsContainer.html('<div class="list-group-item">No results found</div>').addClass('show');
            }
        });
        
        // Hide results when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.sidebar-search-form').length) {
                $('.sidebar-search-results').removeClass('show');
            }
        });
        
        // Clear search on escape
        searchInput.on('keydown', function(e) {
            if (e.key === 'Escape') {
                $(this).val('');
                $('.sidebar-search-results').removeClass('show').empty();
            }
        });
    }
    
    // Menu Animation Enhancement
    function enhanceMenuAnimations() {
        // Stagger menu item animations
        $('.nav-sidebar .nav-item').each(function(index) {
            $(this).css('animation-delay', (index * 0.1) + 's');
        });
        
        // Enhanced hover effects (removed pulse animation)
        $('.nav-sidebar .nav-link').hover(
            function() {
                // Simple hover effect without animation
            },
            function() {
                // Simple hover effect without animation
            }
        );
    }
    
    // Enhanced Submenu Toggle with Smooth Animations
    function enhanceSubmenuToggle() {
        // Remove any existing custom event handlers to prevent conflicts
        $('.nav-sidebar .nav-item.has-treeview > .nav-link').off('click.custom');
        
        // Add enhanced click handler with smooth animations
        $('.nav-sidebar .nav-item.has-treeview > .nav-link').on('click.custom', function(e) {
            e.preventDefault();
            
            const $clickedLink = $(this);
            const $clickedItem = $clickedLink.parent('.nav-item');
            const $clickedSubmenu = $clickedItem.find('.nav-treeview');
            const $arrow = $clickedLink.find('.right');
            
            // Check if this menu is currently open
            const isCurrentlyOpen = $clickedItem.hasClass('menu-open');
            
            // Enhanced accordion behavior - close other menus with animation
            if (!isCurrentlyOpen) {
                // Close all other open menus with smooth animation
                $('.nav-sidebar .nav-item.has-treeview').not($clickedItem).each(function() {
                    const $otherItem = $(this);
                    const $otherSubmenu = $otherItem.find('.nav-treeview');
                    const $otherArrow = $otherItem.find('> .nav-link .right');
                    
                    if ($otherItem.hasClass('menu-open')) {
                        $otherItem.removeClass('menu-open');
                        $otherSubmenu.slideUp({
                            duration: 300,
                            easing: 'easeInOutCubic',
                            complete: function() {
                                $(this).css('display', '');
                            }
                        });
                        
                        // Smooth arrow rotation
                        $otherArrow.css({
                            'transition': 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)',
                            'transform': 'rotate(0deg)'
                        });
                    }
                });
                
                // Open the clicked menu with enhanced animation
                setTimeout(() => {
                    $clickedItem.addClass('menu-open');
                    $clickedSubmenu.slideDown({
                        duration: 350,
                        easing: 'easeOutCubic',
                        start: function() {
                            $(this).css('display', 'block');
                        }
                    });
                    
                    // Smooth arrow rotation for opened menu
                    $arrow.css({
                        'transition': 'transform 0.35s cubic-bezier(0.4, 0, 0.2, 1)',
                        'transform': 'rotate(90deg)'
                    });
                }, 100);
                
            } else {
                // Close the clicked menu
                $clickedItem.removeClass('menu-open');
                $clickedSubmenu.slideUp({
                    duration: 300,
                    easing: 'easeInOutCubic',
                    complete: function() {
                        $(this).css('display', '');
                    }
                });
                
                // Smooth arrow rotation for closed menu
                $arrow.css({
                    'transition': 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)',
                    'transform': 'rotate(0deg)'
                });
            }
            
            // Add ripple effect for better visual feedback
            addRippleEffect($clickedLink, e);
        });
        
        // Add keyboard support for accessibility
        $('.nav-sidebar .nav-item.has-treeview > .nav-link').on('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $(this).trigger('click.custom');
            }
        });
        
        // Initialize arrow states with smooth transitions
        initializeArrowStates();
    }
    
    // Active Menu Item Highlighting
    function highlightActiveMenuItem() {
        const currentPath = window.location.pathname;
        
        $('.nav-sidebar .nav-link').each(function() {
            const $link = $(this);
            const href = $link.attr('href');
            
            if (href && currentPath.includes(href.replace(/^.*\//, ''))) {
                $link.addClass('active');
                
                // Open parent menu if this is a submenu item
                const $parentMenu = $link.closest('.nav-treeview');
                if ($parentMenu.length > 0) {
                    $parentMenu.show();
                    $parentMenu.closest('.nav-item').addClass('menu-open');
                }
            }
        });
    }
    
    // Sidebar Scroll Enhancement
    function enhanceSidebarScroll() {
        const sidebar = $('.main-sidebar .sidebar');
        
        // Custom scrollbar for webkit browsers
        if (sidebar.length > 0) {
            sidebar.css({
                'scrollbar-width': 'thin',
                'scrollbar-color': 'rgba(255,255,255,0.3) transparent'
            });
        }
    }
    
    // Menu Badge Animation - Disabled for better performance
    function animateMenuBadges() {
        // Badge animations disabled to prevent conflicts
        // $('.badge').removeClass('animate__animated animate__pulse animate__infinite');
    }
    
    // Initialize menu state with enhanced performance
    function initializeMenuState() {
        // Use requestAnimationFrame for better performance
        requestAnimationFrame(() => {
            initializeArrowStates();
            highlightActiveMenuItem();
            
            // Add CSS for smooth submenu animations
            addSubmenuAnimationStyles();
        });
    }
    
    // Add CSS styles for enhanced animations
    function addSubmenuAnimationStyles() {
        if (!$('#submenu-animation-styles').length) {
            const styles = `
                <style id="submenu-animation-styles">
                    /* Enhanced submenu animations */
                    .nav-treeview {
                        overflow: hidden;
                        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    }
                    
                    .nav-item.has-treeview > .nav-link {
                        transition: all 0.2s ease;
                        position: relative;
                        overflow: hidden;
                    }
                    
                    .nav-item.has-treeview > .nav-link:hover {
                        background-color: rgba(255, 255, 255, 0.1);
                        transform: translateX(2px);
                    }
                    
                    .nav-item.has-treeview.menu-open > .nav-link {
                        background-color: rgba(255, 255, 255, 0.05);
                    }
                    
                    /* Ripple animation */
                    @keyframes menuRipple {
                        0% {
                            transform: scale(0);
                            opacity: 1;
                        }
                        100% {
                            transform: scale(2);
                            opacity: 0;
                        }
                    }
                    
                    /* Submenu item animations */
                    .nav-treeview .nav-item {
                        opacity: 0;
                        transform: translateX(-10px);
                        transition: all 0.3s ease;
                    }
                    
                    .menu-open .nav-treeview .nav-item {
                        opacity: 1;
                        transform: translateX(0);
                    }
                    
                    .menu-open .nav-treeview .nav-item:nth-child(1) { transition-delay: 0.05s; }
                    .menu-open .nav-treeview .nav-item:nth-child(2) { transition-delay: 0.1s; }
                    .menu-open .nav-treeview .nav-item:nth-child(3) { transition-delay: 0.15s; }
                    .menu-open .nav-treeview .nav-item:nth-child(4) { transition-delay: 0.2s; }
                    .menu-open .nav-treeview .nav-item:nth-child(5) { transition-delay: 0.25s; }
                </style>
            `;
            $('head').append(styles);
        }
    }
    
    // Initialize arrow states with smooth transitions
    function initializeArrowStates() {
        $('.nav-sidebar .nav-item.has-treeview > .nav-link .right').each(function() {
            const $arrow = $(this);
            const $parentItem = $arrow.closest('.nav-item.has-treeview');
            
            // Add smooth transition to all arrows
            $arrow.css({
                'transition': 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)',
                'transform-origin': 'center'
            });
            
            // Set initial state
            if ($parentItem.hasClass('menu-open')) {
                $arrow.css('transform', 'rotate(90deg)');
            } else {
                $arrow.css('transform', 'rotate(0deg)');
            }
        });
    }
    
    // Update menu arrows based on current state (legacy function for compatibility)
    function updateMenuArrows() {
        initializeArrowStates();
    }
    
    // Add ripple effect for better visual feedback
    function addRippleEffect($element, event) {
        const $ripple = $('<span class="menu-ripple"></span>');
        const elementRect = $element[0].getBoundingClientRect();
        const size = Math.max(elementRect.width, elementRect.height);
        const x = event.clientX - elementRect.left - size / 2;
        const y = event.clientY - elementRect.top - size / 2;
        
        $ripple.css({
            position: 'absolute',
            width: size + 'px',
            height: size + 'px',
            left: x + 'px',
            top: y + 'px',
            background: 'rgba(255, 255, 255, 0.3)',
            borderRadius: '50%',
            transform: 'scale(0)',
            animation: 'menuRipple 0.6s ease-out',
            pointerEvents: 'none',
            zIndex: 1
        });
        
        $element.css('position', 'relative').append($ripple);
        
        setTimeout(() => {
            $ripple.remove();
        }, 600);
    }
    
    // Initialize all enhancements
    initializeSidebarSearch();
    enhanceMenuAnimations();
    enhanceSubmenuToggle();
    initializeMenuState();
    highlightActiveMenuItem();
    enhanceSidebarScroll();
    animateMenuBadges();
    
    // Reinitialize on AJAX content load
    $(document).ajaxComplete(function() {
        highlightActiveMenuItem();
    });
    
    // Performance monitoring (only in development)
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
        console.log('Admin Sidebar Enhanced Successfully!');
    }
});

// Enhanced utility functions with improved animations
window.AdminSidebar = {
    
    // Programmatically open a menu item with smooth animation
    openMenuItem: function(selector) {
        const $item = $(selector);
        if ($item.length > 0) {
            const $parent = $item.closest('.nav-item.has-treeview');
            if ($parent.length > 0 && !$parent.hasClass('menu-open')) {
                // Close other menus first
                this.closeAllMenus();
                
                // Open the target menu with animation
                setTimeout(() => {
                    $parent.addClass('menu-open');
                    const $submenu = $parent.find('.nav-treeview');
                    const $arrow = $parent.find('> .nav-link .right');
                    
                    $submenu.slideDown({
                        duration: 350,
                        easing: 'easeOutCubic'
                    });
                    
                    $arrow.css({
                        'transition': 'transform 0.35s cubic-bezier(0.4, 0, 0.2, 1)',
                        'transform': 'rotate(90deg)'
                    });
                }, 50);
            }
        }
    },
    
    // Programmatically close all menus with smooth animation
    closeAllMenus: function() {
        $('.nav-sidebar .nav-item.has-treeview.menu-open').each(function() {
            const $item = $(this);
            const $submenu = $item.find('.nav-treeview');
            const $arrow = $item.find('> .nav-link .right');
            
            $item.removeClass('menu-open');
            $submenu.slideUp({
                duration: 300,
                easing: 'easeInOutCubic'
            });
            
            $arrow.css({
                'transition': 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)',
                'transform': 'rotate(0deg)'
            });
        });
    },
    
    // Search for a menu item
    searchMenuItem: function(query) {
        $('.sidebar-search-form .form-control-sidebar').val(query).trigger('input');
    },
    
    // Highlight a specific menu item with smooth transition
    highlightMenuItem: function(selector) {
        $('.nav-sidebar .nav-link').removeClass('active');
        const $target = $(selector);
        $target.addClass('active');
        
        // Scroll to the highlighted item if it's not visible
        if ($target.length > 0) {
            const sidebar = $('.main-sidebar .sidebar');
            const targetOffset = $target.offset().top;
            const sidebarOffset = sidebar.offset().top;
            const sidebarHeight = sidebar.height();
            
            if (targetOffset < sidebarOffset || targetOffset > sidebarOffset + sidebarHeight) {
                sidebar.animate({
                    scrollTop: sidebar.scrollTop() + targetOffset - sidebarOffset - sidebarHeight / 2
                }, 300);
            }
        }
    },
    
    // Toggle a specific menu item
    toggleMenuItem: function(selector) {
        const $item = $(selector).closest('.nav-item.has-treeview');
        if ($item.length > 0) {
            const $link = $item.find('> .nav-link');
            $link.trigger('click.custom');
        }
    },
    
    // Check if a menu item is open
    isMenuOpen: function(selector) {
        const $item = $(selector).closest('.nav-item.has-treeview');
        return $item.hasClass('menu-open');
    }
};
