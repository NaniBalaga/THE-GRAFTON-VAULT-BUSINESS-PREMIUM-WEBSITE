<?php
// --- CONFIGURATION ---
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'db.php';

// --- CONTACT HANDLER ---
 $contact_msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_contact'])) {
    header("Location: submit_contact_handle.php"); 
    exit();
}

// Fetch Banner
 $banner_res = $conn->query("SELECT * FROM banners WHERE is_active = 1 LIMIT 1");
 $banner = $banner_res->fetch_assoc();

// Fetch all gallery images for mobile optimization
 $gallery_sql = "SELECT * FROM shop_gallery ORDER BY id DESC LIMIT 8";
 $gallery_result = $conn->query($gallery_sql);
 $gallery_images = [];
while($img = $gallery_result->fetch_assoc()) {
    $gallery_images[] = $img;
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth no-scrollbar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>The Grafton Vault - Concierge Service</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&family=Cinzel:wght@400;500;600&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { 
                        cream: '#f7f0e3', 
                        navy: '#0A1A33', 
                        gold: '#B29243',
                        darkGold: '#8B6C2E',
                        lightGold: '#d4af77'
                    },
                    fontFamily: { 
                        serif: ['"Libre Baskerville"', 'serif'], 
                        sans: ['"Lato"', 'sans-serif'],
                        cinzel: ['Cinzel', 'serif'],
                        playfair: ['Playfair Display', 'serif']
                    },
                    backgroundImage: { 
                        'gold-gradient': 'linear-gradient(135deg, #B29243, #d4af77, #B29243)',
                        'navy-gradient': 'linear-gradient(135deg, #0A1A33, #1a2b4d)',
                        'diamond-pattern': 'url("data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23B29243\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")'
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'shimmer': 'shimmer 2s infinite',
                        'pulse-gold': 'pulse-gold 2s infinite',
                        'slide-up': 'slide-up 0.5s ease-out',
                        'fade-in': 'fade-in 0.8s ease-out',
                        'slide-in-left': 'slide-in-left 0.8s ease-out',
                        'slide-in-right': 'slide-in-right 0.8s ease-out',
                        'scale-in': 'scale-in 0.8s ease-out'
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' }
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-1000px 0' },
                            '100%': { backgroundPosition: '1000px 0' }
                        },
                        'pulse-gold': {
                            '0%, 100%': { opacity: 1 },
                            '50%': { opacity: 0.7 }
                        },
                        'slide-up': {
                            '0%': { transform: 'translateY(20px)', opacity: 0 },
                            '100%': { transform: 'translateY(0)', opacity: 1 }
                        },
                        'fade-in': {
                            '0%': { opacity: 0 },
                            '100%': { opacity: 1 }
                        },
                        'slide-in-left': {
                            '0%': { transform: 'translateX(-30px)', opacity: 0 },
                            '100%': { transform: 'translateX(0)', opacity: 1 }
                        },
                        'slide-in-right': {
                            '0%': { transform: 'translateX(30px)', opacity: 0 },
                            '100%': { transform: 'translateX(0)', opacity: 1 }
                        },
                        'scale-in': {
                            '0%': { transform: 'scale(0.95)', opacity: 0 },
                            '100%': { transform: 'scale(1)', opacity: 1 }
                        }
                    },
                    screens: {
                        'xs': '375px',
                        'sm': '640px',
                        'md': '768px',
                        'lg': '1024px',
                        'xl': '1280px',
                        '2xl': '1536px',
                    }
                }
            }
        }
    </script>
    <style>
    /* Base Styles */
    * {
        box-sizing: border-box;
    }
    
    html {
        scroll-behavior: smooth;
    }
    
    body {
        overflow-x: hidden;
        width: 100%;
        max-width: 100%;
    }
    
    .no-scrollbar::-webkit-scrollbar { 
        display: none; 
    }
    
    .no-scrollbar { 
        -ms-overflow-style: none; 
        scrollbar-width: none; 
    }
    
    /* Enhanced Reveal Animation */
    .reveal { 
        opacity: 0; 
        transform: translateY(30px) scale(0.98); 
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1); 
    }
    .reveal.active { 
        opacity: 1; 
        transform: translateY(0) scale(1); 
    }
    .reveal-left { 
        opacity: 0; 
        transform: translateX(-30px); 
        transition: all 0.8s ease-out; 
    }
    .reveal-left.active { 
        opacity: 1; 
        transform: translateX(0); 
    }
    .reveal-right { 
        opacity: 0; 
        transform: translateX(30px); 
        transition: all 0.8s ease-out; 
    }
    .reveal-right.active { 
        opacity: 1; 
        transform: translateX(0); 
    }
    
    /* FIXED BANNER & HEADER STYLES */
    .top-banner { 
        position: fixed; 
        top: 0;
        left: 0;
        width: 100%;
        height: 40px;
        background: linear-gradient(135deg, #0A1A33, #1a2b4d); 
        color: #B29243; 
        font-size: 10px; 
        text-transform: uppercase; 
        letter-spacing: 0.3em; 
        text-align: center; 
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 100; 
        border-bottom: 1px solid rgba(178, 146, 67, 0.3); 
        transition: all 0.5s ease; 
        background-size: 200% 100%;
        animation: shimmer 3s infinite;
    }
    .top-banner:hover { 
        background: linear-gradient(135deg, #B29243, #d4af77); 
        color: #0A1A33; 
        letter-spacing: 0.4em;
    }
    
    /* Header Logic adjusted for fixed banner */
    header {
        position: fixed;
        width: 100%;
        z-index: 90;
        transition: all 0.3s ease;
    }

    header.scrolled { 
        background-color: rgba(247, 240, 227, 0.98); 
        backdrop-filter: blur(15px); 
        padding: 0.5rem 0; 
        box-shadow: 0 10px 30px rgba(10, 26, 51, 0.15);
        border-bottom: 1px solid rgba(178, 146, 67, 0.1);
    }
    header.scrolled .logo { color: #0A1A33; }
    header.scrolled nav a { color: #0A1A33; }
    header.scrolled nav { border-top-color: transparent; margin-top: 0; }
    
    .diamond-line::before, .diamond-line::after { 
        content: ''; 
        height: 1px; 
        flex: 1; 
        background: linear-gradient(90deg, transparent, #B29243 20%, #d4af77 50%, #B29243 80%, transparent); 
    }
    
    /* Enhanced Popup Styles - MODIFIED FOR FULL Z-INDEX */
    #service-popup, #image-popup { 
        position: fixed; /* Ensures it covers viewport */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 2000; /* Highest Priority - Updated */
        background: rgba(0, 0, 0, 0.95); /* Darker background for better contrast */
        backdrop-filter: blur(8px);
        transition: opacity 0.4s ease, visibility 0.4s ease; 
        opacity: 0; 
        visibility: hidden; 
        display: flex; /* Center content */
        align-items: center;
        justify-content: center;
        overflow: hidden; /* Prevent spillover */
    }
    #service-popup.active, #image-popup.active { 
        opacity: 1; 
        visibility: visible; 
    }
    .popup-content { 
        transform: translateY(30px) scale(0.95); 
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1); 
        position: relative;
        z-index: 2001;
    }
    #service-popup.active .popup-content, #image-popup.active .popup-content { 
        transform: translateY(0) scale(1); 
    }
    
    /* Enhanced FAQ Animation */
    .faq-answer { 
        max-height: 0; 
        overflow: hidden; 
        transition: max-height 0.6s cubic-bezier(0.4, 0, 0.2, 1), padding 0.6s ease; 
    }
    .group.active .faq-answer { 
        max-height: 500px; 
        padding-bottom: 1.5rem; 
    }
    .group.active .faq-icon { 
        transform: rotate(180deg); 
        color: #B29243; 
    }

    /* Enhanced Interactive Cursor */
    @media (hover: hover) and (pointer: fine) {
        body { cursor: none; }
        a, button, input, textarea, select { cursor: none; }
        .cursor { 
            width: 12px; 
            height: 12px; 
            background: radial-gradient(circle, #B29243 20%, transparent 70%); 
            border-radius: 50%; 
            position: fixed; 
            pointer-events: none; 
            z-index: 9999; 
            mix-blend-mode: difference; 
            transition: all 0.08s ease;
            transform: translate(-50%, -50%); 
            filter: drop-shadow(0 0 8px rgba(178, 146, 67, 0.5));
        }
        .cursor-follower { 
            width: 40px; 
            height: 40px; 
            background: radial-gradient(circle, rgba(178, 146, 67, 0.2) 0%, transparent 70%); 
            border: 1px solid rgba(178, 146, 67, 0.3);
            border-radius: 50%; 
            position: fixed; 
            pointer-events: none; 
            z-index: 9998; 
            transform: translate(-50%, -50%); 
            transition: transform 0.15s ease, width 0.3s ease, height 0.3s ease;
            backdrop-filter: blur(2px); 
        }
        .cursor.hover { 
            width: 25px; 
            height: 25px; 
            background: radial-gradient(circle, #B29243 30%, transparent 70%); 
            mix-blend-mode: normal; 
            border-color: transparent; 
        }
        .cursor-follower.hover { 
            width: 60px; 
            height: 60px; 
            background: radial-gradient(circle, rgba(178, 146, 67, 0.15) 0%, transparent 70%); 
            border-color: rgba(178, 146, 67, 0.5);
        }
    }

    /* Enhanced Gallery Grid */
    .gallery-grid {
        display: grid;
        gap: 1rem;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        grid-auto-rows: 200px;
        grid-auto-flow: dense;
    }
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        cursor: pointer;
    }
    .gallery-item.wide {
        grid-column: span 2;
    }
    .gallery-item.tall {
        grid-row: span 2;
    }
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .gallery-item:hover img {
        transform: scale(1.08);
    }
    .gallery-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(10, 26, 51, 0.8) 0%, transparent 50%);
        opacity: 0;
        transition: opacity 0.4s ease;
        display: flex;
        align-items: flex-end;
        padding: 1rem;
    }
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    /* Enhanced Decorative Elements */
    .decorative-border {
        position: relative;
        border: 1px solid transparent;
        background: linear-gradient(#f7f0e3, #f7f0e3) padding-box,
                  linear-gradient(45deg, #B29243, transparent, #B29243) border-box;
    }
    .diamond-shape {
        width: 10px;
        height: 10px;
        background: #B29243;
        transform: rotate(45deg);
        position: relative;
    }
    .diamond-shape::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 4px;
        height: 4px;
        background: white;
        border-radius: 1px;
    }
    .ornamental-line {
        height: 1px;
        background: linear-gradient(90deg,
            transparent,
            transparent 10%,
            #B29243 30%,
            #d4af77 50%,
            #B29243 70%,
            transparent 90%,
            transparent
        );
    }
    .floating-element {
        animation: float 6s ease-in-out infinite;
    }
    .text-glow {
        text-shadow: 0 0 20px rgba(178, 146, 67, 0.3);
    }
    
    /* UPDATED: Bigger Image Popup */
    #image-popup .popup-image {
        max-width: 98vw;
        max-height: 95vh;
        width: auto;
        height: auto;
        object-fit: contain;
        /* Transition for smooth zooming */
        transition: transform 0.1s linear; 
        transform-origin: center center;
        cursor: grab;
    }
    
    #image-popup .popup-image:active {
        cursor: grabbing;
    }

    .popup-navigation {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
        padding: 0 2rem;
        z-index: 2003;
        pointer-events: none; /* Let clicks pass through to image for dragging */
    }
    
    /* Make buttons clickable again */
    .popup-navigation button {
        pointer-events: auto;
    }

    .popup-counter {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(10, 26, 51, 0.8);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        z-index: 2003;
    }

    /* Zoom Controls */
    .zoom-controls {
        position: absolute;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 1rem;
        z-index: 2003;
        background: rgba(0, 0, 0, 0.6);
        padding: 0.5rem;
        border-radius: 2rem;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .zoom-btn {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        border: none;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .zoom-btn:hover {
        background: #B29243;
        color: #0A1A33;
    }
    
    /* Enhanced Connection Wires Effect */
    .connection-line {
        position: absolute;
        background: linear-gradient(90deg, #B29243, #d4af77, #B29243);
        height: 2px;
        opacity: 0.3;
        transform-origin: left center;
        animation: pulse-gold 2s infinite;
    }
    .connection-dot {
        width: 8px;
        height: 8px;
        background: #B29243;
        border-radius: 50%;
        position: absolute;
        animation: pulse-gold 1.5s infinite;
    }
    
    /* Fix for popup close buttons - MODIFIED Z-INDEX & SIZE */
    .popup-close-btn {
        position: fixed;
        top: 1.5rem; /* Adjusted positioning */
        right: 1.5rem; /* Adjusted positioning */
        z-index: 2004; /* Higher than popup (2000) */
        width: 2.5rem; /* Smaller size */
        height: 2.5rem; /* Smaller size */
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }
    .popup-close-btn:hover {
        background: #B29243;
        color: white;
        transform: scale(1.1);
    }
    .popup-close-btn i {
        font-size: 1rem; /* Smaller icon */
    }
    
    /* Instagram overlay styling */
    .instagram-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(10, 26, 51, 0.9) 0%, rgba(10, 26, 51, 0.5) 50%, transparent 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        padding: 1.5rem;
    }
    .instagram-item:hover .instagram-overlay {
        opacity: 1;
    }
    .instagram-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: white;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.75rem;
        background: rgba(178, 146, 67, 0.8);
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        transition: all 0.3s ease;
    }
    .instagram-link:hover {
        background: #B29243;
        transform: translateY(-2px);
    }
    
    /* Mobile Menu Scroll Navigation */
    .nav-scroll-container {
        position: relative;
        overflow: hidden;
        width: 100%;
    }
    
    .nav-scroll-wrapper {
        display: flex;
        overflow-x: auto;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        padding-bottom: 5px;
    }
    
    .nav-scroll-wrapper::-webkit-scrollbar {
        display: none;
    }
    
    .scroll-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        color: #B29243;
        font-size: 0.8rem;
        opacity: 0;
        transition: opacity 0.3s ease, background 0.3s ease;
        pointer-events: none;
    }
    
    .nav-scroll-container:hover .scroll-btn {
        opacity: 1;
        pointer-events: auto;
    }
    
    .scroll-btn:hover {
        background: rgba(178, 146, 67, 0.3);
    }
    
    .scroll-btn-left {
        left: 0;
        box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    }
    
    .scroll-btn-right {
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
    }
    
    /* Mobile Navigation Scroll Indicators */
    .scroll-indicator {
        position: absolute;
        bottom: -5px;
        left: 0;
        height: 2px;
        background: #B29243;
        border-radius: 1px;
        transition: width 0.3s ease, transform 0.3s ease;
        z-index: 5;
    }
    
/* Sidebar Styles */
.sidebar {
    position: fixed;
    top: 0;
    right: -300px;
    width: 300px;
    height: 100%;
    background: rgba(10, 26, 51, 0.98);
    backdrop-filter: blur(10px);
    z-index: 1000;
    transition: right 0.3s ease;
    overflow-y: auto;
    padding: 2rem 1.5rem;
    box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
}

.sidebar.active {
    right: 0;
}

.sidebar-toggle {
    position: fixed;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
    background: #B29243;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 99;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

/* 📱 Mobile view */
@media (max-width: 768px) {
    .sidebar-toggle {
        width: 38px;
        height: 38px;
        right: 12px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
    }

    .sidebar-toggle i {
        font-size: 14px;
    }
}

.sidebar-toggle:hover {
    background: #d4af77;
    transform: translateY(-50%) scale(1.1);
}

.sidebar-toggle i {
    color: white;
    font-size: 1.2rem;
    transition: transform 0.3s ease;
}

.sidebar-toggle.active i {
    transform: rotate(180deg);
}

.sidebar-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 30px;
    height: 30px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.sidebar-close:hover {
    background: rgba(255, 255, 255, 0.2);
}

.sidebar-close i {
    color: white;
    font-size: 1rem;
}

.sidebar-nav {
    margin-top: 3rem;
}

.sidebar-nav a {
    display: block;
    color: #B29243; /* Changed to gold */
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    font-family: 'Lato', sans-serif;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.sidebar-nav a:hover {
    color: white; /* Changed to white */
    padding-left: 10px;
}

/* Book Consultation Button */
.book-consultation-btn {
    background-color: #B29243;
    color: white !important;
    text-align: center;
    margin-top: 1rem;
    border-radius: 4px;
    border: none;
    padding: 0.75rem 1rem !important;
    font-weight: 600;
}

.book-consultation-btn:hover {
    background-color: white !important;
    color: #B29243 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.sidebar-social {
    margin-top: 2rem;
    display: flex;
    gap: 1rem;
}

.sidebar-social a {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #B29243;
    transition: all 0.3s ease;
}

.sidebar-social a:hover {
    background: white;
    transform: translateY(-3px);
}

.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 998;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.sidebar-overlay.active {
    opacity: 1;
    visibility: visible;
}
    
    /* Mobile Responsive Styles */
@media (max-width: 768px) {
    .top-banner {
        height: 35px;
        font-size: 9px;
        letter-spacing: 0.1em;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    header {
        padding: 0.5rem 0;
    }
    
    .logo {
        font-size: 1.2rem;
    }
    
    nav ul {
        font-size: 0.7rem;
        padding: 0 10px;
    }
    
    /* FIX: Force hero logo to have minimal bottom spacing */
    #home img {
        margin-bottom: 5px !important;
        height: 80px; /* Control logo size on mobile */
        width: auto;
    }

    /* FIX: Remove padding and margin to close the gap */
    #home h1 {
        font-size: 2rem; 
        padding-top: 0 !important; 
        margin-top: 0 !important;
        margin-bottom: 15px;
        line-height: 1.1;
    }
    
    #home p {
        font-size: 0.9rem;
        padding: 0 10px;
        line-height: 1.6;
    }
    
    .collection-image {
        height: 300px;
    }
    
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        grid-auto-rows: 150px;
    }
    
    .scroll-btn {
        opacity: 1;
        background: rgba(10, 26, 51, 0.7);
        pointer-events: auto;
    }
    
    /* Show scroll buttons on mobile */
    .nav-scroll-container .scroll-btn {
        opacity: 0.7;
    }
    
    /* Adjust header spacing for mobile */
    header[style*="top: 40px"] {
        top: 35px !important;
    }
    
    /* Fix for mobile sidebar */
    .sidebar {
        width: 80%;
        right: -80%;
    }
    
    .sidebar-toggle {
        width: 40px;
        height: 40px;
        right: 15px;
    }
    
    .sidebar-toggle i {
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .top-banner {
        height: 30px;
        font-size: 8px;
        letter-spacing: 0.05em;
    }
    
    #home h1 {
        font-size: 1.8rem;
        padding-top: 0 !important;
    }
    
    .logo {
        font-size: 1rem;
    }
    
    nav ul {
        font-size: 0.6rem;
        gap: 10px;
    }
    
    .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }
    
    header[style*="top: 40px"] {
        top: 30px !important;
    }
    
    /* Fix for mobile sidebar */
    .sidebar {
        width: 85%;
        right: -85%;
    }
}

/* Touch device optimizations */
@media (hover: none) and (pointer: coarse) {
    .cursor, .cursor-follower {
        display: none;
    }
    
    body, a, button, input, textarea, select {
        cursor: auto;
    }
    
    .gallery-item:hover img {
        transform: none;
    }
    
    .gallery-item:active img {
        transform: scale(1.05);
    }
    
    .nav-scroll-container:hover .scroll-btn {
        opacity: 0.7;
    }
}

/* Tablet optimizations */
@media (min-width: 769px) and (max-width: 1024px) {
    .top-banner {
        height: 38px;
        font-size: 9px;
    }
    
    #home h1 {
        font-size: 3.5rem;
        padding-top: -30;
    }
    
    .gallery-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    
    nav ul {
        font-size: 0.8rem;
    }
}
    
    /* Smooth scroll animation */
    .scroll-animate {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease;
    }
    
    .scroll-animate.animated {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Staggered animation delays */
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
    .delay-5 { animation-delay: 0.5s; }
    .delay-6 { animation-delay: 0.6s; }
    .delay-7 { animation-delay: 0.7s; }
    .delay-8 { animation-delay: 0.8s; }
</style>
</head>
<body class="bg-cream text-navy antialiased font-serif selection:bg-gold selection:text-white relative">

    <div class="connection-line hidden md:block" style="top: 200px; left: 5%; width: 100px; transform: rotate(20deg);"></div>
    <div class="connection-line hidden md:block" style="top: 400px; right: 5%; width: 150px; transform: rotate(-15deg);"></div>
    <div class="connection-dot hidden md:block" style="top: 150px; left: 10%;"></div>
    <div class="connection-dot hidden md:block" style="top: 350px; right: 8%;"></div>
    <div class="absolute inset-0 bg-diamond-pattern opacity-5 pointer-events-none"></div>

    <!-- CHANGED: Updated z-index to z-[2001] to ensure it is on top of everything -->
    <div id="loader" class="fixed inset-0 z-[2001] bg-navy flex flex-col justify-center items-center transition-opacity duration-700">
        <div class="relative mb-8">
            <img src="temp/logo_bg.png" alt="The Grafton Vault Logo" class="w-48 md:w-64 object-contain floating-element">
            <div class="absolute inset-0 bg-gradient-to-r from-gold/20 to-transparent blur-xl"></div>
        </div>
        <div class="text-gold text-sm font-sans tracking-widest uppercase animate-pulse">Loading Elegance</div>
    </div>

    <div class="cursor hidden md:block"></div>
    <div class="cursor-follower hidden md:block"></div>

    <?php if($banner): ?>
    <div class="top-banner">
        <a href="<?php echo htmlspecialchars($banner['url']); ?>" class="block">
            <?php echo htmlspecialchars($banner['text']); ?>
        </a>
    </div>
    <?php endif; ?>

    <header id="header" class="py-4 md:py-6" style="top: <?php echo $banner ? '40px' : '0'; ?>;">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-center mb-3 md:mb-4">
    <a href="index.php"
       class="logo text-white text-xl md:text-3xl font-bold uppercase tracking-widest relative group">
        <span class="font-cinzel">The Grafton</span>
        <span class="font-cinzel font-light">Vault</span>
        <span class="absolute -bottom-1 left-0 w-8 h-0.5 bg-gold transition-all duration-300 group-hover:w-full"></span>
    </a>

    <div class="text-gold flex items-center">
        <img src="temp/main_logo_bg.png"
             alt="TGV Logo"
             style="height:32px;width:auto;"
             class="md:h-10">
    </div>
</div>

            
            <!-- Mobile Responsive Navigation with Scroll -->
            <div class="nav-scroll-container relative">
                <button class="scroll-btn scroll-btn-left hidden md:block" onclick="scrollNav('left')">
                    <i class="fas fa-chevron-left"></i>
                </button>
                
                <nav class="border-t border-white/20 transition-all duration-300 pt-3 md:pt-4">
                    <ul class="nav-scroll-wrapper flex justify-start md:justify-center space-x-4 md:space-x-8 lg:space-x-12 text-white text-xs md:text-sm font-sans font-bold uppercase tracking-widest whitespace-nowrap">
                        <li class="flex-shrink-0"><a href="#home" class="hover:text-gold transition-colors">Home</a></li>
                        <li class="flex-shrink-0"><a href="#collections" class="hover:text-gold transition-colors">Collections</a></li>
                        <li class="flex-shrink-0"><a href="#services" class="hover:text-gold transition-colors">Services</a></li>
                        <li class="flex-shrink-0"><a href="#gallery" class="hover:text-gold transition-colors">Gallery</a></li>
                        <li class="flex-shrink-0"><a href="#journal" class="hover:text-gold transition-colors">Journal</a></li>
                        <li class="flex-shrink-0"><a href="https://www.instagram.com/thegraftonvault/" class="hover:text-gold transition-colors">Social</a></li>
                        <li class="flex-shrink-0"><a href="#contact" class="hover:text-gold transition-colors">Contact</a></li>
                    </ul>
                </nav>
                
                <button class="scroll-btn scroll-btn-right hidden md:block" onclick="scrollNav('right')">
                    <i class="fas fa-chevron-right"></i>
                </button>
                
                <div class="scroll-indicator"></div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
   <!-- Sidebar -->
<div class="sidebar-overlay" id="sidebar-overlay"></div>
<div class="sidebar" id="sidebar">
    <div class="sidebar-close" id="sidebar-close">
        <i class="fas fa-times"></i>
    </div>
    
    <div class="text-center mb-8">
        <a href="index.php" class="logo text-white text-2xl font-bold uppercase tracking-widest font-cinzel">
            TGV
        </a>
    </div>
    
    <nav class="sidebar-nav">
        <a href="index.php#home">Home</a>
        <a href="all_collections.php">Collections</a>
        <a href="full_gallery.php">Gallery</a>
        <a href="blogs.php">Journal</a>
        <a href="instagram_posts.php">Social</a>
        <a href="contact_us.php">Contact</a>
        <a href="overall_rating.php">Reviews</a>
        <a href="help_support_qna.php">FAQ</a>
        <a href="https://calendly.com/thegraftonvault?background_color=f7f0e3&text_color=0a1a33&primary_color=b29243" class="book-consultation-btn">Book Consultation</a>
    </nav>
    
    <div class="sidebar-social">
        <a href="https://www.instagram.com/thegraftonvault/" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="https://www.facebook.com/profile.php?id=61585326779674" target="_blank"><i class="fab fa-facebook-f"></i></a>
        <a href="https://ie.pinterest.com/thegraftonvault/" target="_blank"><i class="fab fa-pinterest-p"></i></a>
        <a href="https://www.linkedin.com/company/the-grafton-vault/?viewAsMember=true" target="_blank"><i class="fab fa-linkedin"></i></a>
    </div>
</div>

<div class="sidebar-toggle" id="sidebar-toggle">
    <i class="fas fa-bars"></i>
</div>

    <section id="home" class="h-screen w-full relative flex items-center justify-center overflow-hidden pt-16 md:pt-0">
    <div class="absolute inset-0 z-0">
        <video class="w-full h-full object-cover" autoplay muted loop playsinline poster="https://images.unsplash.com/photo-1605100804763-247f67b3557e?auto=format&fit=crop&w=1920&q=80">
            <source src="temp/new_hero_section_demo.mp4" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-gradient-to-b from-navy/40 via-navy/20 to-navy/60"></div>
    </div>
    
    <div class="absolute top-1/4 left-10 w-32 h-px ornamental-line hidden md:block"></div>
    <div class="absolute bottom-1/4 right-10 w-32 h-px ornamental-line hidden md:block"></div>
    
    <div class="relative z-10 text-center text-white px-4 max-w-4xl mt-8 md:mt-16 scroll-animate">
        <div class="flex items-center justify-center gap-4 mb-6">
            <div class="w-16 h-px bg-gradient-to-r from-transparent to-gold"></div>
            <div class="text-gold text-sm font-sans uppercase tracking-[0.3em]">Premium</div>
            <div class="w-16 h-px bg-gradient-to-l from-transparent to-gold"></div>
        </div>

        <img src="temp/main_logo_bg.png" 
             alt="The Grafton Vault" 
             class="mx-auto h-24 md:h-32 -mb-4 md:mb-0 object-contain drop-shadow-2xl">

        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl mb-6 leading-tight drop-shadow-2xl font-cinzel text-glow px-4">Timeless Elegance</h1>
        
        <p class="font-sans text-base sm:text-lg md:text-xl font-light tracking-wide text-cream/90 mb-10 max-w-2xl mx-auto px-4">Discover The Grafton Vault collection where craftsmanship meets legacy in every piece.</p>
        
        <a href="#collections" class="group px-8 sm:px-10 py-3 bg-gold text-navy font-sans text-xs font-bold uppercase tracking-widest hover:bg-white transition-colors duration-300 shadow-lg inline-block">
            Explore Collections
        </a>
    </div>
    
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
        <div class="w-px h-12 bg-gradient-to-b from-gold to-transparent"></div>
    </div>
</section>

    <div class="py-16 flex items-center justify-center w-3/4 max-w-2xl mx-auto opacity-60 diamond-line">
        <div class="diamond-shape mx-6"></div>
    </div>

    <section id="collections" class="py-12 md:py-24 px-4 md:px-12 bg-cream relative">
        <div class="absolute top-0 left-0 w-64 h-64 bg-gradient-to-br from-gold/5 to-transparent rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        
        <div class="text-center mb-12 md:mb-16 scroll-animate">
            <span class="font-sans text-gold text-xs font-bold tracking-[0.2em] uppercase mb-4 block">Curated Excellence</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl text-navy mb-4 font-cinzel">Our Collections</h2>
            <p class="font-sans text-navy/70 max-w-xl mx-auto px-4">Distinct collections tailored to every unique story and occasion.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            <?php
            $sql = "SELECT * FROM collections ORDER BY id DESC LIMIT 3";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $counter = 0;
                while($row = $result->fetch_assoc()) {
                    $counter++;
                    echo '
                    <div class="group relative h-[350px] md:h-[450px] overflow-hidden scroll-animate decorative-border rounded-sm shadow-lg delay-'.$counter.'">
                        <img src="'.$row['cover_image'].'" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 cursor-pointer collection-image"
                             data-title="'.$row['title'].'"
                             data-description="'.htmlspecialchars($row['description'] ?? '').'"
                             onclick="openImagePopup(\''.$row['cover_image'].'\', \''.$row['title'].'\')">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy/70 via-navy/30 to-transparent group-hover:from-navy/80 transition-colors flex flex-col items-center justify-end p-6 md:p-8 text-white">
                            <h3 class="text-xl md:text-2xl font-cinzel uppercase tracking-widest mb-4 text-center">'.$row['title'].'</h3>
                            <p class="text-cream/80 font-sans text-sm text-center mb-6 hidden md:block group-hover:block transition-all duration-300">'.substr($row['description'] ?? 'Discover this exclusive collection', 0, 100).'...</p>
                            <div class="flex gap-3 md:gap-4">
                                <a href="collection_info.php?item='.$row['id'].'" class="font-sans text-xs font-bold border border-white px-4 md:px-6 py-2 hover:bg-white hover:text-navy transition-colors">View Details</a>
                                <button onclick="openImagePopup(\''.$row['cover_image'].'\', \''.$row['title'].'\')" class="font-sans text-xs font-bold border border-gold px-4 md:px-6 py-2 hover:bg-gold hover:text-navy transition-colors text-gold">View Image</button>
                            </div>
                        </div>
                    </div>';
                }
            }
            ?>
        </div>
        
        <div class="text-center mt-12 md:mt-16 scroll-animate">
            <a href="all_collections.php" class="inline-flex items-center gap-2 text-gold font-sans text-sm uppercase tracking-widest border-b border-gold pb-1 hover:border-darkGold hover:text-darkGold transition-colors">
                View All Collections
                <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>
    </section>

    <section id="services" class="py-12 md:py-24 bg-white text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-diamond-pattern opacity-5 pointer-events-none"></div>
        <div class="absolute top-20 right-0 w-96 h-96 bg-gradient-to-bl from-gold/10 to-transparent rounded-full translate-x-1/2 -translate-y-1/2"></div>
        
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="mb-12 md:mb-16 scroll-animate">
                <span class="font-sans text-gold text-xs font-bold tracking-[0.2em] uppercase">Exceptional Care</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl text-navy mt-4 font-cinzel">Our Services</h2>
                <div class="w-16 h-px bg-gold mx-auto mt-6"></div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 md:gap-8 justify-center">
                <?php
                $serv_sql = "SELECT * FROM services ORDER BY id ASC";
                $servs = $conn->query($serv_sql);
                if ($servs->num_rows > 0) {
                    $counter = 0;
                    while($s = $servs->fetch_assoc()):
                        $counter++;
                ?>
                <div class="group flex flex-col items-center cursor-pointer scroll-animate delay-<?php echo $counter; ?>" onclick='openServicePopup(<?php echo json_encode($s); ?>)'>
                    <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-32 md:h-32 lg:w-40 lg:h-40 rounded-full overflow-hidden border-2 border-transparent group-hover:border-gold transition-all duration-500 mb-4 md:mb-6 relative shadow-lg group-hover:shadow-xl">
                        <img src="<?php echo htmlspecialchars($s['icon_image']); ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-br from-navy/20 via-transparent to-gold/10 group-hover:from-transparent transition-all duration-500 flex items-center justify-center">
                            <i class="fas fa-plus text-white opacity-0 group-hover:opacity-100 transition-opacity transform scale-75 group-hover:scale-100 duration-300 bg-gold/80 rounded-full p-2"></i>
                        </div>
                    </div>
                    <h3 class="font-bold text-navy text-xs md:text-sm uppercase tracking-widest group-hover:text-gold transition-colors text-center px-2"><?php echo htmlspecialchars($s['title']); ?></h3>
                </div>
                <?php endwhile; } ?>
            </div>
            
            <div class="mt-12 md:mt-16 text-center scroll-animate">
                <a href="#contact" class="group inline-flex items-center gap-2 text-xs font-bold text-navy uppercase tracking-widest border-b border-navy pb-1 hover:text-gold hover:border-gold transition-colors">
                    Inquire About Services
                    <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>
        </div>
    </section>

    <section id="about" class="py-12 md:py-20 px-4 md:px-12 bg-cream relative">
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-gold/10 to-transparent rounded-full -translate-x-1/2 translate-y-1/2"></div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 md:gap-16 items-center">
        <div class="text-center lg:text-left scroll-animate">
            <span class="font-sans text-gold text-xs font-bold tracking-[0.2em] uppercase block mb-4">The Grafton Standard</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl text-navy mb-6 md:mb-8 leading-tight font-cinzel">Our Heritage of <span class="italic text-gold">Perfection</span></h2>
            
            <p class="font-sans text-navy/70 mb-6 leading-relaxed text-base md:text-lg">"We do not simply make jewellery; we craft legacies intended to outlast the very stars themselves."</p>
            
            <div class="flex items-center gap-4 mt-6 md:mt-8">
                <div class="w-12 h-px bg-gold"></div>
                <div class="font-playfair text-xl md:text-2xl text-navy italic">Ian James Conway</div>
                <div class="w-12 h-px bg-gold"></div>
            </div>
        </div>

        <div class="relative h-[400px] md:h-[500px] lg:h-[600px] decorative-border p-4 scroll-animate group">
            <img src="temp/ian.jpeg" 
                 alt="Heritage Craftsmanship" 
                 class="w-full h-full object-cover transition-all duration-700 cursor-pointer brightness-100 group-hover:brightness-50"
                 style="object-position: top;"
                 onclick="openImagePopup(
                   'https://images.unsplash.com/photo-1617038224558-28ad3fb558a7?auto=format&fit=crop&w=800&q=80',
                   'Grafton Heritage'
                 )">
                 
             </div>
    </div>
</section>

    <section id="gallery" class="py-12 md:py-32 bg-cream relative overflow-hidden">
        <div class="absolute inset-0 bg-diamond-pattern opacity-5 pointer-events-none parallax-bg" data-speed="0.2"></div>
        
        <div class="absolute inset-0 pointer-events-none z-0">
            <svg class="w-full h-full scroll-draw-svg" preserveAspectRatio="none" viewBox="0 0 100 100">
                <path d="M0,20 Q25,20 25,50 T50,80 T75,50 T100,20" 
                      fill="none" 
                      stroke="#1a1a1a" 
                      stroke-width="0.25" 
                      stroke-opacity="0.9"
                      class="draw-line" />
                
                <path d="M100,90 Q75,90 75,60 T50,30 T25,60 T0,90" 
                      fill="none" 
                      stroke="#1a1a1a" 
                      stroke-width="0.1" 
                      stroke-dasharray="1,1" 
                      stroke-opacity="0.5"
                      class="draw-line-delayed" />
            </svg>
        </div>
        
        <div class="absolute inset-0 pointer-events-none z-10">
            <div class="absolute top-1/4 left-1/4 w-1 h-1 bg-gold/50 rounded-full animate-float-slow"></div>
            <div class="absolute top-3/4 right-1/3 w-2 h-2 bg-gold/30 rounded-full animate-float-medium"></div>
            <div class="absolute bottom-1/4 left-2/3 w-1.5 h-1.5 bg-navy/20 rounded-full animate-float-fast"></div>
        </div>
        
        <div class="absolute top-0 left-0 w-full h-40 bg-gradient-to-b from-white to-transparent z-10"></div>
        <div class="absolute bottom-0 left-0 w-full h-40 bg-gradient-to-t from-white to-transparent z-10"></div>
        
        <div class="container mx-auto px-4 md:px-6 relative z-20">
            <div class="text-center mb-12 md:mb-24 scroll-animate">
                <div class="flex items-center justify-center gap-4 mb-4">
                    <div class="h-px w-0 bg-navy/20 transition-all duration-1000 ease-out expand-line"></div>
                    <span class="font-sans text-navy/60 text-xs font-bold tracking-[0.2em] uppercase transition-opacity duration-1000 delay-300 fade-in">Visual Diary</span>
                    <div class="h-px w-0 bg-navy/20 transition-all duration-1000 ease-out expand-line"></div>
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-6xl text-navy font-cinzel mb-6 drop-shadow-sm transition-all duration-1000 delay-500 slide-up">The Vault Life</h2>
                <p class="font-sans text-navy/70 max-w-2xl mx-auto text-sm md:text-lg leading-relaxed transition-all duration-1000 delay-700 slide-up px-4">
                    Moments of elegance woven together by a legacy of craftsmanship.
                </p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 lg:gap-10">
                <?php
                $counter = 0;
                
                if (!empty($gallery_images)) {
                    while($counter < count($gallery_images)):
                        $img = $gallery_images[$counter];
                        $counter++;
                        // Stagger every even item down for visual flow
                        $staggerClass = ($counter % 2 == 0) ? 'md:mt-16' : ''; 
                        // Calculate animation delay based on position
                        $delay = $counter * 150;
                ?>
                <div class="gallery-item group relative aspect-[3/4] overflow-hidden rounded-sm shadow-2xl bg-white <?php echo $staggerClass; ?> transition-all duration-700 hover:-translate-y-4 hover:shadow-[0_20px_50px_rgba(0,0,0,0.2)] border border-navy/5 cursor-pointer transition-all duration-1000 scroll-item" style="transition-delay: <?php echo $delay; ?>ms;" data-image="<?php echo htmlspecialchars($img['image_url']); ?>">
                    
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-px h-8 bg-navy/20 z-20 transition-all duration-500 group-hover:h-full group-hover:bg-gold/50"></div>

                    <img src="<?php echo htmlspecialchars($img['image_url']); ?>" 
                         alt="Gallery Image" 
                         class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-110 grayscale-[20%] group-hover:grayscale-0">
                    
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-shine z-10 pointer-events-none"></div>

                    <div class="absolute inset-0 bg-gradient-to-t from-navy/95 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-4 md:p-6 z-20">
                        <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-100 text-center">
                            <div class="w-8 h-px bg-gold mx-auto mb-3"></div>
                            <span class="text-white text-[10px] uppercase tracking-[0.2em] font-sans">Grafton Vault</span>
                        </div>
                    </div>
                    
                    <div class="absolute top-2 right-2 w-4 h-4 border-t border-r border-gold/0 group-hover:border-gold transition-colors duration-500 delay-100 z-20"></div>
                    <div class="absolute bottom-2 left-2 w-4 h-4 border-b border-l border-gold/0 group-hover:border-gold transition-colors duration-500 delay-100 z-20"></div>
                </div>
                <?php 
                    endwhile;
                } else {
                    echo '<div class="col-span-4 text-center py-20"><p class="text-navy/60">No gallery images found.</p></div>';
                }
                ?>
            </div>
            
            <div class="text-center mt-12 md:mt-32 scroll-animate">
                <a href="full_gallery.php" class="group relative inline-flex items-center justify-center px-8 md:px-12 py-4 md:py-5 bg-navy text-white font-sans text-xs font-bold uppercase tracking-[0.3em] rounded-full overflow-hidden transition-all duration-500 hover:bg-gold hover:shadow-[0_10px_25px_rgba(178,146,67,0.3)] hover:-translate-y-1 transform">
                    <span class="absolute inset-0 bg-gradient-to-r from-gold to-lightGold opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                    
                    <span class="absolute inset-0 rounded-full border-2 border-gold/0 group-hover:border-gold/30 transition-all duration-500"></span>
                    
                    <span class="relative flex items-center gap-3 z-10">
                        <span>Explore Full Gallery</span>
                        <i class="fas fa-arrow-right transition-transform duration-300 group-hover:translate-x-1"></i>
                    </span>
                    
                    <span class="absolute inset-0 -top-full h-full w-full bg-gradient-to-b from-transparent via-white/20 to-transparent group-hover:top-full transition-all duration-1000 ease-in-out"></span>
                </a>
            </div>
        </div>
        
        <div id="imageModal" class="fixed inset-0 z-[2005] flex items-center justify-center p-4 opacity-0 invisible transition-all duration-300">
            <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" id="modalBackdrop"></div>
            <div class="relative max-w-5xl max-h-[90vh] w-full h-auto transform scale-95 transition-transform duration-300" id="modalContent">
                <button id="closeModal" class="absolute -top-12 right-0 text-white/80 hover:text-white transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <img id="modalImage" src="" alt="Full Size Gallery Image" class="w-full h-full object-contain">
                <div class="absolute bottom-0 left-0 right-0 p-6 text-center">
                    <div class="inline-block">
                        <div class="w-8 h-px bg-gold mx-auto mb-3"></div>
                        <span class="text-white text-xs uppercase tracking-[0.2em] font-sans">Grafton Vault</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Thread Drawing Animation Logic */
        .draw-line, .draw-line-delayed {
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000; /* Start hidden */
            transition: stroke-dashoffset 2.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* When the section is active, draw the line */
        .reveal-active .draw-line {
            stroke-dashoffset: 0;
        }
        
        /* Secondary line draws slightly later */
        .reveal-active .draw-line-delayed {
            stroke-dashoffset: 0;
            transition-delay: 0.5s;
        }

        /* Shine Animation */
        @keyframes shine {
            100% { transform: translateX(100%); }
        }
        .animate-shine {
            animation: shine 0.75s;
        }

        /* Floating Particles */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .animate-float-slow { animation: float 8s ease-in-out infinite; }
        .animate-float-medium { animation: float 6s ease-in-out infinite; }
        .animate-float-fast { animation: float 4s ease-in-out infinite; }

        /* Scroll Reveal Initial States - Ensuring these exist */
        .expand-line { width: 0; }
        .fade-in { opacity: 0; }
        .slide-up { opacity: 0; transform: translateY(2rem); }
        .scroll-item { opacity: 0; transform: translateY(3rem); }
        .fade-in-up { opacity: 0; transform: translateY(1rem); }

        /* Active State Classes (Applied via JS) */
        .reveal-active .expand-line { width: 4rem; } 
        .reveal-active .fade-in { opacity: 1; }
        .reveal-active .slide-up { opacity: 1; transform: translateY(0); }
        .reveal-active.scroll-item { opacity: 1; transform: translateY(0); }
        .reveal-active .fade-in-up { opacity: 1; transform: translateY(0); }
        
        /* Modal Styles */
        #imageModal.active {
            opacity: 1;
            visibility: visible;
        }
        
        #imageModal.active #modalContent {
            transform: scale(1);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15 
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal-active');
                    }
                });
            }, observerOptions);

            // FIX: Added .scroll-animate to the selector so the text section is observed
            const revealElements = document.querySelectorAll('.scroll-animate, .scroll-reveal, .scroll-item, .scroll-draw-svg');
            revealElements.forEach(el => observer.observe(el));
            
            // Parallax Effect
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const parallaxBg = document.querySelector('.parallax-bg');
                if(parallaxBg) {
                    const speed = parallaxBg.dataset.speed;
                    parallaxBg.style.transform = `translateY(${scrolled * speed}px)`;
                }
            });
            
            // Image Modal Functionality
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const modalBackdrop = document.getElementById('modalBackdrop');
            const closeModalBtn = document.getElementById('closeModal');
            const galleryItems = document.querySelectorAll('.gallery-item');
            
            // Open modal when gallery item is clicked
            galleryItems.forEach(item => {
                item.addEventListener('click', () => {
                    const imageUrl = item.getAttribute('data-image');
                    modalImage.src = imageUrl;
                    modal.classList.add('active');
                    document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
                });
            });
            
            // Close modal functions
            function closeModal() {
                modal.classList.remove('active');
                document.body.style.overflow = ''; // Restore scrolling
            }
            
            closeModalBtn.addEventListener('click', closeModal);
            modalBackdrop.addEventListener('click', closeModal);
            
            // Close modal with Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && modal.classList.contains('active')) {
                    closeModal();
                }
            });
        });
    </script>

        <section id="journal" class="py-20 md:py-28 bg-cream relative overflow-hidden">
        <div class="absolute inset-0 bg-diamond-pattern opacity-5 pointer-events-none"></div>
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full text-center pointer-events-none overflow-hidden select-none">
            <span class="block text-[10vw] md:text-[14vw] font-cinzel font-bold text-navy/[0.03] md:text-navy/5 whitespace-nowrap parallax-text leading-none transition-transform duration-75 ease-linear" 
                  data-speed="0.08" style="will-change: transform;">
                INSIGHT & STORIES
            </span>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 reveal">
                <div class="text-center md:text-left w-full md:w-auto">
                    <div class="flex items-center gap-4 mb-2 justify-center md:justify-start">
                        <div class="h-px w-8 md:w-12 bg-gold"></div>
                        <span class="font-sans text-gold text-[10px] md:text-xs font-bold tracking-[0.2em] uppercase">The Journal</span>
                    </div>
                    <h2 class="text-3xl md:text-5xl text-navy font-cinzel">Stories & Insight</h2>
                </div>
                
                <div class="hidden md:flex items-center gap-4">
                    <button onclick="scrollJournal(-1)" class="w-12 h-12 border border-navy/10 flex items-center justify-center hover:bg-navy hover:text-white transition-all duration-300 group rounded-full">
                        <i class="fas fa-chevron-left text-xs group-hover:-translate-x-1 transition-transform"></i>
                    </button>
                    <button onclick="scrollJournal(1)" class="w-12 h-12 border border-navy/10 flex items-center justify-center hover:bg-navy hover:text-white transition-all duration-300 group rounded-full">
                        <i class="fas fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </div>

            <div class="relative group/carousel">
                <div id="journal-scroll" class="flex flex-col md:flex-row gap-6 md:gap-8 overflow-x-auto pb-12 snap-x snap-mandatory no-scrollbar scroll-smooth px-1">
                    <?php
                    $blog_sql = "SELECT * FROM blog_posts ORDER BY created_at DESC LIMIT 6";
                    $blogs = $conn->query($blog_sql);
                    $counter = 0;
                    
                    while($b = $blogs->fetch_assoc()):
                        $counter++;
                        $is_new = (strtotime($b['created_at']) > strtotime('-7 days'));
                        $mobile_class = ($counter > 3) ? 'hidden md:flex' : 'flex';
                    ?>
                    
                    <div class="<?php echo $mobile_class; ?> flex-col min-w-full md:min-w-[24rem] md:h-[24rem] md:aspect-square snap-center">
                        
                        <a href="blog_info.php?item=<?php echo $b['id']; ?>" class="group block h-full w-full bg-white shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-navy/5 flex flex-col rounded-sm relative overflow-hidden">
                            
                            <?php if($is_new): ?>
                            <div class="absolute top-4 right-4 z-30 bg-gold text-white text-[9px] font-bold uppercase tracking-widest px-3 py-1 shadow-md animate-pulse-slow">
                                New
                            </div>
                            <?php endif; ?>

                            <div class="h-52 md:h-[60%] overflow-hidden relative shrink-0">
                                <img src="<?php echo htmlspecialchars($b['cover_image']); ?>" 
                                     alt="<?php echo htmlspecialchars($b['title']); ?>"
                                     class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-navy/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                
                                <div class="absolute bottom-0 left-0 bg-white/95 px-5 py-3 border-tr-sm">
                                    <span class="text-navy font-cinzel font-bold text-lg leading-none">
                                        <?php echo date('d', strtotime($b['created_at'])); ?>
                                    </span>
                                    <span class="text-gold text-[9px] uppercase font-bold tracking-widest ml-1">
                                        <?php echo date('M', strtotime($b['created_at'])); ?>
                                    </span>
                                </div>
                            </div>

                            <div class="p-6 md:p-8 flex flex-col flex-grow relative bg-white justify-between">
                                <div>
                                    <span class="text-[9px] font-sans font-bold uppercase tracking-[0.2em] text-gold mb-3 block">Editorial</span>
                                    
                                    <h3 class="text-xl md:text-2xl font-cinzel text-navy leading-tight group-hover:text-gold transition-colors duration-300 line-clamp-2 mb-3">
                                        <?php echo htmlspecialchars($b['title']); ?>
                                    </h3>
                                    
                                    <p class="text-navy/60 font-sans text-xs leading-relaxed line-clamp-2 hidden md:block">
                                        <?php echo htmlspecialchars($b['subtitle']); ?>
                                    </p>
                                </div>
                                
                                <div class="pt-4 border-t border-navy/5 flex justify-between items-center mt-auto">
                                    <span class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-navy group-hover:text-gold transition-colors duration-300">
                                        Read Story
                                    </span>
                                    <div class="w-8 h-8 rounded-full border border-navy/10 flex items-center justify-center text-navy/40 group-hover:bg-navy group-hover:text-white transition-all duration-300">
                                        <i class="fas fa-arrow-right text-[10px]"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endwhile; ?>

                    <div class="hidden md:flex flex-col min-w-[24rem] h-[24rem] snap-center">
                        <a href="blogs.php" class="group block h-full w-full bg-navy shadow-lg hover:shadow-2xl transition-all duration-500 border border-gold/10 flex flex-col items-center justify-center text-center p-8 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-gold/10 to-transparent opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
                            <div class="absolute -right-10 -bottom-10 text-white/5 text-[10rem] font-serif">
                                <i class="fas fa-book-open"></i>
                            </div>

                            <span class="font-cinzel text-3xl text-white mb-3 relative z-10 group-hover:scale-110 transition-transform duration-500">View All</span>
                            <span class="font-sans text-gold text-xs tracking-[0.3em] uppercase mb-8 relative z-10">The Journal</span>
                            
                            <div class="w-14 h-14 rounded-full border border-gold/30 flex items-center justify-center text-gold group-hover:bg-gold group-hover:text-navy transition-all duration-300 relative z-10">
                                <i class="fas fa-arrow-right text-lg"></i>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
            
            <div class="text-center mt-8 md:hidden reveal">
                <a href="blogs.php" class="inline-block bg-navy text-white px-10 py-4 font-sans text-xs font-bold uppercase tracking-widest shadow-lg hover:bg-gold transition-colors w-full sm:w-auto">
                    View All Stories
                </a>
            </div>
        </div>
    </section>

    <script>
        // Parallax Text
        document.addEventListener('scroll', () => {
            const scroll = window.pageYOffset;
            const text = document.querySelector('.parallax-text');
            if(text) {
                const speed = text.dataset.speed;
                text.style.transform = `translate3d(${scroll * speed * -1}px, 0, 0)`;
            }
        });

        // Horizontal Scroll Logic
        function scrollJournal(direction) {
            const container = document.getElementById('journal-scroll');
            // Card width (24rem = 384px) + Gap (8 = 32px) = 416px
            const scrollAmount = 416; 
            
            container.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>

    <script>
        // Parallax Text
        document.addEventListener('scroll', () => {
            const scroll = window.pageYOffset;
            const text = document.querySelector('.parallax-text');
            if(text) {
                const speed = text.dataset.speed;
                text.style.transform = `translate3d(${scroll * speed * -1}px, 0, 0)`;
            }
        });

        // Horizontal Scroll Logic
        function scrollJournal(direction) {
            const container = document.getElementById('journal-scroll');
            // Card width + Gap
            const scrollAmount = window.innerWidth < 768 ? 320 : 416; 
            
            container.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
        
        // Mobile navigation scroll
        function scrollNav(direction) {
            const navContainer = document.querySelector('.nav-scroll-wrapper');
            if (navContainer) {
                const scrollAmount = 200;
                navContainer.scrollBy({
                    left: direction === 'left' ? -scrollAmount : scrollAmount,
                    behavior: 'smooth'
                });
            }
        }
        
        // Update scroll indicators
        function updateNavScrollIndicator() {
            const navContainer = document.querySelector('.nav-scroll-wrapper');
            const indicator = document.querySelector('.scroll-indicator');
            
            if (navContainer && indicator) {
                const scrollWidth = navContainer.scrollWidth;
                const clientWidth = navContainer.clientWidth;
                const scrollLeft = navContainer.scrollLeft;
                const maxScroll = scrollWidth - clientWidth;
                
                if (maxScroll > 0) {
                    const scrollPercentage = (scrollLeft / maxScroll) * 100;
                    indicator.style.width = (clientWidth / scrollWidth * 100) + '%';
                    indicator.style.transform = `translateX(${scrollPercentage}%)`;
                    indicator.style.opacity = '1';
                } else {
                    indicator.style.opacity = '0';
                }
            }
        }
        
        // Initialize scroll indicator
        document.addEventListener('DOMContentLoaded', () => {
            const navContainer = document.querySelector('.nav-scroll-wrapper');
            if (navContainer) {
                navContainer.addEventListener('scroll', updateNavScrollIndicator);
                // Initial update
                setTimeout(updateNavScrollIndicator, 100);
            }
        });
    </script>

<section id="instagram" class="py-12 md:py-16 lg:py-24 relative overflow-hidden bg-navy">
        <div class="absolute inset-0 bg-navy-gradient z-0"></div>
        <div class="absolute inset-0 bg-diamond-pattern opacity-5 z-0"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] md:w-[500px] md:h-[500px] lg:w-[800px] lg:h-[800px] bg-gold/5 rounded-full blur-[60px] md:blur-[80px] lg:blur-[120px] pointer-events-none z-0"></div>
        
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="mb-8 md:mb-12 lg:mb-16 text-center scroll-animate">
                <i class="fab fa-instagram text-xl md:text-2xl lg:text-3xl text-gold mb-4 inline-block floating-element"></i>
                <h2 class="text-xl md:text-3xl lg:text-5xl font-cinzel text-white mb-2 tracking-wide">@TheGraftonVault</h2>
                <div class="w-12 h-px bg-gold mx-auto my-4 opacity-50"></div>
                <p class="text-cream/60 text-xs md:text-sm font-sans max-w-lg mx-auto tracking-widest uppercase px-4">Curated moments of brilliance</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto mb-8 md:mb-12 lg:mb-16">
                <?php
                // Fetch Latest 3 Posts
                $insta_sql = "SELECT * FROM instagram_posts ORDER BY created_at DESC LIMIT 3";
                $insta = $conn->query($insta_sql);
                
                // Check if any posts exist
                if($insta->num_rows > 0):
                    $counter = 0;
                    while($p = $insta->fetch_assoc()):
                        $counter++;
                        $link = $p['post_url'] ?? '#'; 
                ?>
                <a href="<?php echo htmlspecialchars($link); ?>" target="_blank" class="group block relative h-48 sm:h-64 md:h-[300px] lg:h-[400px] overflow-hidden rounded-sm border border-white/10 shadow-2xl scroll-animate delay-<?php echo $counter; ?> bg-navy mx-auto w-full max-w-sm md:max-w-none">
                    <img src="<?php echo htmlspecialchars($p['image_url']); ?>" 
                         alt="Instagram Post"
                         class="w-full h-full object-cover transition-transform duration-1000 transform group-hover:scale-110 opacity-90 group-hover:opacity-100">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/95 via-navy/40 to-transparent flex flex-col justify-end p-4 md:p-6 lg:p-8 text-left transition-all duration-500">
                        <div class="transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                            <div class="flex items-center gap-2 mb-2 md:mb-3 text-gold">
                                <i class="fab fa-instagram text-xs"></i>
                                <span class="text-[8px] md:text-[10px] uppercase tracking-widest font-bold">Latest Post</span>
                            </div>
                            <?php if(!empty($p['caption'])): ?>
                                <p class="text-[10px] md:text-xs text-white/80 font-sans leading-relaxed line-clamp-2 md:line-clamp-3 font-light mb-3 md:mb-4">
                                    <?php echo htmlspecialchars(substr($p['caption'], 0, 100)); ?>...
                                </p>
                            <?php endif; ?>
                            <span class="text-white text-[9px] md:text-[10px] uppercase tracking-widest border-b border-gold/50 pb-1 group-hover:border-gold transition-colors">
                                View on Instagram
                            </span>
                        </div>
                    </div>
                </a>
                <?php 
                    endwhile; 
                else:
                ?>
                    <div class="col-span-full text-center py-10 border border-dashed border-white/10 rounded-sm">
                        <p class="text-white/40 font-serif text-sm">Follow us on Instagram for updates.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="text-center scroll-animate">
                <a href="instagram_posts.php" class="inline-flex flex-col items-center group">
                    <span class="font-cinzel text-gold text-sm md:text-lg tracking-widest mb-2 group-hover:text-white transition-colors">View Full Gallery</span>
                    <div class="flex items-center gap-2">
                        <div class="h-px w-4 md:w-6 lg:w-8 bg-gold/50 transition-all duration-300 group-hover:w-6 md:group-hover:w-8 lg:group-hover:w-12 group-hover:bg-gold"></div>
                        <div class="w-1.5 h-1.5 md:w-2 md:h-2 rotate-45 bg-gold group-hover:animate-pulse"></div>
                        <div class="h-px w-4 md:w-6 lg:w-8 bg-gold/50 transition-all duration-300 group-hover:w-6 md:group-hover:w-8 lg:group-hover:w-12 group-hover:bg-gold"></div>
                    </div>
                </a>
            </div>
        </div>
    </section>





<!-- Calendly badge widget begin -->
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">

<script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>

<script type="text/javascript">
  window.onload = function () {
    Calendly.initBadgeWidget({
      url: 'https://calendly.com/thegraftonvault?background_color=f7f0e3&text_color=0a1a33&primary_color=b29243',
      text: '',
      color: '#f7f0e3',
      textColor: '#b29243',
      branding: false
    });
  };
</script>

<style>
  /* Layering */
  .calendly-badge-widget {
    z-index: 40 !important;
  }

  /* ===== Premium hint text ===== */
  .calendly-badge-widget::before {
    content: "Schedule";
    position: absolute;
    bottom: 56px;
    right: 6px;

    font-size: 9px;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    font-weight: 400;

    color: #b29243;
    opacity: 0;

    animation: hintFade 6s ease forwards;
    pointer-events: none;
  }

  @keyframes hintFade {
    0%   { opacity: 0; }
    20%  { opacity: 0.75; }
    70%  { opacity: 0.75; }
    100% { opacity: 0; }
  }

  /* ===== Icon-only badge ===== */
  .calendly-badge-content {
    width: 44px !important;
    height: 44px !important;
    min-width: 44px !important;
    min-height: 44px !important;

    border-radius: 50% !important;
    padding: 0 !important;

    display: flex !important;
    align-items: center;
    justify-content: center;

    background: white !important;
    border: 2px solid black;
    box-shadow: 0 6px 18px rgba(0,0,0,0.35);

    font-size: 0 !important;
    transition: all 0.25s ease;
  }

  /* Remove text */
  .calendly-badge-content span {
    display: none !important;
  }

  /* Calendly icon */
  .calendly-badge-content::after {
    content: "";
    width: 17px;
    height: 17px;
    background: url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTktU8TSdEWm9FlT_6o2wXBZJy7SiODCf251Q&s")
      no-repeat center / contain;
  }

  /* Calm luxury hover */
  .calendly-badge-content:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 26px rgba(0,0,0,0.45);
  }

  /* Mobile */
  @media (max-width: 640px) {
    .calendly-badge-content {
      width: 40px !important;
      height: 40px !important;
    }

    .calendly-badge-widget::before {
      font-size: 8px;
      bottom: 50px;
    }
  }
</style>
<!-- Calendly badge widget end -->







    <section id="reviews" class="py-12 md:py-16 lg:py-24 bg-gradient-to-b from-white to-cream/30 relative overflow-hidden">
    <!-- Background decorations -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-gradient-to-br from-gold/10 to-transparent rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-navy/5 to-transparent rounded-full blur-3xl"></div>
    
    <div class="container mx-auto px-4 md:px-6 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-8 md:mb-12 scroll-animate">
            <div class="inline-flex items-center gap-2 bg-navy/5 px-4 py-2 rounded-full mb-4">
                <i class="fas fa-award text-gold text-sm"></i>
                <span class="text-xs font-semibold text-navy/80 uppercase tracking-wider">Client Testimonials</span>
            </div>
            <h2 class="text-2xl md:text-3xl lg:text-5xl mb-4 text-navy font-cinzel">What Our Clients Say</h2>
            <div class="flex justify-center items-center gap-2 mb-6">
                <div class="flex items-center gap-1">
                    <i class="fas fa-star text-gold text-lg"></i>
                    <i class="fas fa-star text-gold text-lg"></i>
                    <i class="fas fa-star text-gold text-lg"></i>
                    <i class="fas fa-star text-gold text-lg"></i>
                    <i class="fas fa-star text-gold text-lg"></i>
                </div>
                <span class="text-sm font-medium text-navy/70">4.9 out of 5</span>
            </div>
            <p class="font-sans text-navy/60 max-w-2xl mx-auto px-4">Real experiences from valued clients who have trusted Grafton Vault with their precious memories</p>
        </div>
        
        <!-- Reviews Container -->
        <div class="relative">
            <!-- Left Scroll Button (Mobile Only) -->
            <button id="scroll-left" class="absolute left-0 top-1/2 -translate-y-1/2 z-20 bg-white/95 backdrop-blur-sm rounded-full w-10 h-10 md:w-11 md:h-11 flex items-center justify-center shadow-xl text-navy md:hidden border border-gold/20">
                <i class="fas fa-chevron-left text-sm"></i>
            </button>
            
            <!-- Right Scroll Button (Mobile Only) -->
            <button id="scroll-right" class="absolute right-0 top-1/2 -translate-y-1/2 z-20 bg-white/95 backdrop-blur-sm rounded-full w-10 h-10 md:w-11 md:h-11 flex items-center justify-center shadow-xl text-navy md:hidden border border-gold/20">
                <i class="fas fa-chevron-right text-sm"></i>
            </button>
            
            <!-- Reviews Scrollable Container -->
            <div id="reviews-container" class="flex gap-4 overflow-x-auto pb-6 px-2 md:px-0 md:grid md:grid-cols-2 lg:grid-cols-4 md:gap-6 scroll-smooth no-scrollbar">
                <?php
                $rev_sql = "SELECT * FROM reviews ORDER BY id DESC LIMIT 8";
                $rev_result = $conn->query($rev_sql);
                $counter = 0;
                while($rev = $rev_result->fetch_assoc()):
                    $counter++;
                ?>
                <div class="min-w-[280px] md:min-w-0 group relative scroll-animate delay-<?php echo $counter; ?>">
                    <!-- Card Background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-gold/5 to-navy/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <!-- Main Card -->
                    <div class="relative bg-white p-4 md:p-6 rounded-2xl shadow-sm border border-gold/10 hover:shadow-2xl transition-all duration-500 hover:-translate-y-1">
                        <!-- Quote Icon -->
                        <div class="absolute -top-3 -right-3 w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-gold to-lightGold rounded-full flex items-center justify-center shadow-lg opacity-20">
                            <i class="fas fa-quote-right text-white text-base md:text-lg"></i>
                        </div>
                        
                        <!-- Review Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-gradient-to-br from-gold to-lightGold flex items-center justify-center text-white font-bold text-base md:text-lg shadow-lg">
                                        <?php echo strtoupper(substr($rev['reviewer_name'], 0, 1)); ?>
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 md:w-5 md:h-5 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-sans text-sm font-bold text-navy"><?php echo htmlspecialchars($rev['reviewer_name']); ?></div>
                                    <div class="flex items-center gap-1 mt-1">
                                        <?php for($i=0; $i<5; $i++): ?>
                                        <i class="fas fa-star text-gold text-xs"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Review Content -->
                        <div class="text-navy/80 text-sm leading-relaxed mb-4">
                            <p class="line-clamp-4 font-serif italic">"<?php echo htmlspecialchars($rev['review_text']); ?>"</p>
                        </div>
                        
                        <!-- Review Footer -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-shield-alt text-gold/50 text-xs"></i>
                                <span class="text-xs text-gray-500 font-medium">Verified Purchase</span>
                            </div>
                            <div class="text-xs text-navy/40">
                                <?php 
                                if(isset($rev['review_date'])) {
                                    echo date('M Y', strtotime($rev['review_date']));
                                } else {
                                    echo "Recently";
                                }
                                ?>
                            </div>
                        </div>
                        
                        <!-- Hover Effect Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-navy/5 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
        
        <!-- Read All Reviews Button -->
        <div class="text-center mt-8 scroll-animate">
            <a href="overall_rating.php" 
               class="group relative inline-flex items-center gap-2 px-5 py-2.5 
                      bg-gradient-to-r from-navy to-navy/90 text-white text-sm font-medium 
                      rounded-full hover:from-gold hover:to-lightGold hover:text-navy 
                      transition-all duration-300 shadow-md hover:shadow-lg hover:scale-105">
                
                <span class="relative z-10">View All Testimonials</span>
                
                <i class="fas fa-arrow-right text-xs relative z-10 
                          group-hover:translate-x-0.5 transition-transform"></i>
                
                <div class="absolute inset-0 bg-gradient-to-r from-gold to-lightGold 
                            rounded-full opacity-0 group-hover:opacity-100 
                            transition-opacity duration-300"></div>
            </a>
        </div>
    </div>
    
    <style>
        /* Hide scrollbar but keep functionality */
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        
        /* Line clamp utility */
        .line-clamp-4 {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Smooth reveal animation */
        .scroll-animate {
            opacity: 0;
            transform: translateY(20px);
            animation: reveal 0.8s ease forwards;
        }
        
        @keyframes reveal {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reviewsContainer = document.getElementById('reviews-container');
            const scrollLeftBtn = document.getElementById('scroll-left');
            const scrollRightBtn = document.getElementById('scroll-right');
            
            // Check if we're on mobile
            const isMobile = window.innerWidth < 768;
            
            if (isMobile && reviewsContainer && scrollLeftBtn && scrollRightBtn) {
                // Scroll left
                scrollLeftBtn.addEventListener('click', function() {
                    reviewsContainer.scrollBy({
                        left: -280,
                        behavior: 'smooth'
                    });
                });
                
                // Scroll right
                scrollRightBtn.addEventListener('click', function() {
                    reviewsContainer.scrollBy({
                        left: 280,
                        behavior: 'smooth'
                    });
                });
                
                // Update button visibility based on scroll position
                function updateButtonVisibility() {
                    if (reviewsContainer.scrollLeft <= 10) {
                        scrollLeftBtn.style.opacity = '0.3';
                        scrollLeftBtn.style.pointerEvents = 'none';
                    } else {
                        scrollLeftBtn.style.opacity = '1';
                        scrollLeftBtn.style.pointerEvents = 'auto';
                    }
                    
                    if (reviewsContainer.scrollLeft >= reviewsContainer.scrollWidth - reviewsContainer.clientWidth - 10) {
                        scrollRightBtn.style.opacity = '0.3';
                        scrollRightBtn.style.pointerEvents = 'none';
                    } else {
                        scrollRightBtn.style.opacity = '1';
                        scrollRightBtn.style.pointerEvents = 'auto';
                    }
                }
                
                // Initial check
                updateButtonVisibility();
                
                // Update on scroll
                reviewsContainer.addEventListener('scroll', updateButtonVisibility);
            }
        });
    </script>
</section>

<section class="py-12 md:py-20 bg-cream relative">
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-3/4 h-px bg-gradient-to-r from-transparent via-gold/20 to-transparent"></div>
    
    <div class="container mx-auto px-4 md:px-6 max-w-3xl">
        <div class="text-center mb-8 md:mb-12 scroll-animate">
            <span class="font-sans text-gold text-[10px] md:text-xs font-bold tracking-[0.2em] uppercase">Help & Support</span>
            
            <h2 class="text-2xl md:text-3xl font-cinzel text-navy mt-2">Client Enquiries</h2>
            
            <p class="font-sans text-navy/60 mt-4 max-w-lg mx-auto text-sm md:text-base px-4">
                Thoughtfully prepared answers to common questions regarding our services and procedures.
            </p>
        </div>
        
        <div class="space-y-3 md:space-y-4">
            <?php
            // 1. Get Total Count to decide if button is needed
            $count_sql = "SELECT COUNT(*) as total FROM faqs";
            $count_res = $conn->query($count_sql);
            $total_faqs = $count_res->fetch_assoc()['total'];

            // 2. Fetch Only Top 8
            $f_sql = "SELECT * FROM faqs ORDER BY id DESC LIMIT 8";
            $f_res = $conn->query($f_sql);
            
            if ($f_res->num_rows > 0):
                $counter = 0;
                while($f = $f_res->fetch_assoc()):
                    $counter++;
            ?>
            <div class="bg-white border border-gray-100 rounded-lg overflow-hidden group hover:shadow-md transition-all duration-300 scroll-animate delay-<?php echo $counter; ?>">
                <button class="w-full text-left p-4 md:p-6 flex justify-between items-center focus:outline-none hover:bg-cream/30 transition-colors" onclick="this.parentElement.classList.toggle('active')">
                    <span class="font-bold text-navy text-xs md:text-sm uppercase tracking-wider flex items-center gap-3">
                        <div class="diamond-shape hidden sm:block"></div>
                        <?php echo htmlspecialchars($f['question']); ?>
                    </span>
                    <i class="fas fa-chevron-down text-gold text-xs md:text-sm transform transition-transform duration-300 faq-icon"></i>
                </button>
                <div class="faq-answer px-4 md:px-6 text-gray-600 text-xs md:text-sm leading-relaxed border-t border-gray-50 bg-gray-50/50">
                    <div class="pt-4 pb-6"><?php echo nl2br(htmlspecialchars($f['answer'])); ?></div>
                </div>
            </div>
            <?php 
                endwhile; 
            endif;
            ?>
        </div>

        <?php if($total_faqs > 8): ?>
        <div class="text-center mt-8 md:mt-12 scroll-animate">
            <a href="help_support_qna.php" class="group inline-flex items-center gap-3 border border-navy px-6 md:px-8 py-3 font-sans text-xs font-bold uppercase tracking-widest text-navy hover:bg-navy hover:text-white transition-all duration-300 rounded-sm">
                View All Questions
                <i class="fas fa-arrow-right text-gold group-hover:text-white transition-colors"></i>
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>
    
<section id="consultation" class="py-20 md:py-24 bg-navy relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-gold/30 to-transparent"></div>
    <div class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-gold/30 to-transparent"></div>

    <div class="container mx-auto px-4 relative z-10 text-center">
        <div class="mb-6 flex justify-center">
            <i class="fas fa-globe-europe text-gold text-2xl opacity-80"></i>
        </div>

        <span class="text-gold text-[10px] font-sans tracking-[0.3em] uppercase block mb-4">
            Ireland-Wide Access
        </span>

        <h2 class="text-3xl md:text-4xl font-cinzel text-white mb-6 tracking-wide">
            Ireland-Wide Virtual Consultation
        </h2>

        <p class="text-cream/80 font-sans text-sm md:text-base tracking-wide font-light max-w-2xl mx-auto mb-10 leading-relaxed">
            Access our bespoke consultation service from anywhere in Ireland. Book a private video appointment with our in-house experts to discuss your requirements securely and comfortably.
        </p>

        <a href="https://calendly.com/thegraftonvault?background_color=f7f0e3&text_color=0a1a33&primary_color=b29243" 
           target="_blank" 
           class="group inline-flex items-center gap-4 px-10 py-4 bg-transparent border border-gold/40 text-gold text-xs font-bold uppercase tracking-[0.2em] hover:bg-gold hover:text-navy transition-all duration-300">
            Book an Online Appointment
            <i class="fas fa-arrow-right transition-transform duration-300 group-hover:translate-x-1"></i>
        </a>
    </div>
</section>


<section id="contact" class="py-12 md:py-24 relative overflow-hidden bg-cream">
    <div class="absolute inset-0 bg-diamond-pattern opacity-5 pointer-events-none"></div>
    
    <div class="absolute top-0 right-0 w-[300px] h-[300px] md:w-[600px] md:h-[600px] bg-gold/5 rounded-full blur-[60px] md:blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[300px] h-[300px] md:w-[600px] md:h-[600px] bg-navy/5 rounded-full blur-[60px] md:blur-[100px] pointer-events-none"></div>

    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-gold/40 to-transparent"></div>

    <div class="container mx-auto px-4 md:px-6 relative z-10 max-w-7xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 md:gap-16 lg:gap-24 items-start">
            
            <div class="lg:col-span-5 pt-4 text-center lg:text-left scroll-animate">
                <span class="font-sans text-gold text-[10px] font-bold tracking-[0.3em] uppercase block mb-6">Concierge Service</span>
                <h2 class="text-3xl md:text-4xl lg:text-6xl text-navy mb-6 md:mb-8 font-cinzel leading-tight">Private <br><span class="italic text-gold">Consultation</span></h2>
                
                <p class="font-sans text-navy/70 text-base leading-loose mb-8">
                    Your time is the ultimate luxury. Schedule a bespoke appointment to discuss your unique requirements. Our specialists are at your disposal to ensure a seamless experience.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 text-left md:text-left">
                    
                    <div>
                        <h4 class="font-cinzel text-navy text-sm font-bold mb-2">Address</h4>
                        <p class="font-sans text-navy/70 text-xs leading-relaxed">
                            First Floor<br>
                            24 Grafton Street<br>
                            Dublin 2
                        </p>
                    </div>

                    <div>
                        <h4 class="font-cinzel text-navy text-sm font-bold mb-2">Opening Hours</h4>
                        <p class="font-sans text-navy/70 text-xs leading-relaxed">
                            Mon - Sun<br>
                            10 am to 4:30 pm
                        </p>
                    </div>

                    <div class="md:col-span-2">
                        <h4 class="font-cinzel text-navy text-sm font-bold mb-2">Contact</h4>
                        <p class="font-sans text-navy/70 text-xs leading-relaxed flex flex-col gap-1">
                            <span><span class="text-gold w-4 inline-block"><i class="fas fa-envelope"></i></span> info@thegraftonvault.com</span>
                            <span><span class="text-gold w-4 inline-block"><i class="fas fa-phone"></i></span> +353 XXXXXX</span>
                        </p>
                    </div>
                </div>

                <div class="flex justify-center lg:justify-start">
                    <a href="https://calendly.com/thegraftonvault?background_color=f7f0e3&text_color=0a1a33&primary_color=b29243" 
                       target="_blank" 
                       class="group inline-flex items-center gap-3 px-8 py-3 bg-navy text-white font-sans text-xs font-bold uppercase tracking-widest hover:bg-gold hover:text-navy transition-all duration-300 shadow-lg">
                        Book Virtual Meet
                        <i class="fas fa-video transition-transform duration-300 group-hover:scale-110"></i>
                    </a>
                </div>
            </div>

            <div class="hidden lg:block lg:col-span-1 flex justify-center">
                <div class="h-full min-h-[400px] w-px bg-gradient-to-b from-transparent via-gold/30 to-transparent"></div>
            </div>

            <div class="lg:col-span-6 scroll-animate">
                <form method="POST" action="submit_contact_handle.php" class="space-y-8 md:space-y-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10">
                        <div class="relative z-0 w-full group">
                            <input type="text" name="fullname" id="fullname" class="block py-3 px-0 w-full text-sm text-navy bg-transparent border-0 border-b border-navy/20 appearance-none focus:outline-none focus:ring-0 focus:border-gold peer" placeholder=" " required />
                            <label for="fullname" class="peer-focus:font-medium absolute text-sm text-navy/50 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-gold peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 font-sans uppercase tracking-wider">Full Name</label>
                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gold transition-all duration-500 group-focus-within:w-full"></div>
                        </div>

                        <div class="relative z-0 w-full group">
                            <input type="email" name="email" id="email" class="block py-3 px-0 w-full text-sm text-navy bg-transparent border-0 border-b border-navy/20 appearance-none focus:outline-none focus:ring-0 focus:border-gold peer" placeholder=" " required />
                            <label for="email" class="peer-focus:font-medium absolute text-sm text-navy/50 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-gold peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 font-sans uppercase tracking-wider">Email Address</label>
                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gold transition-all duration-500 group-focus-within:w-full"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10">
                        <div class="relative z-0 w-full group">
                            <input type="tel" name="phone" id="phone" class="block py-3 px-0 w-full text-sm text-navy bg-transparent border-0 border-b border-navy/20 appearance-none focus:outline-none focus:ring-0 focus:border-gold peer" placeholder=" " />
                            <label for="phone" class="peer-focus:font-medium absolute text-sm text-navy/50 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-gold peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 font-sans uppercase tracking-wider">Phone Number</label>
                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gold transition-all duration-500 group-focus-within:w-full"></div>
                        </div>

                        <div class="relative z-0 w-full group">
                            <select name="interest" id="interest" class="block py-3 px-0 w-full text-sm text-navy bg-transparent border-0 border-b border-navy/20 appearance-none focus:outline-none focus:ring-0 focus:border-gold peer cursor-pointer">
                                <option value="" disabled selected class="bg-cream">Select Interest</option>
                                <?php
                                $cat_res = $conn->query("SELECT title FROM collections");
                                while($cat = $cat_res->fetch_assoc()) {
                                    echo '<option value="'.$cat['title'].'" class="bg-cream">'.$cat['title'].'</option>';
                                }
                                ?>
                                <option value="Other" class="bg-cream">Other Inquiry</option>
                            </select>
                            <label for="interest" class="peer-focus:font-medium absolute text-sm text-navy/50 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-gold peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 font-sans uppercase tracking-wider">I am interested in</label>
                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gold transition-all duration-500 group-focus-within:w-full"></div>
                        </div>
                    </div>

                    <div class="relative z-0 w-full group">
                        <textarea name="message" id="message" rows="2" class="block py-3 px-0 w-full text-sm text-navy bg-transparent border-0 border-b border-navy/20 appearance-none focus:outline-none focus:ring-0 focus:border-gold peer resize-none" placeholder=" "></textarea>
                        <label for="message" class="peer-focus:font-medium absolute text-sm text-navy/50 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-gold peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 font-sans uppercase tracking-wider">Additional Details</label>
                        <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gold transition-all duration-500 group-focus-within:w-full"></div>
                    </div>

                    <div class="pt-4 md:pt-6">
                        <button type="submit" name="submit_contact" class="group relative w-full md:w-auto inline-flex items-center justify-center overflow-hidden bg-navy px-8 md:px-12 py-3 md:py-4 text-white transition-all duration-300 hover:shadow-[0_0_20px_rgba(178,146,67,0.3)]">
                            <span class="absolute h-0 w-0 rounded-full bg-gold transition-all duration-500 ease-out group-hover:h-80 group-hover:w-full opacity-20"></span>
                            <span class="relative font-sans text-xs font-bold uppercase tracking-[0.2em] z-10 flex items-center gap-3">
                                Confirm Request
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
    
    
    
<section id="location" class="relative h-[400px] md:h-[500px] lg:h-[600px] w-full overflow-hidden bg-gray-100">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=1920&q=80" 
             alt="Location Map" 
             class="w-full h-full object-cover grayscale opacity-50 contrast-125">
        <div class="absolute inset-0 bg-cream/10 mix-blend-multiply"></div>
    </div>

    <div class="absolute inset-0 flex items-center justify-center z-10 p-4">
        <div class="bg-navy p-6 md:p-8 lg:p-12 xl:p-16 text-center max-w-lg w-full shadow-2xl relative scroll-animate border border-gold/10 transform transition-transform duration-500 hover:scale-[1.01]">
            
            <div class="absolute top-3 left-3 w-6 h-6 border-t border-l border-gold/30"></div>
            <div class="absolute top-3 right-3 w-6 h-6 border-t border-r border-gold/30"></div>
            <div class="absolute bottom-3 left-3 w-6 h-6 border-b border-l border-gold/30"></div>
            <div class="absolute bottom-3 right-3 w-6 h-6 border-b border-r border-gold/30"></div>

            <span class="text-gold text-[10px] font-sans tracking-[0.3em] uppercase block mb-6">Visit Us</span>
            
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-cinzel text-white mb-6 tracking-wide">The Grafton Vault</h2>
            
            <div class="space-y-3 mb-8 md:mb-10">
                <p class="text-cream/90 font-sans text-sm tracking-wide font-light leading-relaxed">
                    First Floor<br>
                    24 Grafton Street<br>
                    Dublin 2
                </p>
            </div>

            <a href="https://maps.google.com/?q=85+Grafton+Street,+Dublin+2" target="_blank" class="group inline-flex items-center gap-3 text-white text-[10px] font-bold uppercase tracking-[0.2em] border-b border-gold/50 pb-2 hover:border-gold hover:text-gold transition-all duration-300">
                Get Directions
                <i class="fas fa-location-arrow text-gold transition-transform duration-300 group-hover:-translate-y-1 group-hover:translate-x-1"></i>
            </a>
        </div>
    </div>
</section>

    <footer class="bg-navy text-white py-8 md:py-12 border-t border-white/10 text-center relative">
        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-3/4 h-px bg-gradient-to-r from-transparent via-gold/30 to-transparent"></div>
        
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 md:gap-8 mb-6 md:mb-8">
                <a href="index.php" class="logo text-white text-xl md:text-2xl font-bold uppercase tracking-widest font-cinzel">
                    Grafton <span class="font-light">Vault</span>
                </a>
                <div class="flex gap-4 md:gap-6">
                    <a href="https://www.instagram.com/thegraftonvault/" class="text-white/60 hover:text-gold transition-colors"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/profile.php?id=61585326779674" class="text-white/60 hover:text-gold transition-colors"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://ie.pinterest.com/thegraftonvault/" class="text-white/60 hover:text-gold transition-colors"><i class="fab fa-pinterest-p"></i></a>
                    <a href="https://www.linkedin.com/company/the-grafton-vault/?viewAsMember=true" class="text-white/60 hover:text-gold transition-colors"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <p class="font-sans text-xs text-white/40 tracking-widest uppercase mt-4 md:mt-6">© 2026 The Grafton Vault. All rights reserved.</p>
        </div>
    </footer>

    <div id="service-popup" class="fixed inset-0 z-[100] bg-navy/95 backdrop-blur-md flex items-center justify-center p-0 md:p-4">
        <div class="popup-close-btn" onclick="closeServicePopup()">
            <i class="fas fa-times"></i>
        </div>
        
        <div class="popup-content w-full h-full md:h-auto md:max-w-4xl bg-white flex flex-col md:flex-row shadow-2xl overflow-y-auto md:overflow-hidden rounded-none md:rounded-sm">
            <div class="w-full md:w-1/2 h-64 md:h-auto relative shrink-0">
                <img id="popup-img" src="" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-navy/50 to-transparent md:hidden"></div>
            </div>
            <div class="w-full md:w-1/2 p-6 md:p-8 lg:p-12 flex flex-col justify-center bg-cream grow">
                <div class="diamond-line mb-6 flex items-center justify-center">
                    <div class="diamond-shape mx-6"></div>
                </div>
                <h2 id="popup-title" class="text-2xl md:text-3xl lg:text-4xl font-cinzel text-navy mb-6">Service Title</h2>
                <div class="h-px w-12 bg-gold mb-6"></div>
                <p id="popup-desc" class="text-navy/80 font-sans leading-loose text-sm md:text-base mb-8"></p>
                <div class="bg-white p-4 border-l-4 border-gold shadow-sm">
                    <p class="text-xs text-gray-500 italic">"We value your time and investment. Our bespoke process guarantees that your vision is honored with the highest standard of craftsmanship."</p>
                </div>
                <div class="mt-8 text-center md:text-left pb-8 md:pb-0">
    <a href="#" id="popup-book-btn" onclick="closeServicePopup()" class="inline-block bg-navy text-white px-6 md:px-8 py-3 font-sans text-xs font-bold uppercase tracking-widest hover:bg-gold transition-colors">
        Book This Service
    </a>
</div>
            </div>
        </div>
    </div>

    <div id="image-popup" class="fixed inset-0 z-[2000] bg-black/95 backdrop-blur-sm flex items-center justify-center">
        <div class="popup-close-btn" onclick="closeImagePopup()">
            <i class="fas fa-times"></i>
        </div>

        <button onclick="prevImage()" class="absolute left-4 md:left-6 top-1/2 transform -translate-y-1/2 text-white/60 hover:text-gold text-2xl md:text-3xl focus:outline-none transition-colors z-10 hidden md:block">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button onclick="nextImage()" class="absolute right-4 md:right-6 top-1/2 transform -translate-y-1/2 text-white/60 hover:text-gold text-2xl md:text-3xl focus:outline-none transition-colors z-10 hidden md:block">
            <i class="fas fa-chevron-right"></i>
        </button>
        
        <div class="popup-content w-full h-full flex items-center justify-center overflow-hidden">
            <div class="relative w-full h-full flex items-center justify-center">
                <div id="popup-counter" class="popup-counter"></div>
                <!-- Changed cursor and added ID for JS manipulation -->
                <img id="popup-image" src="" alt="" class="popup-image rounded-sm shadow-2xl select-none" draggable="false">
                <div id="popup-caption" class="absolute bottom-4 md:bottom-10 left-0 right-0 text-center text-white font-sans text-xs md:text-sm lg:text-base max-w-2xl mx-auto opacity-90 bg-black/50 py-2 rounded-full mx-4 pointer-events-none"></div>
                
                <!-- Zoom Controls -->
                <div class="zoom-controls">
                    <button class="zoom-btn" onclick="zoomOut()" title="Zoom Out">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button class="zoom-btn" onclick="resetZoom()" title="Reset Zoom">
                        <i class="fas fa-compress-arrows-alt"></i>
                    </button>
                    <button class="zoom-btn" onclick="zoomIn()" title="Zoom In">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="popup-navigation">
            <button onclick="prevImage()" class="text-white/60 hover:text-white text-2xl focus:outline-none transition-colors">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button onclick="nextImage()" class="text-white/60 hover:text-white text-2xl focus:outline-none transition-colors">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <script>
        // Store image arrays
        let galleryImages = <?php echo json_encode($gallery_images ?? []); ?>;
        let collectionImages = <?php echo json_encode($collection_images ?? []); ?>;
        let blogImages = <?php echo json_encode($blog_images ?? []); ?>;
        let instagramImages = <?php echo json_encode($instagram_images ?? []); ?>;
        
        let currentImageSet = [];
        let currentIndex = 0;
        
        // Zoom and Drag State Variables
        let scale = 1;
        let pointX = 0;
        let pointY = 0;
        let startX = 0;
        let startY = 0;
        let isDragging = false;
        
        document.addEventListener('DOMContentLoaded', () => {
            const loader = document.getElementById('loader');
            setTimeout(() => { 
                loader.classList.add('opacity-0', 'pointer-events-none'); 
                setTimeout(() => { loader.style.display = 'none'; }, 800); 
            }, 1500);

            // Enhanced reveal observers
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => { 
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, { threshold: 0.1, rootMargin: '50px' });
            
            document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));
            document.querySelectorAll('.reveal-left').forEach(el => revealObserver.observe(el));
            document.querySelectorAll('.reveal-right').forEach(el => revealObserver.observe(el));
            
            // Smooth scroll animation observer
            const scrollAnimateObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                    }
                });
            }, { threshold: 0.1, rootMargin: '50px' });
            
            document.querySelectorAll('.scroll-animate').forEach(el => scrollAnimateObserver.observe(el));

            // Header scroll effect - UPDATED: Only toggles background style, never moves header
            const header = document.getElementById('header');
            window.addEventListener('scroll', () => {
                // Banner is always fixed, so header top stays at its initial position (40px or 0)
                if (window.scrollY > 100) { 
                    header.classList.add('scrolled'); 
                } else { 
                    header.classList.remove('scrolled'); 
                }
            });

            // Interest Button Logic
            const interestBtns = document.querySelectorAll('.interest-btn');
            const interestInput = document.getElementById('interest-input');
            interestBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    interestBtns.forEach(b => {
                        b.classList.remove('bg-navy', 'text-white', 'border-navy', 'bg-gold');
                        b.classList.add('text-navy', 'border-gray-300');
                    });
                    btn.classList.remove('text-navy', 'border-gray-300');
                    btn.classList.add('bg-gold', 'text-white', 'border-gold');
                    interestInput.value = btn.getAttribute('data-value') || btn.textContent;
                });
            });

            // Enhanced Cursor Logic - IMPROVED
            const isTouch = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);
            if (!isTouch) {
                const cursor = document.querySelector('.cursor');
                const follower = document.querySelector('.cursor-follower');
                let mouseX = 0, mouseY = 0;
                let cursorX = 0, cursorY = 0;
                let followerX = 0, followerY = 0;
                
                document.addEventListener('mousemove', (e) => {
                    mouseX = e.clientX;
                    mouseY = e.clientY;
                });
                
                function updateCursor() {
                    // Direct cursor movement with minimal lag
                    cursorX = mouseX;
                    cursorY = mouseY;
                    cursor.style.left = cursorX + 'px';
                    cursor.style.top = cursorY + 'px';
                    
                    // Follower with slight delay for smooth effect
                    followerX += (mouseX - followerX) * 0.08;
                    followerY += (mouseY - followerY) * 0.08;
                    follower.style.left = followerX + 'px';
                    follower.style.top = followerY + 'px';
                    
                    requestAnimationFrame(updateCursor);
                }
                
                updateCursor();
                
                document.querySelectorAll('a, button, input, textarea, .gallery-item, .collection-image, .instagram-item').forEach(el => {
                    el.addEventListener('mouseenter', () => { 
                        cursor.classList.add('hover'); 
                        follower.classList.add('hover'); 
                    });
                    el.addEventListener('mouseleave', () => { 
                        cursor.classList.remove('hover'); 
                        follower.classList.remove('hover'); 
                    });
                });
            }

            // Add click handlers to all images
            document.querySelectorAll('img').forEach(img => {
                if (!img.closest('a') && !img.classList.contains('no-popup')) {
                    img.style.cursor = 'pointer';
                    img.addEventListener('click', function() {
                        const title = this.getAttribute('data-title') || this.alt || 'Image';
                        openImagePopup(this.src, title);
                    });
                }
            });
            
            // Update nav scroll indicator on window resize
            window.addEventListener('resize', updateNavScrollIndicator);
            
            // Sidebar functionality
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const sidebarClose = document.getElementById('sidebar-close');
            
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
                sidebarToggle.classList.toggle('active');
            });
            
            sidebarClose.addEventListener('click', () => {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                sidebarToggle.classList.remove('active');
            });
            
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                sidebarToggle.classList.remove('active');
            });
            
            // Close sidebar when clicking on a link
            sidebar.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                    sidebarToggle.classList.remove('active');
                });
            });
            
            // Initialize Zoom/Drag Event Listeners for Image Popup
            initZoomAndDrag();
        });

        // Service Popup Logic
        // Service Popup Logic
const sPopup = document.getElementById('service-popup');
const pImg = document.getElementById('popup-img');
const pTitle = document.getElementById('popup-title');
const pDesc = document.getElementById('popup-desc');
// Select the button
const pBtn = document.getElementById('popup-book-btn');

function openServicePopup(data) {
    pImg.src = data.icon_image;
    pTitle.innerText = data.title;
    pDesc.innerText = data.description;
    
    // NEW: Update Link and Text dynamically
    // If booking_url exists, use it. Otherwise fallback to contact_us.php
    pBtn.href = data.booking_url ? data.booking_url : 'contact_us.php';
    
    // If button_text exists, use it. Otherwise fallback to "Book Now"
    pBtn.innerText = data.button_text ? data.button_text : 'Book This Service';

    sPopup.classList.add('active');
    document.body.style.overflow = 'hidden';
}

        function closeServicePopup() {
            sPopup.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        sPopup.addEventListener('click', (e) => {
            if (e.target === sPopup) closeServicePopup();
        });
        
        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape") closeServicePopup();
        });

        // Image Popup Functions
        function openImagePopup(src, caption = '') {
            currentImageSet = [{src, caption}];
            currentIndex = 0;
            updateImagePopup();
            document.getElementById('image-popup').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function openGalleryImage(index) {
            currentImageSet = galleryImages.map(img => ({
                src: img.image_url,
                caption: img.caption || 'Gallery Image'
            }));
            currentIndex = index;
            updateImagePopup();
            document.getElementById('image-popup').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function openInstagramImage(index) {
            // Open Instagram in a new tab instead of showing in popup
            const post = instagramImages[index];
            if (post && post.instagram_id) {
                window.open(`https://instagram.com/p/${post.instagram_id}`, '_blank');
            }
        }
        
        function updateImagePopup() {
            if (currentImageSet.length === 0) return;
            
            const image = currentImageSet[currentIndex];
            document.getElementById('popup-image').src = image.src;
            document.getElementById('popup-caption').textContent = image.caption;
            document.getElementById('popup-counter').textContent = `${currentIndex + 1} / ${currentImageSet.length}`;
            
            // Reset Zoom/Pan on image change
            resetZoom();
            
            // Show/hide navigation based on image count
            const navButtons = document.querySelectorAll('.popup-navigation button, #image-popup button:not(.popup-close-btn)');
            navButtons.forEach(btn => {
                if (currentImageSet.length > 1) {
                    btn.style.display = 'block';
                } else {
                    btn.style.display = 'none';
                }
            });
        }
        
        function prevImage() {
            if (currentImageSet.length === 0) return;
            currentIndex = (currentIndex - 1 + currentImageSet.length) % currentImageSet.length;
            updateImagePopup();
        }
        
        function nextImage() {
            if (currentImageSet.length === 0) return;
            currentIndex = (currentIndex + 1) % currentImageSet.length;
            updateImagePopup();
        }
        
        function closeImagePopup() {
            document.getElementById('image-popup').classList.remove('active');
            document.body.style.overflow = 'auto';
            resetZoom(); // Reset when closing
        }
        
        // Keyboard navigation for image popup
        document.addEventListener('keydown', (e) => {
            const imagePopup = document.getElementById('image-popup');
            if (imagePopup.classList.contains('active')) {
                if (e.key === "Escape") closeImagePopup();
                if (e.key === "ArrowLeft") prevImage();
                if (e.key === "ArrowRight") nextImage();
            }
        });
        
        // Close image popup when clicking outside
        document.getElementById('image-popup').addEventListener('click', (e) => {
            if (e.target === document.getElementById('image-popup')) {
                closeImagePopup();
            }
        });
        
        // Handle mobile navigation scroll
        function updateNavScrollButtons() {
            const navContainer = document.querySelector('.nav-scroll-wrapper');
            const leftBtn = document.querySelector('.scroll-btn-left');
            const rightBtn = document.querySelector('.scroll-btn-right');
            
            if (navContainer) {
                const scrollLeft = navContainer.scrollLeft;
                const maxScroll = navContainer.scrollWidth - navContainer.clientWidth;
                
                if (leftBtn) {
                    leftBtn.style.display = scrollLeft > 0 ? 'flex' : 'none';
                }
                if (rightBtn) {
                    rightBtn.style.display = scrollLeft < maxScroll - 5 ? 'flex' : 'none';
                }
            }
        }
        
        // Initialize nav scroll buttons
        document.addEventListener('DOMContentLoaded', () => {
            const navContainer = document.querySelector('.nav-scroll-wrapper');
            if (navContainer) {
                navContainer.addEventListener('scroll', updateNavScrollButtons);
                updateNavScrollButtons();
            }
        });

        // --- NEW: Zoom and Drag Logic ---
        
        function updateTransform() {
            const popupImage = document.getElementById('popup-image');
            if(popupImage) {
                popupImage.style.transform = `translate(${pointX}px, ${pointY}px) scale(${scale})`;
            }
        }

        function zoomIn() {
            if(scale < 5) {
                scale += 0.5;
                updateTransform();
            }
        }

        function zoomOut() {
            if(scale > 1) {
                scale -= 0.5;
                // If we zoom out to 1, reset position as well
                if(scale === 1) {
                    pointX = 0;
                    pointY = 0;
                }
                updateTransform();
            }
        }

        function resetZoom() {
            scale = 1;
            pointX = 0;
            pointY = 0;
            updateTransform();
        }

        function initZoomAndDrag() {
            const popupContainer = document.querySelector('#image-popup .popup-content');
            const popupImage = document.getElementById('popup-image');

            if (!popupContainer || !popupImage) return;

            // --- Mouse Events ---
            popupContainer.addEventListener('mousedown', (e) => {
                // Only drag if left mouse button and scale > 1
                if (e.button === 0 && scale > 1) {
                    isDragging = true;
                    startX = e.clientX - pointX;
                    startY = e.clientY - pointY;
                    popupImage.style.cursor = 'grabbing';
                }
            });

            window.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
                const x = e.clientX - startX;
                const y = e.clientY - startY;
                
                // Optional: Boundary checks could go here
                pointX = x;
                pointY = y;
                updateTransform();
            });

            window.addEventListener('mouseup', () => {
                isDragging = false;
                if(popupImage) popupImage.style.cursor = 'grab';
            });

            // --- Touch Events (Mobile) ---
            popupContainer.addEventListener('touchstart', (e) => {
                if (scale > 1 && e.touches.length === 1) {
                    isDragging = true;
                    const touch = e.touches[0];
                    startX = touch.clientX - pointX;
                    startY = touch.clientY - pointY;
                }
            }, {passive: false});

            window.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                // Prevent scrolling page while dragging image
                if(e.cancelable) e.preventDefault(); 
                
                const touch = e.touches[0];
                pointX = touch.clientX - startX;
                pointY = touch.clientY - startY;
                updateTransform();
            }, {passive: false});

            window.addEventListener('touchend', () => {
                isDragging = false;
            });

            // Wheel Zoom (Desktop)
            popupContainer.addEventListener('wheel', (e) => {
                if(e.ctrlKey || e.metaKey || scale > 1) {
                    e.preventDefault();
                    const delta = e.deltaY * -0.001;
                    const newScale = Math.min(Math.max(1, scale + delta), 5);
                    
                    // Zoom towards pointer logic could be added here, 
                    // center zoom is simpler and stable for this scope.
                    scale = newScale;
                    if(scale === 1) {
                        pointX = 0;
                        pointY = 0;
                    }
                    updateTransform();
                }
            }, {passive: false});
        }
    </script>
</body>
</html>