<?php
// all_collections.php
// --- CONFIGURATION ---
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'db.php';

// Fetch ALL collections
$sql = "SELECT * FROM collections ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth no-scrollbar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Collections - The Grafton Vault</title>
    
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
                        'fade-in': 'fade-in 0.8s ease-out'
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' }
                        },
                        'fade-in': {
                            '0%': { opacity: 0, transform: 'translateY(20px)' },
                            '100%': { opacity: 1, transform: 'translateY(0)' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        body { overflow-x: hidden; }
        
        .reveal { 
            animation: fade-in 1s ease-out forwards; 
        }
        
        .decorative-border {
            position: relative;
            border: 1px solid transparent;
            background: linear-gradient(#f7f0e3, #f7f0e3) padding-box,
                      linear-gradient(45deg, #B29243, transparent, #B29243) border-box;
        }

        /* Image Popup Styles */
        #image-popup .popup-image {
            max-width: 98vw;
            max-height: 95vh;
            width: auto;
            height: auto;
            object-fit: contain;
            animation: fade-in 0.5s ease-out;
        }
        #image-popup { 
            transition: opacity 0.4s ease, visibility 0.4s ease; 
            opacity: 0; 
            visibility: hidden; 
        }
        #image-popup.active { 
            opacity: 1; 
            visibility: visible; 
        }
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

    <section class="bg-navy pt-20 pb-32 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-t from-cream to-transparent opacity-5 pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-gold/10 rounded-full blur-[100px] pointer-events-none"></div>
        
        <div class="container mx-auto px-6 text-center relative z-10 animate-fade-in">
            <span class="text-gold text-xs font-bold tracking-[0.3em] uppercase block mb-4">Curated Excellence</span>
            <h1 class="text-4xl md:text-6xl font-cinzel text-white mb-6">Our Collections</h1>
            <div class="h-px w-24 bg-gradient-to-r from-transparent via-gold to-transparent mx-auto mb-6"></div>
            <p class="text-white/60 font-sans text-sm md:text-base max-w-xl mx-auto">
                Explore our full range of masterpieces, where every piece tells a story of heritage and craftsmanship.
            </p>
        </div>
    </section>

    <section class="py-24 -mt-20 relative z-20 bg-cream">
        <div class="absolute inset-0 bg-diamond-pattern opacity-5 pointer-events-none"></div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '
                        <div class="group relative h-[450px] overflow-hidden reveal decorative-border rounded-sm shadow-lg bg-white">
                            <img src="'.$row['cover_image'].'" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 cursor-pointer"
                                 onclick="openImagePopup(\''.$row['cover_image'].'\', \''.$row['title'].'\')">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-navy/90 via-navy/30 to-transparent opacity-100 transition-colors flex flex-col items-center justify-end p-8 text-white">
                                <h3 class="text-2xl font-cinzel uppercase tracking-widest mb-4 text-center text-white group-hover:text-gold transition-colors">'.$row['title'].'</h3>
                                <p class="text-white/80 font-sans text-sm text-center mb-6 hidden group-hover:block transition-all duration-300 line-clamp-3">'.substr($row['description'] ?? 'Discover this exclusive collection', 0, 120).'...</p>
                                <div class="flex gap-4">
                                    <a href="collection_info.php?item='.$row['id'].'" class="font-sans text-xs font-bold border border-white px-6 py-2 hover:bg-white hover:text-navy transition-colors">View Details</a>
                                    <button onclick="openImagePopup(\''.$row['cover_image'].'\', \''.$row['title'].'\')" class="font-sans text-xs font-bold border border-gold px-6 py-2 hover:bg-gold hover:text-navy transition-colors text-gold">View Image</button>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    echo '<p class="text-center text-navy font-cinzel col-span-full">No collections found.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <footer class="bg-navy text-white py-12 border-t border-white/10 text-center relative">
        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-3/4 h-px bg-gradient-to-r from-transparent via-gold/30 to-transparent"></div>
        <div class="container mx-auto px-6">
            <div class="flex flex-col items-center justify-center gap-6 mb-8">
                <a href="#" class="logo text-white text-3xl font-bold uppercase tracking-widest font-cinzel">
                    Grafton <span class="font-light">Vault</span>
                </a>
            </div>
            <p class="font-sans text-xs text-white/40 tracking-widest uppercase">© <?php echo date("Y"); ?> The Grafton Vault. All rights reserved.</p>
        </div>
    </footer>

    <div id="image-popup" class="fixed inset-0 z-[110] bg-black/95 backdrop-blur-sm flex items-center justify-center">
        <button onclick="closeImagePopup()" class="absolute top-6 right-6 text-white/80 hover:text-gold text-4xl md:text-5xl focus:outline-none transition-colors z-[200]">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="popup-content w-full h-full flex items-center justify-center">
            <div class="relative w-full h-full flex items-center justify-center">
                <img id="popup-image" src="" alt="" class="popup-image rounded-sm shadow-2xl">
                <div id="popup-caption" class="absolute bottom-10 left-0 right-0 text-center text-white font-sans text-sm md:text-base max-w-2xl mx-auto opacity-90 bg-black/50 py-2 rounded-full mx-4"></div>
            </div>
        </div>
    </div>

    <script>
        // Image Popup Logic
        function openImagePopup(src, caption) {
            document.getElementById('popup-image').src = src;
            document.getElementById('popup-caption').innerText = caption;
            document.getElementById('image-popup').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeImagePopup() {
            document.getElementById('image-popup').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape") closeImagePopup();
        });

        // Close on clicking background
        document.getElementById('image-popup').addEventListener('click', (e) => {
            if (e.target === document.getElementById('image-popup')) {
                closeImagePopup();
            }
        });
    </script>

</body>
</html>