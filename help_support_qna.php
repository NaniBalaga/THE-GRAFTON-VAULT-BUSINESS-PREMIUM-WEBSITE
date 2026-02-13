<?php
// help_support_qna.php
// --- CONFIGURATION ---
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'db.php';

// Fetch All FAQs
$f_sql = "SELECT * FROM faqs ORDER BY id DESC";
$f_res = $conn->query($f_sql);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth no-scrollbar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Center - The Grafton Vault</title>
    
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
                    },
                    fontFamily: { 
                        serif: ['"Libre Baskerville"', 'serif'], 
                        sans: ['"Lato"', 'sans-serif'],
                        cinzel: ['Cinzel', 'serif'],
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
        
        .faq-answer { 
            max-height: 0; 
            overflow: hidden; 
            transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1), padding 0.5s ease; 
        }
        .group.active .faq-answer { 
            max-height: 1000px; 
            padding-bottom: 1.5rem; 
        }
        .group.active .faq-icon { 
            transform: rotate(180deg); 
            color: #B29243; 
        }
        .diamond-shape {
            width: 6px; height: 6px; background: #B29243; transform: rotate(45deg);
        }
        @media (min-width: 768px) {
            .diamond-shape { width: 8px; height: 8px; }
        }
    </style>
</head>
<body class="bg-cream text-navy antialiased font-serif">

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

    <section class="bg-navy pt-16 pb-20 md:pt-24 md:pb-32 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-t from-cream via-transparent to-transparent opacity-5"></div>
        <div class="absolute top-0 right-0 w-64 h-64 md:w-96 md:h-96 bg-gold/10 rounded-full blur-[80px] md:blur-[100px]"></div>
        
        <div class="container mx-auto px-4 md:px-6 text-center relative z-10 animate-fade-in">
            <span class="text-gold text-[10px] md:text-xs font-bold tracking-[0.2em] uppercase block mb-3 md:mb-4">Support Center</span>
            <h1 class="text-3xl md:text-5xl font-cinzel text-white mb-4 md:mb-6">Frequently Asked Questions</h1>
            <p class="text-white/60 font-sans text-xs md:text-base max-w-xl mx-auto mb-8 md:mb-10 leading-relaxed px-4">
                Browse our comprehensive guide to services, appointments, and policies.
            </p>

            <div class="max-w-xl mx-auto relative px-2 md:px-0">
                <input type="text" id="faqSearch" onkeyup="filterFAQs()" placeholder="Search keywords..." 
                       class="w-full py-3 px-5 md:py-4 md:px-6 rounded-sm bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:bg-white/20 focus:border-gold transition-all font-sans text-xs md:text-sm backdrop-blur-sm">
                <i class="fas fa-search absolute right-6 top-1/2 transform -translate-y-1/2 text-gold text-xs md:text-sm"></i>
            </div>
        </div>
    </section>

    <section class="py-12 md:py-20 -mt-8 md:-mt-16 relative z-20">
        <div class="container mx-auto px-4 md:px-6 max-w-4xl">
            <div class="bg-white shadow-xl rounded-sm p-4 md:p-10 border-t-4 border-gold" id="faqContainer">
                
                <?php if ($f_res->num_rows > 0): ?>
                    <div class="space-y-3 md:space-y-4">
                        <?php while($f = $f_res->fetch_assoc()): ?>
                        <div class="faq-item border-b border-gray-100 last:border-0 group transition-all duration-300">
                            <button class="w-full text-left py-4 md:py-6 flex justify-between items-start md:items-center focus:outline-none hover:pl-2 transition-all duration-300" onclick="toggleFaq(this)">
                                <span class="font-bold text-navy text-xs md:text-sm uppercase tracking-wider flex items-start md:items-center gap-3 md:gap-4 faq-question leading-relaxed">
                                    <div class="diamond-shape shrink-0 mt-1 md:mt-0"></div>
                                    <?php echo htmlspecialchars($f['question']); ?>
                                </span>
                                <i class="fas fa-chevron-down text-gold/70 text-xs md:text-sm transform transition-transform duration-300 faq-icon shrink-0 ml-4 mt-1 md:mt-0"></i>
                            </button>
                            <div class="faq-answer text-gray-600 text-xs md:text-sm leading-relaxed pl-5 md:pl-8">
                                <div class="pb-4 md:pb-6 max-w-3xl">
                                    <?php echo nl2br(htmlspecialchars($f['answer'])); ?>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center text-gray-500 py-10 text-sm">No questions found.</p>
                <?php endif; ?>

                <div id="noResults" class="hidden text-center py-12">
                    <i class="far fa-question-circle text-3xl md:text-4xl text-gray-300 mb-4"></i>
                    <p class="text-navy font-sans text-sm">No matching questions found.</p>
                    <button onclick="document.getElementById('faqSearch').value=''; filterFAQs();" class="text-gold text-xs font-bold uppercase tracking-widest mt-4 hover:text-navy cursor-pointer border-b border-gold pb-1">Clear Search</button>
                </div>

            </div>

            <div class="mt-12 md:mt-16 text-center animate-fade-in px-4">
                <h3 class="font-cinzel text-xl md:text-2xl text-navy mb-3 md:mb-4">Still have questions?</h3>
                <p class="text-gray-600 font-sans text-xs md:text-sm mb-6 md:mb-8">Can’t find the answer you’re looking for? Please contact our concierge directly.</p>
                <a href="contact_us.php" class="inline-block bg-navy text-white px-8 py-3 md:px-10 md:py-4 font-sans text-[10px] md:text-xs font-bold uppercase tracking-[0.2em] hover:bg-gold transition-colors shadow-lg">
                    Contact Concierge
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-navy text-white py-8 border-t border-white/10 text-center">
        <div class="container mx-auto px-6">
            <p class="font-sans text-[10px] md:text-xs text-white/40 tracking-widest uppercase">© <?php echo date("Y"); ?> The Grafton Vault. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Toggle Accordion
        function toggleFaq(element) {
            const parent = element.parentElement;
            
            // Optional: Close others when one opens (Accordion effect)
            // const allItems = document.querySelectorAll('.faq-item');
            // allItems.forEach(item => {
            //     if (item !== parent && item.classList.contains('active')) {
            //         item.classList.remove('active');
            //     }
            // });

            parent.classList.toggle('active');
        }

        // Search/Filter Function
        function filterFAQs() {
            const input = document.getElementById('faqSearch');
            const filter = input.value.toUpperCase();
            const container = document.getElementById('faqContainer');
            const items = container.getElementsByClassName('faq-item');
            let hasVisible = false;

            for (let i = 0; i < items.length; i++) {
                const questionSpan = items[i].getElementsByClassName("faq-question")[0];
                const txtValue = questionSpan.textContent || questionSpan.innerText;
                
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    items[i].style.display = "";
                    hasVisible = true;
                } else {
                    items[i].style.display = "none";
                }
            }

            // Show/Hide No Results message
            const noResults = document.getElementById('noResults');
            if (!hasVisible) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }
    </script>
</body>
</html>