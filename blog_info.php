<?php
// blog_info.php
// --- CONFIGURATION ---
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'db.php';

// 1. Validation
if (!isset($_GET['item']) || empty($_GET['item'])) {
    header("Location: blogs.php");
    exit();
}

$id = intval($_GET['item']);

// 2. Fetch Blog Details
$stmt = $conn->prepare("SELECT * FROM blog_posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$blog = $stmt->get_result()->fetch_assoc();

if (!$blog) {
    die("Article not found.");
}
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth no-scrollbar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog['title']); ?> - The Grafton Journal</title>
    
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
                    animation: { 'fade-in': 'fade-in 0.8s ease-out' },
                    keyframes: { 'fade-in': { '0%': { opacity: 0 }, '100%': { opacity: 1 } } }
                }
            }
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Typography for Reading */
        .article-content {
            white-space: pre-line;
            line-height: 1.9;
            color: #2a3b55;
        }
        .article-content p { margin-bottom: 1.5rem; }
        
        /* Drop Cap for the first letter */
        .drop-cap::first-letter {
            float: left;
            font-size: 3.5rem;
            line-height: 0.8;
            padding-right: 0.5rem;
            padding-top: 0.1rem;
            color: #B29243;
            font-family: 'Cinzel', serif;
        }

        /* Diamond Divider */
        .ornamental-divider {
            display: flex; align-items: center; justify-content: center; margin: 2rem 0; opacity: 0.5;
        }
        .ornamental-divider::before, .ornamental-divider::after {
            content: ''; height: 1px; flex-grow: 1; background: linear-gradient(90deg, transparent, #B29243, transparent);
        }
        .ornamental-icon { margin: 0 1rem; display: flex; gap: 4px; }
        .diamond-sm { width: 4px; height: 4px; background: #B29243; transform: rotate(45deg); }
        .diamond-md { width: 8px; height: 8px; background: #B29243; transform: rotate(45deg); }
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
        <img src="<?php echo htmlspecialchars($blog['cover_image']); ?>" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-navy/70 flex flex-col items-center justify-center p-6">
            <div class="text-center animate-fade-in max-w-3xl">
                <div class="flex items-center justify-center gap-4 mb-4 text-gold/80 font-sans text-[10px] md:text-xs font-bold uppercase tracking-[0.2em]">
                    <span><?php echo date('F d, Y', strtotime($blog['created_at'])); ?></span>
                    <div class="w-1 h-1 bg-gold rounded-full"></div>
                    <span>Editorial</span>
                </div>

                <h1 class="text-2xl md:text-5xl text-white font-cinzel tracking-wide leading-tight mb-6">
                    <?php echo htmlspecialchars($blog['title']); ?>
                </h1>
                
                <div class="w-16 h-px bg-gold mx-auto"></div>
            </div>
        </div>
    </div>

    <section class="py-12 px-4 md:px-12 bg-cream">
        <div class="max-w-2xl mx-auto">
            
            <p class="text-lg md:text-xl text-navy/80 font-serif italic text-center mb-8 leading-relaxed">
                "<?php echo htmlspecialchars($blog['subtitle']); ?>"
            </p>

            <div class="ornamental-divider">
                <div class="ornamental-icon">
                    <div class="diamond-sm"></div><div class="diamond-md"></div><div class="diamond-sm"></div>
                </div>
            </div>

            <div class="article-content drop-cap text-sm md:text-lg font-serif text-justify md:text-left">
                <?php echo trim($blog['content']); ?>
            </div>

            <div class="ornamental-divider">
                <div class="ornamental-icon">
                    <div class="diamond-sm"></div><div class="diamond-md"></div><div class="diamond-sm"></div>
                </div>
            </div>

            <div class="text-center mt-12">
                <div class="inline-block border border-navy/10 p-1 rounded-full mb-4">
                    <div class="w-12 h-12 bg-navy text-gold flex items-center justify-center rounded-full font-cinzel text-lg">
                        G
                    </div>
                </div>
                <p class="text-xs font-sans font-bold uppercase tracking-widest text-navy/60">Published by The Grafton Vault</p>
            </div>

        </div>
    </section>

    <footer class="bg-navy text-white py-8 border-t border-white/10 text-center">
        <div class="container mx-auto px-6">
            <p class="font-sans text-[10px] md:text-xs text-white/40 tracking-widest uppercase">© <?php echo date("Y"); ?> The Grafton Vault. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>