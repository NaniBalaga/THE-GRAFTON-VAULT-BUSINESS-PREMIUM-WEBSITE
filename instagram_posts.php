<?php
// instagram_posts.php
// --- CONFIGURATION ---
ini_set('display_errors', 0);
error_reporting(E_ALL);
include 'db.php';

// Fetch All Instagram Posts
$sql = "SELECT * FROM instagram_posts ORDER BY created_at DESC";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth no-scrollbar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Social Edit - The Grafton Vault</title>
    
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
                        cream: '#f7f0e3', // Biscuit Color
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
                        'diamond-pattern': 'url("data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23B29243\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")'
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
        body { overflow-x: hidden; background-color: #f7f0e3; }
        
        /* Thread Animation (Dark Line for Light BG) */
        .draw-line {
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000;
            animation: draw 3s ease-out forwards;
        }
        @keyframes draw { to { stroke-dashoffset: 0; } }

        /* Animation Delays */
        .gallery-item { opacity: 0; animation: fade-in 0.8s ease-out forwards; }
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

    <section class="bg-navy pt-16 pb-24 md:pt-20 md:pb-32 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gold/5 rounded-full blur-[100px] pointer-events-none"></div>
        
        <div class="container mx-auto px-6 text-center relative z-10 animate-fade-in">
            <div class="inline-flex items-center gap-2 text-gold mb-3">
                <i class="fab fa-instagram text-xl"></i>
                <span class="text-[10px] md:text-xs font-bold tracking-[0.3em] uppercase">@TheGraftonVault</span>
            </div>
            
            <h1 class="text-3xl md:text-6xl font-cinzel text-white mb-4">The Social Edit</h1>
            <div class="h-px w-16 md:w-24 bg-gradient-to-r from-transparent via-gold to-transparent mx-auto mb-4"></div>
            <p class="text-white/60 font-sans text-xs md:text-sm max-w-lg mx-auto">
                Follow our journey of bespoke craftsmanship and curated luxury.
            </p>
        </div>
    </section>

    <section class="pb-24 -mt-12 relative z-20 min-h-screen">
        <div class="absolute inset-0 bg-diamond-pattern opacity-5 pointer-events-none"></div>

        <div class="absolute inset-0 pointer-events-none z-0 opacity-20">
            <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 100 100">
                <path d="M0,10 Q25,10 25,40 T50,70 T75,40 T100,10" fill="none" stroke="#0A1A33" stroke-width="0.15" class="draw-line" />
            </svg>
        </div>

        <div class="container mx-auto px-3 md:px-6 relative z-10">
            <?php if($res->num_rows > 0): ?>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-8">
                    <?php 
                    $delay = 0;
                    while($p = $res->fetch_assoc()): 
                        $delay += 50; 
                        $link = !empty($p['post_url']) ? $p['post_url'] : '#';
                        // Clean caption: remove tags, limit length
                        $caption = !empty($p['caption']) ? htmlspecialchars(substr($p['caption'], 0, 50)) . '...' : 'View Post';
                    ?>
                        <a href="<?php echo htmlspecialchars($link); ?>" target="_blank" 
                           class="gallery-item group block bg-white shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 rounded-sm overflow-hidden border border-navy/5"
                           style="animation-delay: <?php echo $delay; ?>ms">
                            
                            <div class="relative aspect-square overflow-hidden">
                                <img src="<?php echo htmlspecialchars($p['image_url']); ?>" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                
                                <div class="absolute top-2 right-2 bg-navy/80 text-gold p-1.5 rounded-full shadow-lg">
                                    <i class="fab fa-instagram text-[10px] md:text-xs"></i>
                                </div>
                            </div>

                            <div class="p-3 md:p-5 text-center bg-white relative">
                                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-8 h-0.5 bg-gold/50"></div>
                                
                                <p class="text-[10px] md:text-xs text-navy/70 font-sans leading-relaxed line-clamp-2 mb-2">
                                    <?php echo $caption; ?>
                                </p>
                                
                                <span class="inline-block text-[8px] md:text-[9px] uppercase tracking-widest text-gold font-bold border-b border-transparent group-hover:border-gold transition-colors">
                                    See Post
                                </span>
                            </div>
                        </a>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-20 border border-dashed border-navy/10 rounded-sm bg-white/50">
                    <p class="text-navy/50 font-serif text-lg">No posts connected yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="bg-navy text-white py-12 border-t border-white/10 text-center relative z-20">
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

</body>
</html>