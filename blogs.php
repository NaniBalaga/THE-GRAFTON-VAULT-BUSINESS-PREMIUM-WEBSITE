<?php
// blogs.php
// --- CONFIGURATION ---
ini_set('display_errors', 0);
error_reporting(E_ALL);
include 'db.php';

// Fetch Blog Posts (Showing all, or you can add LIMIT if preferred)
$sql = "SELECT * FROM blog_posts ORDER BY created_at DESC";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth no-scrollbar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Journal - Grafton Vault</title>
    
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
                        darkGold: '#8B6C2E' 
                    },
                    fontFamily: { 
                        serif: ['"Libre Baskerville"', 'serif'], 
                        sans: ['"Lato"', 'sans-serif'],
                        cinzel: ['Cinzel', 'serif']
                    },
                    backgroundImage: { 
                        'diamond-pattern': 'url("data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23B29243\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")'
                    },
                    animation: { 'fade-in': 'fade-in 0.8s ease-out' },
                    keyframes: { 'fade-in': { '0%': { opacity: 0, transform: 'translateY(20px)' }, '100%': { opacity: 1, transform: 'translateY(0)' } } }
                }
            }
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        body { overflow-x: hidden; }
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

    <section class="bg-navy pt-24 pb-32 relative overflow-hidden">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full text-center pointer-events-none overflow-hidden select-none">
            <span class="block text-[12vw] md:text-[15vw] font-cinzel font-bold text-white/[0.03] whitespace-nowrap parallax-text leading-none" data-speed="0.05">
                THE JOURNAL
            </span>
        </div>

        <div class="container mx-auto px-6 text-center relative z-10 animate-fade-in">
            <span class="text-gold text-xs font-bold tracking-[0.3em] uppercase block mb-4">Stories of Elegance</span>
            <h1 class="text-4xl md:text-6xl font-cinzel text-white mb-6">Our Journal</h1>
            <div class="h-px w-24 bg-gradient-to-r from-transparent via-gold to-transparent mx-auto mb-6"></div>
            <p class="text-white/60 font-sans text-sm md:text-base max-w-xl mx-auto">
                Insights, heritage, and news from the world of Grafton Vault.
            </p>
        </div>
    </section>

    <section class="py-20 -mt-16 relative z-20 bg-cream">
        <div class="absolute inset-0 bg-diamond-pattern opacity-5 pointer-events-none"></div>
        
        <div class="container mx-auto px-4 md:px-8 relative z-10">
            <?php if ($res->num_rows > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                    <?php while($b = $res->fetch_assoc()): ?>
                        
                        <a href="blog_info.php?item=<?php echo $b['id']; ?>" class="group flex flex-col bg-white shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-navy/5 overflow-hidden rounded-sm">
                            
                            <div class="h-64 overflow-hidden relative shrink-0">
                                <img src="<?php echo htmlspecialchars($b['cover_image']); ?>" 
                                     alt="<?php echo htmlspecialchars($b['title']); ?>" 
                                     class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-navy/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                
                                <div class="absolute top-0 left-0 bg-white/95 backdrop-blur-sm px-4 py-3 shadow-md border-r-2 border-b-2 border-gold/20">
                                    <div class="text-center">
                                        <span class="block text-xl font-cinzel font-bold text-navy leading-none"><?php echo date('d', strtotime($b['created_at'])); ?></span>
                                        <span class="block text-[9px] font-sans font-bold uppercase tracking-widest text-gold"><?php echo date('M', strtotime($b['created_at'])); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-8 flex flex-col flex-grow relative">
                                <div class="absolute top-0 right-0 w-20 h-20 bg-gold/5 rounded-bl-full -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-150"></div>

                                <div class="relative z-10">
                                    <span class="text-[10px] font-sans font-bold uppercase tracking-[0.2em] text-gold mb-3 block">Editorial</span>
                                    
                                    <h2 class="text-2xl font-cinzel text-navy mb-4 leading-snug group-hover:text-gold transition-colors duration-300">
                                        <?php echo htmlspecialchars($b['title']); ?>
                                    </h2>
                                    
                                    <p class="text-navy/60 font-sans text-sm leading-relaxed line-clamp-3 mb-6">
                                        <?php echo htmlspecialchars($b['subtitle']); ?>
                                    </p>
                                </div>

                                <div class="mt-auto pt-6 border-t border-navy/5 flex justify-between items-center">
                                    <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-navy group-hover:text-gold transition-colors duration-300">
                                        Read Article
                                        <i class="fas fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                                    </span>
                                    <i class="fas fa-book-open text-navy/10 group-hover:text-gold/20 text-2xl transition-colors"></i>
                                </div>
                            </div>
                        </a>

                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-24 border border-dashed border-navy/10">
                    <p class="text-navy/50 font-serif text-xl italic">No journal entries found.</p>
                </div>
            <?php endif; ?>
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

    <script>
        document.addEventListener('scroll', () => {
            const scroll = window.pageYOffset;
            const text = document.querySelector('.parallax-text');
            if(text) {
                const speed = text.dataset.speed;
                // Move text horizontally based on scroll
                text.style.transform = `translateX(${scroll * speed * -1}px)`;
            }
        });
    </script>

</body>
</html>