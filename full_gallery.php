<?php
// full_gallery.php
// --- CONFIGURATION ---
ini_set('display_errors', 0);
error_reporting(E_ALL);
include 'db.php';

// Fetch All Gallery Images
$g_sql = "SELECT * FROM shop_gallery ORDER BY id DESC";
$g_res = $conn->query($g_sql);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth no-scrollbar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Visual Diary - The Grafton Vault</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&family=Cinzel:wght@400;500;600&display=swap" rel="stylesheet">
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
                    },
                    fontFamily: { 
                        serif: ['"Libre Baskerville"', 'serif'], 
                        sans: ['"Lato"', 'sans-serif'],
                        cinzel: ['Cinzel', 'serif'],
                    },
                    backgroundImage: { 
                        'diamond-pattern': 'url("data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23B29243\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")'
                    },
                    animation: {
                        'fade-in': 'fade-in 0.8s ease-out'
                    },
                    keyframes: {
                        'fade-in': { '0%': { opacity: 0, transform: 'translateY(20px)' }, '100%': { opacity: 1, transform: 'translateY(0)' } }
                    }
                }
            }
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        body { overflow-x: hidden; -webkit-tap-highlight-color: transparent; }
        
        /* Thread Animation */
        .draw-line {
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000;
            animation: draw 3s ease-out forwards;
        }
        @keyframes draw { to { stroke-dashoffset: 0; } }

        /* Gallery Item Animation */
        .gallery-item {
            opacity: 0;
            transform: translateY(20px);
            animation: fade-in 0.8s ease-out forwards;
        }

        /* Prevent selecting image when dragging */
        img { user-select: none; -webkit-user-select: none; -webkit-user-drag: none; }
    </style>
</head>
<body class="bg-cream text-navy antialiased font-serif selection:bg-gold selection:text-white">

    <header class="bg-navy py-6 text-white shadow-md relative z-50">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <a href="index.php" class="text-xl md:text-2xl font-bold uppercase tracking-widest font-cinzel">
                TGV 
            </a>
            <a href="javascript:history.back()" class="text-xs font-sans uppercase tracking-widest border-b border-gold hover:text-gold transition-colors flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </header>

    <section class="bg-navy pt-16 pb-20 md:pt-20 md:pb-32 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-t from-cream to-transparent opacity-5 pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-gold/10 rounded-full blur-[100px] pointer-events-none"></div>
        
        <div class="container mx-auto px-6 text-center relative z-10 animate-fade-in">
            <span class="text-gold text-[10px] md:text-xs font-bold tracking-[0.3em] uppercase block mb-3 md:mb-4">The Collection</span>
            <h1 class="text-3xl md:text-6xl font-cinzel text-white mb-4 md:mb-6">Visual Diary</h1>
            <div class="h-px w-16 md:w-24 bg-gradient-to-r from-transparent via-gold to-transparent mx-auto mb-4 md:mb-6"></div>
            <p class="text-white/60 font-sans text-xs md:text-sm max-w-xl mx-auto px-4">
                A curated glimpse into our world of bespoke craftsmanship.
            </p>
        </div>
    </section>

    <section class="py-12 md:py-24 -mt-10 md:-mt-20 relative z-20 bg-cream min-h-screen">
        <div class="absolute inset-0 bg-diamond-pattern opacity-5 pointer-events-none"></div>
        
        <div class="absolute inset-0 pointer-events-none z-0 opacity-30">
            <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 100 100">
                <path d="M0,10 Q25,10 25,40 T50,70 T75,40 T100,10" fill="none" stroke="#1a1a1a" stroke-width="0.1" class="draw-line" />
            </svg>
        </div>

        <div class="container mx-auto px-3 md:px-6 relative z-10">
            <?php if($g_res->num_rows > 0): ?>
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 md:gap-8">
                    <?php 
                    $delay = 0;
                    while($img = $g_res->fetch_assoc()): 
                        $delay += 50; 
                    ?>
                        <div class="gallery-item group relative p-1.5 md:p-3 bg-white shadow-lg hover:shadow-2xl transition-all duration-300 active:scale-95 cursor-pointer" 
                             style="animation-delay: <?php echo $delay; ?>ms"
                             onclick="openLightbox('<?php echo htmlspecialchars($img['image_url']); ?>')">
                            
                            <div class="absolute top-0 left-0 w-full h-[0.5px] md:h-px bg-gold/20"></div>
                            <div class="absolute bottom-0 left-0 w-full h-[0.5px] md:h-px bg-gold/20"></div>
                            <div class="absolute top-0 left-0 h-full w-[0.5px] md:w-px bg-gold/20"></div>
                            <div class="absolute top-0 right-0 h-full w-[0.5px] md:w-px bg-gold/20"></div>

                            <div class="absolute top-0 left-0 w-2 h-2 md:w-4 md:h-4 border-t border-l border-gold transition-all duration-300 group-hover:w-full group-hover:h-full"></div>
                            <div class="absolute bottom-0 right-0 w-2 h-2 md:w-4 md:h-4 border-b border-r border-gold transition-all duration-300 group-hover:w-full group-hover:h-full"></div>

                            <div class="relative overflow-hidden aspect-[3/4]">
                                <img src="<?php echo htmlspecialchars($img['image_url']); ?>" 
                                     alt="Gallery Image" 
                                     class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-110">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-navy/90 via-transparent to-transparent opacity-0 md:group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-4 hidden md:flex">
                                    <div class="text-center">
                                        <div class="w-6 h-px bg-gold mx-auto mb-2"></div>
                                        <span class="text-white text-[10px] uppercase tracking-widest font-sans">View</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-20 border border-dashed border-navy/10 rounded-sm">
                    <p class="text-navy/50 font-serif text-lg">No images found.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="bg-navy text-white py-8 md:py-12 border-t border-white/10 text-center relative">
        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-3/4 h-px bg-gradient-to-r from-transparent via-gold/30 to-transparent"></div>
        <div class="container mx-auto px-6">
            <div class="flex flex-col items-center justify-center gap-4 md:gap-6 mb-6">
                <a href="#" class="logo text-white text-2xl md:text-3xl font-bold uppercase tracking-widest font-cinzel">
                    Grafton <span class="font-light">Vault</span>
                </a>
            </div>
            <p class="font-sans text-[10px] md:text-xs text-white/40 tracking-widest uppercase">© <?php echo date("Y"); ?> The Grafton Vault.</p>
        </div>
    </footer>

    <div id="lightbox" class="fixed inset-0 z-[100] bg-navy/98 backdrop-blur-xl flex flex-col items-center justify-center hidden opacity-0 transition-opacity duration-300">
        
        <div class="absolute top-0 left-0 w-full p-4 flex justify-between items-center z-[200]">
            <span class="text-gold font-cinzel text-sm md:text-lg tracking-widest ml-2">Gallery</span>
            <button onclick="closeLightbox()" class="text-white/50 hover:text-white p-2">
                <i class="fas fa-times text-2xl md:text-3xl"></i>
            </button>
        </div>

        <div id="lightbox-container" class="relative w-full h-full flex items-center justify-center overflow-hidden" 
             style="touch-action: none;"> <img id="lightbox-img" src="" 
                 class="max-h-[85vh] max-w-[95vw] shadow-2xl transition-transform duration-100 ease-out object-contain select-none"
                 draggable="false">
        </div>

        <div class="absolute bottom-6 md:bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-4 md:gap-6 bg-navy/80 border border-white/10 px-4 py-2 md:px-6 md:py-3 rounded-full backdrop-blur-md shadow-2xl z-[200]">
            <button onclick="zoomOut()" class="text-white/70 hover:text-gold transition-colors text-lg md:text-xl p-2" title="Zoom Out"><i class="fas fa-minus"></i></button>
            <button onclick="resetZoom()" class="text-white/70 hover:text-gold transition-colors text-lg md:text-xl p-2" title="Reset"><i class="fas fa-compress"></i></button>
            <button onclick="zoomIn()" class="text-white/70 hover:text-gold transition-colors text-lg md:text-xl p-2" title="Zoom In"><i class="fas fa-plus"></i></button>
        </div>
    </div>

    <script>
        const lightbox = document.getElementById('lightbox');
        const img = document.getElementById('lightbox-img');
        const container = document.getElementById('lightbox-container');
        
        let scale = 1;
        let pointX = 0;
        let pointY = 0;
        let startX = 0;
        let startY = 0;
        let isDragging = false;

        function openLightbox(src) {
            img.src = src;
            lightbox.classList.remove('hidden');
            resetZoom();
            setTimeout(() => lightbox.classList.remove('opacity-0'), 10);
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.classList.add('opacity-0');
            setTimeout(() => {
                lightbox.classList.add('hidden');
                img.src = '';
            }, 300);
            document.body.style.overflow = 'auto';
        }

        function updateTransform() {
            img.style.transform = `translate(${pointX}px, ${pointY}px) scale(${scale})`;
        }

        function zoomIn() {
            scale = Math.min(scale + 0.5, 4);
            updateTransform();
        }

        function zoomOut() {
            scale = Math.max(scale - 0.5, 1);
            if(scale === 1) { pointX = 0; pointY = 0; }
            updateTransform();
        }

        function resetZoom() {
            scale = 1; pointX = 0; pointY = 0;
            updateTransform();
        }

        // --- Touch & Mouse Logic for Panning ---
        
        const handleStart = (clientX, clientY) => {
            if (scale <= 1) return;
            isDragging = true;
            startX = clientX - pointX;
            startY = clientY - pointY;
            container.style.cursor = 'grabbing';
        };

        const handleMove = (clientX, clientY) => {
            if (!isDragging) return;
            pointX = clientX - startX;
            pointY = clientY - startY;
            updateTransform();
        };

        const handleEnd = () => {
            isDragging = false;
            container.style.cursor = 'default';
        };

        // Mouse Events
        container.addEventListener('mousedown', e => {
            e.preventDefault();
            handleStart(e.clientX, e.clientY);
        });
        window.addEventListener('mousemove', e => handleMove(e.clientX, e.clientY));
        window.addEventListener('mouseup', handleEnd);

        // Touch Events (Mobile)
        container.addEventListener('touchstart', e => {
            if (e.touches.length === 1) {
                handleStart(e.touches[0].clientX, e.touches[0].clientY);
            }
        });
        container.addEventListener('touchmove', e => {
            if (e.touches.length === 1) {
                // e.preventDefault(); // Uncomment if page scrolls while dragging
                handleMove(e.touches[0].clientX, e.touches[0].clientY);
            }
        });
        container.addEventListener('touchend', handleEnd);

        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape") closeLightbox();
        });
    </script>
</body>
</html>