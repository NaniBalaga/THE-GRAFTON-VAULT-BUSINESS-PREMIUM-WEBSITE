<?php
// reviews.php
// --- CONFIGURATION ---
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'db.php';

// Calculate Average Rating
$avg_res = $conn->query("SELECT AVG(rating) as avg_rating, COUNT(*) as count FROM reviews");
$avg_data = $avg_res->fetch_assoc();
$average = number_format($avg_data['avg_rating'], 1);
$count = $avg_data['count'];
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth no-scrollbar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Reviews - The Grafton Vault</title>
    
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
                        cinzel: ['Cinzel', 'serif']
                    },
                    animation: {
                        'fade-in': 'fade-in 0.8s ease-out'
                    },
                    keyframes: {
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
        body { overflow-x: hidden; text-decoration: none; }
        
        .decorative-border {
            
            border: 1px solid transparent;
            background: linear-gradient(#fff, #fff) padding-box,
                      linear-gradient(45deg, #B29243, transparent, #B29243) border-box;
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

    <section class="bg-navy pt-16 pb-24 md:pt-20 md:pb-32 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-t from-cream to-transparent opacity-5 pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-64 h-64 md:w-96 md:h-96 bg-gold/10 rounded-full blur-[80px] pointer-events-none"></div>
        
        <div class="container mx-auto px-4 md:px-6 text-center relative z-10 animate-fade-in">
            <span class="text-gold text-[10px] md:text-xs font-bold tracking-[0.3em] uppercase block mb-3 md:mb-4">Client Testimonials</span>
            <h1 class="text-3xl md:text-6xl font-cinzel text-white mb-4 md:mb-6">Experience Excellence</h1>
            <div class="h-px w-16 md:w-24 bg-gradient-to-r from-transparent via-gold to-transparent mx-auto mb-6 md:mb-8"></div>
            
            <div class="inline-flex items-center gap-3 md:gap-4 bg-white/5 border border-white/10 backdrop-blur-sm px-4 md:px-6 py-2 md:py-3 rounded-full mb-6 md:mb-8 hover:bg-white/10 transition-colors">
                <img src="https://image.similarpng.com/file/similarpng/very-thumbnail/2020/12/Illustration-of-Google-icon-on-transparent-background-PNG.png" alt="Google" class="w-5 h-5 md:w-6 md:h-6">
                <div class="text-left">
                    <div class="flex items-center gap-1 text-gold text-xs md:text-sm">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-[10px] md:text-xs text-white/60 font-sans tracking-wide">Rated <span class="text-white font-bold"><?php echo $average; ?>/5.0</span> based on <?php echo $count; ?> reviews</p>
                </div>
            </div>

            <p class="text-white/60 font-sans text-xs md:text-base max-w-lg mx-auto leading-relaxed">
                Trusted by collectors worldwide. Read what our distinguished clients have to say about their journey with The Grafton Vault.
            </p>
        </div>
    </section>

    <section class="py-16 md:py-24 -mt-16 md:-mt-20 relative z-20 bg-cream">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <?php
                $sql = "SELECT * FROM reviews ORDER BY id DESC";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while($rev = $result->fetch_assoc()) {
                        // Generate star rating string
                        $stars = str_repeat('<i class="fas fa-star"></i>', $rev['rating']);
                        
                        echo '
                        <div class="bg-white decorative-border p-6 md:p-8 shadow-lg relative group hover:-translate-y-2 transition-transform duration-500">
                            <div class="absolute top-6 right-6 text-gold/10 text-4xl font-serif group-hover:text-gold/30 transition-colors">
                                "
                            </div>

                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-10 h-10 md:w-12 md:h-12 bg-navy text-gold rounded-full flex items-center justify-center font-cinzel font-bold text-lg md:text-xl shadow-md border border-gold/30">
                                    '.htmlspecialchars($rev['reviewer_initial']).'
                                </div>
                                <div>
                                    <h4 class="font-bold text-navy font-cinzel text-sm md:text-base">'.htmlspecialchars($rev['reviewer_name']).'</h4>
                                    <div class="flex text-gold text-[10px] md:text-xs mt-1 gap-0.5">
                                        '.$stars.'
                                    </div>
                                </div>
                            </div>

                            <p class="font-serif italic text-sm md:text-base leading-relaxed text-navy/80 mb-6 relative z-10">
                                "'.htmlspecialchars($rev['review_text']).'"
                            </p>

                            <div class="border-t border-gray-100 pt-4 flex justify-between items-center text-[10px] md:text-xs font-sans text-gray-400 uppercase tracking-widest">
                                <span class="flex items-center gap-1 text-navy/60"><i class="fas fa-check-circle text-gold"></i> Verified</span>
                                <span>'.htmlspecialchars($rev['date_posted']).'</span>
                            </div>
                        </div>';
                    }
                } else {
                    echo '<div class="col-span-full text-center py-12">
                            <i class="far fa-comment-dots text-4xl text-gold/30 mb-4"></i>
                            <p class="text-navy font-cinzel text-lg">No reviews yet.</p>
                          </div>';
                }
                ?>
            </div>
        
        </div>
    </section>

    <footer class="bg-navy text-white py-10 md:py-12 border-t border-white/10 text-center relative">
        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-3/4 h-px bg-gradient-to-r from-transparent via-gold/30 to-transparent"></div>
        <div class="container mx-auto px-6">
            <div class="flex flex-col items-center justify-center gap-4 md:gap-6 mb-6 md:mb-8">
                <a href="#" class="text-xl md:text-3xl font-bold uppercase tracking-widest font-cinzel">
                    Grafton <span class="font-light">Vault</span>
                </a>
            </div>
            <p class="font-sans text-[10px] md:text-xs text-white/40 tracking-widest uppercase">© <?php echo date("Y"); ?> The Grafton Vault. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>