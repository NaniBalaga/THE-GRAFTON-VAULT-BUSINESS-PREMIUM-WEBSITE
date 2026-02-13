<?php
// collection_info.php
// --- CONFIGURATION ---
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'db.php';

// 1. Validation
if (!isset($_GET['item']) || empty($_GET['item'])) {
    die("Error: No item ID specified.");
}

$id = intval($_GET['item']);

// 2. Fetch Collection Details
$stmt = $conn->prepare("SELECT * FROM collections WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$collection = $stmt->get_result()->fetch_assoc();

if (!$collection) {
    die("Collection not found.");
}

// 3. Fetch Gallery Images
$gallery_sql = "SELECT * FROM collection_gallery WHERE collection_id = $id";
$gallery_result = $conn->query($gallery_sql);
$gallery_images = [];
while ($row = $gallery_result->fetch_assoc()) {
    $gallery_images[] = $row;
}

// 4. Booking Logic
$booking_url = !empty($collection['calendly_link']) ? $collection['calendly_link'] : 'contact_us.php';
$target_attr = !empty($collection['calendly_link']) ? 'target="_blank"' : '';
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth no-scrollbar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($collection['title']); ?> - The Grafton Vault</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&family=Cinzel:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { cream: '#f7f0e3', navy: '#0A1A33', gold: '#B29243', darkGold: '#8B6C2E' },
                    fontFamily: { 
                        serif: ['"Libre Baskerville"', 'serif'], 
                        sans: ['"Lato"', 'sans-serif'],
                        cinzel: ['Cinzel', 'serif']
                    },
                    backgroundImage: { 
                        'diamond-pattern': 'url("data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23B29243\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")'
                    },
                    animation: { 'fade-in': 'fade-in 0.8s ease-out' },
                    keyframes: { 'fade-in': { '0%': { opacity: 0 }, '100%': { opacity: 1 } } }
                }
            }
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Description Text Formatting */
        .description-text {
            white-space: pre-line;
            line-height: 1.8;
        }

        /* Diamond Divider Styles */
        .ornamental-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 2.5rem 0;
            opacity: 0.7;
        }
        .ornamental-divider::before,
        .ornamental-divider::after {
            content: '';
            height: 1px;
            flex-grow: 1;
            background: linear-gradient(90deg, transparent, #B29243, transparent);
        }
        .ornamental-icon {
            margin: 0 1.5rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .diamond-shape-sm {
            width: 4px; height: 4px; background: #B29243; transform: rotate(45deg);
        }
        .diamond-shape-md {
            width: 8px; height: 8px; background: #B29243; transform: rotate(45deg); position: relative;
        }
        .diamond-shape-md::after {
            content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
            width: 2px; height: 2px; background: white;
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
    <div class="relative h-[40vh] md:h-[50vh] w-full overflow-hidden">
        <img src="<?php echo htmlspecialchars($collection['cover_image']); ?>" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-navy/60 flex items-center justify-center">
            <div class="text-center px-6 animate-fade-in">
                <span class="text-gold text-[10px] md:text-xs font-sans font-bold uppercase tracking-[0.2em] mb-2 block">Collection</span>
                <h1 class="text-3xl md:text-5xl text-white font-cinzel tracking-wide border-b border-gold/50 pb-4 inline-block">
                    <?php echo htmlspecialchars($collection['title']); ?>
                </h1>
            </div>
        </div>
    </div>

    <section class="py-8 px-4 md:px-12 bg-cream">
        <div class="max-w-3xl mx-auto">
            
            <div class="ornamental-divider">
                <div class="ornamental-icon">
                    <div class="diamond-shape-sm"></div>
                    <div class="diamond-shape-md"></div>
                    <div class="diamond-shape-sm"></div>
                </div>
            </div>

            <div class="description-text text-sm md:text-lg text-navy/80 font-sans text-justify md:text-left">
                <?php echo trim($collection['description']); ?>
            </div>

            <div class="ornamental-divider">
                <div class="ornamental-icon">
                    <div class="diamond-shape-sm"></div>
                    <div class="diamond-shape-md"></div>
                    <div class="diamond-shape-sm"></div>
                </div>
            </div>

        </div>
    </section>

    <section class="py-12 px-4 md:px-12 bg-white border-t border-navy/5">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-cinzel text-navy">Visual Details</h2>
                <div class="w-8 h-px bg-gold mx-auto mt-2"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
                <?php 
                $count = 0;
                if(count($gallery_images) > 0):
                    foreach($gallery_images as $img): 
                        $count++;
                        $hiddenClass = ($count > 6) ? 'hidden gallery-hidden' : ''; 
                ?>
                    <div class="relative group cursor-pointer aspect-[3/4] overflow-hidden bg-gray-100 <?php echo $hiddenClass; ?>" 
                         onclick="openLightbox('<?php echo $img['image_path']; ?>')">
                        <img src="<?php echo htmlspecialchars($img['image_path']); ?>" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute bottom-2 right-2 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <i class="fas fa-expand text-sm drop-shadow-md"></i>
                        </div>
                    </div>
                <?php 
                    endforeach; 
                else:
                ?>
                    <div class="col-span-full text-center py-10 border border-dashed border-navy/20">
                        <p class="text-navy/50 text-sm italic">Gallery images coming soon.</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if(count($gallery_images) > 6): ?>
            <div class="text-center mt-10">
                <button id="loadMoreBtn" onclick="loadMoreImages()" class="text-xs font-bold uppercase tracking-widest text-navy border-b border-navy pb-1 hover:text-gold hover:border-gold transition-colors">
                    View Complete Gallery
                </button>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="py-24 relative bg-navy overflow-hidden text-white">
        <div class="absolute inset-0 bg-diamond-pattern opacity-5 pointer-events-none"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-navy via-[#162A4A] to-navy opacity-90"></div>
        
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-gold/5 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10 text-center max-w-4xl">
            <span class="text-gold text-[10px] md:text-xs font-sans font-bold uppercase tracking-[0.3em] block mb-6">Private Viewing</span>
            
            <h2 class="text-3xl md:text-5xl font-cinzel mb-6 leading-tight">Acquire this <span class="italic text-gold">Piece</span></h2>
            
            <div class="flex justify-center items-center gap-4 mb-8 opacity-60">
                <div class="h-px w-12 bg-white"></div>
                <div class="w-2 h-2 rotate-45 border border-white"></div>
                <div class="h-px w-12 bg-white"></div>
            </div>

            <p class="text-white/70 font-sans text-sm md:text-lg leading-relaxed mb-10 max-w-2xl mx-auto">
                Schedule a bespoke appointment with our senior gemologists to experience the brilliance of the <strong><?php echo htmlspecialchars($collection['title']); ?></strong> collection in person or via private virtual consultation.
            </p>

            <div class="flex flex-col md:flex-row items-center justify-center gap-6">
                <a href="<?php echo htmlspecialchars($booking_url); ?>" <?php echo $target_attr; ?> 
                   class="group relative inline-flex items-center justify-center overflow-hidden bg-gold px-12 py-4 text-white transition-all duration-300 hover:shadow-[0_0_20px_rgba(178,146,67,0.4)]">
                    <span class="absolute h-0 w-0 rounded-full bg-white transition-all duration-500 ease-out group-hover:h-56 group-hover:w-56 opacity-10"></span>
                    <span class="relative font-sans text-xs font-bold uppercase tracking-[0.2em] z-10">Book Consultation</span>
                </a>
                
                <a href="index.php" class="text-xs font-sans uppercase tracking-widest text-white/50 hover:text-white transition-colors border-b border-transparent hover:border-white pb-1">
                    Return to Vault
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-navy text-white py-8 border-t border-white/10 text-center">
        <div class="container mx-auto px-6">
            <p class="font-sans text-[10px] md:text-xs text-white/40 tracking-widest uppercase">© <?php echo date("Y"); ?> The Grafton Vault. All rights reserved.</p>
        </div>
    </footer>

    <div id="lightbox" class="fixed inset-0 z-[100] bg-black/95 hidden flex justify-center items-center p-4 backdrop-blur-sm transition-opacity duration-300 opacity-0">
        <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white/80 hover:text-gold text-4xl focus:outline-none transition-colors z-[200]">
            <i class="fas fa-times"></i>
        </button>
        <img id="lightbox-img" src="" class="max-h-[85vh] max-w-[95vw] shadow-2xl object-contain">
    </div>

    <script>
        function loadMoreImages() {
            document.querySelectorAll('.gallery-hidden').forEach(img => {
                img.classList.remove('hidden');
                img.style.opacity = 0;
                setTimeout(() => img.style.opacity = 1, 50);
            });
            document.getElementById('loadMoreBtn').style.display = 'none';
        }

        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');

        function openLightbox(src) {
            lightboxImg.src = src;
            lightbox.classList.remove('hidden');
            setTimeout(() => lightbox.classList.remove('opacity-0'), 10);
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.classList.add('opacity-0');
            setTimeout(() => {
                lightbox.classList.add('hidden');
                lightboxImg.src = '';
            }, 300);
            document.body.style.overflow = 'auto';
        }

        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) closeLightbox();
        });
        
        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape") closeLightbox();
        });
    </script>
</body>
</html>