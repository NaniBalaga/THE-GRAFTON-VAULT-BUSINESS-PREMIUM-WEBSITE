<?php
// contact_us.php
// --- CONFIGURATION ---
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'db.php';

// --- CONTACT HANDLER ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_contact'])) {
    header("Location: submit_contact_handle.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth no-scrollbar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>Contact Concierge - The Grafton Vault</title>
    
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
        
        /* Prevent horizontal scroll on mobile */
        body { 
            overflow-x: hidden; 
            width: 100%;
            max-width: 100%;
        }
        
        .reveal-left { 
            animation: fade-in 1s ease-out forwards; 
        }
        .reveal-right { 
            animation: fade-in 1s ease-out 0.3s forwards; 
            opacity: 0; 
        }
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Better touch targets for mobile */
        input, select, textarea, button, a {
            touch-action: manipulation;
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

    <section class="bg-navy pt-24 pb-24 md:pt-32 md:pb-40 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-t from-cream to-transparent opacity-5 pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-64 h-64 md:w-96 md:h-96 bg-gold/10 rounded-full blur-[80px] md:blur-[100px] pointer-events-none"></div>
        
        <div class="container mx-auto px-4 md:px-6 text-center relative z-10 animate-fade-in">
            <span class="text-gold text-[10px] md:text-xs font-bold tracking-[0.3em] uppercase block mb-3 md:mb-4">At Your Service</span>
            <h1 class="text-3xl md:text-6xl font-cinzel text-white mb-4 md:mb-6">Contact Concierge</h1>
            <div class="h-px w-16 md:w-24 bg-gradient-to-r from-transparent via-gold to-transparent mx-auto mb-4 md:mb-6"></div>
            <p class="text-white/60 font-sans text-xs md:text-base max-w-xl mx-auto leading-relaxed px-4">
                Begin your journey with The Grafton Vault. Schedule a private consultation or inquire about our bespoke services.
            </p>
        </div>
    </section>

    <section class="py-12 md:py-24 -mt-12 md:-mt-20 relative z-20 bg-cream">
        <div class="absolute inset-0 bg-diamond-pattern opacity-5 pointer-events-none"></div>
        
        <div class="absolute bottom-0 left-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-navy/5 rounded-full blur-[80px] md:blur-[100px] pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-[200px] md:w-[400px] h-[200px] md:h-[400px] bg-gold/10 rounded-full blur-[80px] md:blur-[100px] pointer-events-none"></div>

        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-24 items-start">
                
                <div class="lg:col-span-5 pt-4 text-center lg:text-left reveal-left order-1">
                    <span class="font-sans text-gold text-[10px] font-bold tracking-[0.3em] uppercase block mb-4 md:mb-6">Appointment Request</span>
                    <h2 class="text-3xl md:text-5xl text-navy mb-6 md:mb-8 font-cinzel leading-tight">Private <br><span class="italic text-gold">Consultation</span></h2>
                    
                    <p class="font-sans text-navy/70 text-sm md:text-base leading-loose mb-8 md:mb-12">
                        Your time is the ultimate luxury. Schedule a bespoke appointment to discuss your unique requirements. Our specialists are at your disposal to ensure a seamless experience.
                    </p>

                    <div class="space-y-8 md:space-y-10 border-t border-navy/10 pt-8 md:pt-10">
                        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-4 md:gap-5 text-navy/80 group">
                            <div class="w-10 h-10 md:w-12 md:h-12 rounded-full border border-navy/10 flex items-center justify-center text-gold shrink-0 group-hover:bg-navy group-hover:border-navy group-hover:text-white transition-all duration-300">
                                <i class="fas fa-map-marker-alt text-base md:text-lg"></i>
                            </div>
                            <div class="text-center lg:text-left">
                                <span class="block font-bold font-cinzel text-base md:text-lg">Grafton Chambers</span>
                                <span class="font-sans text-xs md:text-sm block mt-1 opacity-70 leading-relaxed">85 Grafton Street<br>Dublin 2, Ireland</span>
                            </div>
                        </div>
                        
                        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-4 md:gap-5 text-navy/80 group">
                            <div class="w-10 h-10 md:w-12 md:h-12 rounded-full border border-navy/10 flex items-center justify-center text-gold shrink-0 group-hover:bg-navy group-hover:border-navy group-hover:text-white transition-all duration-300">
                                <i class="fas fa-clock text-base md:text-lg"></i>
                            </div>
                            <div class="text-center lg:text-left">
                                <span class="block font-bold font-cinzel text-base md:text-lg">Opening Hours</span>
                                <span class="font-sans text-xs md:text-sm block mt-1 opacity-70 leading-relaxed">Mon - Sun: 10am - 4:30pm<br>Sunday: By Appointment</span>
                            </div>
                        </div>

                        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-4 md:gap-5 text-navy/80 group">
                            <div class="w-10 h-10 md:w-12 md:h-12 rounded-full border border-navy/10 flex items-center justify-center text-gold shrink-0 group-hover:bg-navy group-hover:border-navy group-hover:text-white transition-all duration-300">
                                <i class="fas fa-envelope text-base md:text-lg"></i>
                            </div>
                            <div class="text-center lg:text-left">
                                <span class="block font-bold font-cinzel text-base md:text-lg">Direct Line</span>
                                <span class="font-sans text-xs md:text-sm block mt-1 opacity-70 leading-relaxed">concierge@graftonvault.com<br>+353 1 234 5678</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hidden lg:block lg:col-span-1 flex justify-center pt-8 order-2">
                    <div class="h-[600px] w-px bg-gradient-to-b from-transparent via-gold/40 to-transparent"></div>
                </div>

                <div class="lg:col-span-6 reveal-right pt-4 order-3">
                    <form method="POST" action="submit_contact_handle.php" class="space-y-8 md:space-y-12 bg-white/50 md:bg-transparent p-6 md:p-0 rounded-lg md:rounded-none border border-white/50 md:border-none shadow-sm md:shadow-none">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10">
                            <div class="relative z-0 w-full group">
                                <input type="text" name="fullname" id="fullname" class="block py-3 md:py-4 px-0 w-full text-sm md:text-base text-navy bg-transparent border-0 border-b border-navy/20 appearance-none focus:outline-none focus:ring-0 focus:border-gold peer" placeholder=" " required />
                                <label for="fullname" class="peer-focus:font-medium absolute text-sm text-navy/50 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-gold peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 font-sans uppercase tracking-wider">Full Name</label>
                                <div class="absolute bottom-0 left-0 w-0 h-px bg-gold transition-all duration-500 group-focus-within:w-full"></div>
                            </div>

                            <div class="relative z-0 w-full group">
                                <input type="email" name="email" id="email" class="block py-3 md:py-4 px-0 w-full text-sm md:text-base text-navy bg-transparent border-0 border-b border-navy/20 appearance-none focus:outline-none focus:ring-0 focus:border-gold peer" placeholder=" " required />
                                <label for="email" class="peer-focus:font-medium absolute text-sm text-navy/50 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-gold peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 font-sans uppercase tracking-wider">Email Address</label>
                                <div class="absolute bottom-0 left-0 w-0 h-px bg-gold transition-all duration-500 group-focus-within:w-full"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10">
                            <div class="relative z-0 w-full group">
                                <input type="tel" name="phone" id="phone" class="block py-3 md:py-4 px-0 w-full text-sm md:text-base text-navy bg-transparent border-0 border-b border-navy/20 appearance-none focus:outline-none focus:ring-0 focus:border-gold peer" placeholder=" " />
                                <label for="phone" class="peer-focus:font-medium absolute text-sm text-navy/50 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-gold peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 font-sans uppercase tracking-wider">Phone Number</label>
                                <div class="absolute bottom-0 left-0 w-0 h-px bg-gold transition-all duration-500 group-focus-within:w-full"></div>
                            </div>

                            <div class="relative z-0 w-full group">
                                <select name="interest" id="interest" class="block py-3 md:py-4 px-0 w-full text-sm md:text-base text-navy bg-transparent border-0 border-b border-navy/20 appearance-none focus:outline-none focus:ring-0 focus:border-gold peer cursor-pointer rounded-none">
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
                                <div class="absolute bottom-0 left-0 w-0 h-px bg-gold transition-all duration-500 group-focus-within:w-full"></div>
                            </div>
                        </div>

                        <div class="relative z-0 w-full group">
                            <textarea name="message" id="message" rows="3" class="block py-3 md:py-4 px-0 w-full text-sm md:text-base text-navy bg-transparent border-0 border-b border-navy/20 appearance-none focus:outline-none focus:ring-0 focus:border-gold peer resize-none" placeholder=" "></textarea>
                            <label for="message" class="peer-focus:font-medium absolute text-sm text-navy/50 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-gold peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 font-sans uppercase tracking-wider">Additional Details</label>
                            <div class="absolute bottom-0 left-0 w-0 h-px bg-gold transition-all duration-500 group-focus-within:w-full"></div>
                        </div>

                        <div class="pt-6 md:pt-8 text-center md:text-left">
                            <button type="submit" name="submit_contact" class="group relative w-full md:w-auto inline-flex items-center justify-center overflow-hidden bg-navy px-10 py-4 md:px-14 md:py-5 text-white transition-all duration-300 hover:shadow-[0_0_30px_rgba(178,146,67,0.2)]">
                                <span class="absolute h-0 w-0 rounded-full bg-gold transition-all duration-500 ease-out group-hover:h-96 group-hover:w-full opacity-20"></span>
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



    <footer class="bg-navy text-white py-8 md:py-12 border-t border-white/10 text-center relative">
        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-3/4 h-px bg-gradient-to-r from-transparent via-gold/30 to-transparent"></div>
        <div class="container mx-auto px-6">
            <div class="flex flex-col items-center justify-center gap-4 md:gap-6 mb-6 md:mb-8">
                <a href="index.php" class="logo text-white text-2xl md:text-3xl font-bold uppercase tracking-widest font-cinzel">
                    Grafton <span class="font-light">Vault</span>
                </a>
            </div>
            <p class="font-sans text-[10px] md:text-xs text-white/40 tracking-widest uppercase">© <?php echo date("Y"); ?> The Grafton Vault. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>