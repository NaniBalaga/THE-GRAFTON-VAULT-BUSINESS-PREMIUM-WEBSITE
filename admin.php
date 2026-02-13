<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// ==========================================
// 🔐 AUTHENTICATION SYSTEM
// ==========================================

// 1. Define Credentials
$ADMIN_USER = "TGVADMIN";
$ADMIN_PASS = "Ian@TGV";

// 2. Handle Logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// 3. Handle Login Submission
$login_error = '';
if (isset($_POST['login_btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple strict comparison
    if ($username === $ADMIN_USER && $password === $ADMIN_PASS) {
        $_SESSION['tgv_admin_logged_in'] = true;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $login_error = "Invalid Username or Password";
    }
}

// 4. Check if User is Logged In
// If NOT logged in, show this Login Screen and STOP execution
if (!isset($_SESSION['tgv_admin_logged_in']) || $_SESSION['tgv_admin_logged_in'] !== true) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login - The Grafton Vault</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
            /* Custom Colors */
            .bg-navy-dark { background-color: #050b14; }
            .bg-navy-card { background-color: rgba(10, 26, 51, 0.85); }
            .text-gold { color: #b29243; }
            .border-gold { border-color: #b29243; }
            .bg-gold { background-color: #b29243; }
            
            /* Browser Autofill Fix - Keeps background dark blue */
            input:-webkit-autofill,
            input:-webkit-autofill:hover, 
            input:-webkit-autofill:focus, 
            input:-webkit-autofill:active{
                -webkit-box-shadow: 0 0 0 30px #020610 inset !important;
                -webkit-text-fill-color: #e2e8f0 !important;
                transition: background-color 5000s ease-in-out 0s;
            }
        </style>
    </head>
    <body class="bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-[#0f2444] via-[#051021] to-black flex items-center justify-center h-screen relative overflow-hidden font-sans">
        
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-[#b29243]/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="w-full max-w-sm p-8 bg-navy-card border border-white/5 border-t-white/10 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] backdrop-blur-xl relative z-10">
            
            <div class="text-center mb-8 relative">
                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 w-1/2 h-1 bg-gradient-to-r from-transparent via-[#b29243] to-transparent opacity-50"></div>
                
                <img src="temp/main_logo_bg.png" alt="Grafton Vault" class="h-24 mx-auto mb-2 object-contain drop-shadow-2xl">
                
                <h2 class="text-lg font-bold text-white uppercase tracking-[0.25em] font-serif mt-2">Grafton Vault</h2>
                <div class="flex items-center justify-center gap-2 mt-2">
                    <div class="h-px w-8 bg-gradient-to-r from-transparent to-[#b29243]"></div>
                    <p class="text-[#b29243] text-[9px] uppercase tracking-widest">Admin Panel</p>
                    <div class="h-px w-8 bg-gradient-to-l from-transparent to-[#b29243]"></div>
                </div>
            </div>

            <?php if ($login_error): ?>
                <div class="bg-red-900/20 border border-red-500/30 text-red-200 px-4 py-3 rounded text-xs text-center mb-6 tracking-wide shadow-inner">
                    <i class="fas fa-lock mr-2"></i><?php echo $login_error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-5" autocomplete="off">
                <div class="group">
                    <label class="block text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-2 ml-1 group-focus-within:text-[#b29243] transition-colors">Username ID</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-500 text-xs group-focus-within:text-[#b29243] transition-colors"></i>
                        </div>
                        <input type="text" 
                               name="username" 
                               placeholder="Enter Username" 
                               class="w-full bg-[#020610] border border-[#1e293b] text-gray-200 pl-10 pr-4 py-3 rounded-lg text-sm focus:outline-none focus:border-[#b29243] focus:ring-1 focus:ring-[#b29243]/50 transition-all duration-300 placeholder-gray-600 shadow-inner" 
                               required>
                    </div>
                </div>
                
                <div class="group">
                    <label class="block text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-2 ml-1 group-focus-within:text-[#b29243] transition-colors">Security Key</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-key text-gray-500 text-xs group-focus-within:text-[#b29243] transition-colors"></i>
                        </div>
                        <input type="password" 
                               name="password" 
                               placeholder="Enter Password" 
                               class="w-full bg-[#020610] border border-[#1e293b] text-gray-200 pl-10 pr-4 py-3 rounded-lg text-sm focus:outline-none focus:border-[#b29243] focus:ring-1 focus:ring-[#b29243]/50 transition-all duration-300 placeholder-gray-600 shadow-inner" 
                               required>
                    </div>
                </div>

                <button type="submit" name="login_btn" class="w-full mt-6 bg-gradient-to-r from-[#8a6e2f] via-[#b29243] to-[#8a6e2f] hover:bg-gradient-to-r hover:from-[#c5a655] hover:via-[#d4af37] hover:to-[#c5a655] text-[#0a1a33] font-bold py-3.5 px-4 rounded-lg shadow-[0_4px_14px_rgba(178,146,67,0.3)] hover:shadow-[0_6px_20px_rgba(178,146,67,0.4)] transition-all duration-300 uppercase tracking-[0.2em] text-xs transform hover:-translate-y-0.5 active:translate-y-0">
                    Authenticate
                </button>
            </form>
            
            <div class="mt-8 text-center opacity-40 hover:opacity-100 transition-opacity duration-300">
                <i class="fas fa-shield-alt text-[#b29243] mb-2 text-lg"></i>
                <p class="text-white text-[9px] uppercase tracking-widest">Encrypted & Secure Connection</p>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit(); // IMPORTANT: Stop loading the rest of the dashboard
}

// ==========================================
// 🔓 DASHBOARD CONTENT (Loads only if logged in)
// ==========================================

include 'db.php';

// Helper function for date grouping
function formatDateHeader($date) {
    $dateObj = new DateTime($date);
    $today = new DateTime();
    $yesterday = new DateTime('yesterday');

    if ($dateObj->format('Y-m-d') == $today->format('Y-m-d')) {
        return 'Today';
    } elseif ($dateObj->format('Y-m-d') == $yesterday->format('Y-m-d')) {
        return 'Yesterday';
    } else {
        return $dateObj->format('M d, Y');
    }
}

// Stats
$stats = [];
$stats['msg_today'] = $conn->query("SELECT COUNT(*) FROM contact_submissions WHERE DATE(submission_date) = CURDATE()")->fetch_row()[0];
$stats['msg_total'] = $conn->query("SELECT COUNT(*) FROM contact_submissions")->fetch_row()[0];
$stats['col_count'] = $conn->query("SELECT COUNT(*) FROM collections")->fetch_row()[0];
$stats['blog_count'] = $conn->query("SELECT COUNT(*) FROM blog_posts")->fetch_row()[0];
$stats['insta_count'] = $conn->query("SELECT COUNT(*) FROM instagram_posts")->fetch_row()[0];
$stats['serv_count'] = $conn->query("SELECT COUNT(*) FROM services")->fetch_row()[0];
$stats['rev_count'] = $conn->query("SELECT COUNT(*) FROM reviews")->fetch_row()[0];
$stats['gallery_count'] = $conn->query("SELECT COUNT(*) FROM shop_gallery")->fetch_row()[0];

$avg_data = $conn->query("SELECT AVG(rating) FROM reviews")->fetch_row();
$stats['avg_rating'] = number_format((float)$avg_data[0], 1);

// Fetch Banner Data
$banner_res = $conn->query("SELECT * FROM banners LIMIT 1");
$banner = $banner_res->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { colors: { navy: '#0A1A33', gold: '#B29243', cream: '#f7f0e3', darkGold: '#8B6C2E' } } } }</script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .section-view { display: none; opacity: 0; transition: opacity 0.3s ease; }
        .section-view.active { display: block; opacity: 1; }
        .nav-btn.active { background-color: rgba(255, 255, 255, 0.1); color: #B29243; border-right: 3px solid #B29243; }
        
        /* Mobile Nav Specifics */
        .mobile-nav-btn.active i { color: #B29243; }
        .mobile-nav-btn.active span { color: #0A1A33; font-weight: bold; }
        
        .modal { transition: opacity 0.3s ease, visibility 0.3s ease; opacity: 0; visibility: hidden; }
        .modal.active { opacity: 1; visibility: visible; }
        .modal-content { transform: scale(0.95); transition: transform 0.3s ease; }
        .modal.active .modal-content { transform: scale(1); }
        
        #toast { visibility: hidden; min-width: 250px; background-color: #0A1A33; color: #fff; text-align: center; border-radius: 8px; padding: 16px; position: fixed; z-index: 100; right: 30px; top: 30px; font-size: 14px; opacity: 0; transition: opacity 0.5s, top 0.5s; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-left: 4px solid #B29243; }
        #toast.show { visibility: visible; opacity: 1; top: 50px; }

        /* Date Header Line */
        .date-header { display: flex; align-items: center; margin: 2rem 0 1rem 0; }
        .date-header span { background: #f9fafb; padding-right: 1rem; color: #B29243; font-weight: bold; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; }
        .date-header::after { content: ''; flex: 1; height: 1px; background: #e5e7eb; }
        
        /* Font Cinzel */
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap');
        .font-cinzel { font-family: 'Cinzel', serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans h-screen flex overflow-hidden">

    <div id="toast" class="flex items-center justify-center gap-3 font-bold uppercase tracking-wider">
        <i class="fas fa-check-circle text-gold text-lg"></i>
        <span id="toast-message">Success</span>
    </div>

    <aside class="hidden md:flex flex-col w-64 bg-navy text-white h-full shadow-2xl z-20 shrink-0">
        <div class="p-8 border-b border-white/10"><h1 class="text-2xl font-bold uppercase tracking-widest text-gold">Grafton</h1><p class="text-[10px] text-white/50 tracking-[0.2em] uppercase mt-1">Admin Panel</p></div>
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto no-scrollbar">
            <button onclick="switchView('view-dashboard', this)" class="nav-btn active w-full flex items-center gap-4 p-4 rounded-lg hover:bg-white/5 transition-all text-xs uppercase tracking-wide font-bold text-left"><i class="fas fa-chart-line w-5 text-center"></i> Dashboard</button>
            <button onclick="switchView('view-inbox', this)" class="nav-btn w-full flex items-center gap-4 p-4 rounded-lg hover:bg-white/5 transition-all text-xs uppercase tracking-wide font-bold text-left"><i class="fas fa-envelope w-5 text-center"></i> Inbox <?php if($stats['msg_today'] > 0): ?><span class="ml-auto bg-gold text-navy text-[9px] px-2 py-0.5 rounded-full"><?php echo $stats['msg_today']; ?></span><?php endif; ?></button>
            <button onclick="switchView('view-settings', this)" class="nav-btn w-full flex items-center gap-4 p-4 rounded-lg hover:bg-white/5 transition-all text-xs uppercase tracking-wide font-bold text-left"><i class="fas fa-cog w-5 text-center"></i> Settings</button>
            <button onclick="switchView('view-collections', this)" class="nav-btn w-full flex items-center gap-4 p-4 rounded-lg hover:bg-white/5 transition-all text-xs uppercase tracking-wide font-bold text-left"><i class="fas fa-gem w-5 text-center"></i> Collections</button>
            <button onclick="switchView('view-gallery', this)" class="nav-btn w-full flex items-center gap-4 p-4 rounded-lg hover:bg-white/5 transition-all text-xs uppercase tracking-wide font-bold text-left"><i class="fas fa-images w-5 text-center"></i> Shop Gallery</button>
            <button onclick="switchView('view-faqs', this)" class="nav-btn w-full flex items-center gap-4 p-4 rounded-lg hover:bg-white/5 transition-all text-xs uppercase tracking-wide font-bold text-left"><i class="fas fa-question-circle w-5 text-center"></i> FAQs</button>
            <button onclick="switchView('view-services', this)" class="nav-btn w-full flex items-center gap-4 p-4 rounded-lg hover:bg-white/5 transition-all text-xs uppercase tracking-wide font-bold text-left"><i class="fas fa-concierge-bell w-5 text-center"></i> Services</button>
            <button onclick="switchView('view-blog', this)" class="nav-btn w-full flex items-center gap-4 p-4 rounded-lg hover:bg-white/5 transition-all text-xs uppercase tracking-wide font-bold text-left"><i class="fas fa-pen-nib w-5 text-center"></i> Blog</button>
            <button onclick="switchView('view-insta', this)" class="nav-btn w-full flex items-center gap-4 p-4 rounded-lg hover:bg-white/5 transition-all text-xs uppercase tracking-wide font-bold text-left"><i class="fab fa-instagram w-5 text-center"></i> Instagram</button>
            <button onclick="switchView('view-reviews', this)" class="nav-btn w-full flex items-center gap-4 p-4 rounded-lg hover:bg-white/5 transition-all text-xs uppercase tracking-wide font-bold text-left"><i class="fas fa-star w-5 text-center"></i> Reviews</button>
            <button onclick="switchView('view-leads', this)" class="nav-btn w-full flex items-center gap-4 p-4 rounded-lg hover:bg-white/5 transition-all text-xs uppercase tracking-wide font-bold text-left"><i class="fas fa-address-book w-5 text-center"></i> Contact Leads</button>
        </nav>
        <div class="p-6 border-t border-white/10"><a href="index.php" target="_blank" class="flex items-center justify-center gap-2 bg-white/5 text-gray-400 py-3 rounded hover:text-white transition-all text-xs font-bold uppercase tracking-widest">Exit <i class="fas fa-sign-out-alt"></i></a></div>
    </aside>

    <main class="flex-1 h-full overflow-y-auto relative no-scrollbar pb-24 md:pb-0 bg-gray-50">
        <div class="md:hidden bg-navy text-white p-4 flex justify-between items-center sticky top-0 z-30 shadow-md">
            <span class="font-bold text-gold uppercase tracking-widest">Grafton</span>
            <a href="index.php" target="_blank"><i class="fas fa-external-link-alt text-gold"></i></a>
        </div>

        <div class="p-6 md:p-10 max-w-7xl mx-auto min-h-full">
            
            <section id="view-dashboard" class="section-view active">
                <h2 class="text-3xl font-serif text-navy mb-2">Overview</h2>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center"><div class="text-4xl font-bold text-navy mb-2"><?php echo $stats['msg_total']; ?></div><div class="text-xs text-gray-400 uppercase font-bold">Inquiries</div></div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center"><div class="text-4xl font-bold text-gold mb-2"><?php echo $stats['col_count']; ?></div><div class="text-xs text-gray-400 uppercase font-bold">Collections</div></div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center"><div class="text-4xl font-bold text-navy mb-2"><?php echo $stats['gallery_count']; ?></div><div class="text-xs text-gray-400 uppercase font-bold">Gallery</div></div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center"><div class="text-4xl font-bold text-gold mb-2"><?php echo $stats['rev_count']; ?></div><div class="text-xs text-gray-400 uppercase font-bold">Reviews</div></div>
                </div>
            </section>

            <section id="view-inbox" class="section-view">
                <h2 class="text-3xl font-serif text-navy mb-8">Inbox</h2>
                <div id="inbox-container">
                    <?php
                    $msgs = $conn->query("SELECT * FROM contact_submissions ORDER BY submission_date DESC");
                    $grouped_msgs = [];
                    while($m = $msgs->fetch_assoc()) {
                        $dateKey = date('Y-m-d', strtotime($m['submission_date']));
                        $grouped_msgs[$dateKey][] = $m;
                    }
                    foreach($grouped_msgs as $date => $day_msgs):
                        $headerLabel = formatDateHeader($date);
                    ?>
                    <div class="date-group" data-date="<?php echo $headerLabel; ?>">
                        <div class="date-header"><span><?php echo $headerLabel; ?></span></div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php foreach($day_msgs as $m): ?>
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative group" id="msg-<?php echo $m['id']; ?>">
                                <div class="mb-4">
                                    <h3 class="font-bold text-lg text-navy"><?php echo htmlspecialchars($m['fullname']); ?></h3>
                                    <div class="flex flex-col text-xs text-gray-500 mt-1"><span><?php echo htmlspecialchars($m['email']); ?></span><span><?php echo htmlspecialchars($m['phone']); ?></span></div>
                                </div>
                                <div class="mb-4"><span class="inline-block bg-navy/5 text-navy text-[10px] font-bold uppercase px-2 py-1 rounded"><?php echo htmlspecialchars($m['interest']); ?></span></div>
                                <div class="bg-gray-50 p-3 rounded border border-gray-100 mb-4 h-24 overflow-y-auto"><p class="text-sm text-gray-600 italic">"<?php echo htmlspecialchars($m['message']); ?>"</p></div>
                                <div class="flex gap-2 pt-2 border-t border-gray-100">
                                    <a href="mailto:<?php echo htmlspecialchars($m['email']); ?>" class="flex-1 bg-navy text-white text-center py-2 rounded text-xs font-bold uppercase hover:bg-gold">Reply</a>
                                    <button onclick="deleteItem(<?php echo $m['id']; ?>, 'message')" class="w-8 flex items-center justify-center text-gray-400 hover:text-red-500"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>

<section id="view-leads" class="section-view">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-serif text-navy">Contact Leads</h2>
            <p class="text-gray-500 text-sm mt-1">Manage and track incoming inquiries.</p>
        </div>
        <div class="flex gap-3">
            <button onclick="exportLeadsToExcel()" class="group flex items-center gap-2 bg-white border border-navy/10 text-navy px-5 py-2.5 rounded-full font-bold uppercase text-[10px] tracking-widest hover:bg-green-600 hover:text-white hover:border-green-600 transition-all shadow-sm">
                <i class="fas fa-file-excel text-green-600 group-hover:text-white transition-colors"></i> 
                <span>Export Excel</span>
            </button>
            <button onclick="window.print()" class="group flex items-center gap-2 bg-white border border-navy/10 text-navy px-5 py-2.5 rounded-full font-bold uppercase text-[10px] tracking-widest hover:bg-navy hover:text-white transition-all shadow-sm">
                <i class="fas fa-print text-gold group-hover:text-white transition-colors"></i> 
                <span>Print Report</span>
            </button>
        </div>
    </div>

    <div class="space-y-10">
        <?php
        // Fetch all submissions ordered by date
        $lead_sql = "SELECT * FROM contact_submissions ORDER BY submission_date DESC";
        $lead_res = $conn->query($lead_sql);
        
        $grouped_leads = [];
        if ($lead_res && $lead_res->num_rows > 0) {
            while ($l = $lead_res->fetch_assoc()) {
                // Group by "Month Year" (e.g., January 2026)
                $monthKey = date('F Y', strtotime($l['submission_date']));
                $grouped_leads[$monthKey][] = $l;
            }

            foreach ($grouped_leads as $month => $leads):
        ?>
        
        <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden relative">
            <div class="h-1 w-full bg-gradient-to-r from-navy via-gold to-navy"></div>

            <div class="px-6 py-5 border-b border-gray-100 flex flex-wrap justify-between items-center bg-gray-50/30 gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-navy text-gold flex items-center justify-center text-xs">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <h3 class="font-cinzel text-navy font-bold text-xl tracking-wide"><?php echo $month; ?></h3>
                </div>
                <span class="bg-gold/10 text-darkGold text-[10px] font-bold px-3 py-1 rounded-full border border-gold/20 uppercase tracking-wider">
                    <?php echo count($leads); ?> Inquiries
                </span>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left whitespace-nowrap lead-table">
                    <thead>
                        <tr class="bg-navy text-white text-[10px] uppercase tracking-[0.15em]">
                            <th class="px-6 py-4 font-normal">Date & Time</th>
                            <th class="px-6 py-4 font-normal">Client Name</th>
                            <th class="px-6 py-4 font-normal">Contact Details</th>
                            <th class="px-6 py-4 font-normal">Interest</th>
                            <th class="px-6 py-4 font-normal text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <?php foreach ($leads as $lead): 
                             // Prepare clean data for export attributes
                             $exportDate = date('Y-m-d H:i', strtotime($lead['submission_date']));
                        ?>
                        <tr class="group hover:bg-cream/20 transition-colors duration-200 lead-row" 
                            id="lead-msg-<?php echo $lead['id']; ?>"
                            data-date="<?php echo $exportDate; ?>"
                            data-name="<?php echo htmlspecialchars($lead['fullname']); ?>"
                            data-phone="<?php echo htmlspecialchars($lead['phone']); ?>"
                            data-email="<?php echo htmlspecialchars($lead['email']); ?>"
                            data-interest="<?php echo htmlspecialchars($lead['interest']); ?>"
                            data-message="<?php echo htmlspecialchars(str_replace(array("\r", "\n"), ' ', $lead['message'])); ?>">
                            
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-navy font-cinzel">
                                        <?php echo date('d M Y', strtotime($lead['submission_date'])); ?>
                                    </span>
                                    <span class="text-xs text-gray-400 uppercase tracking-wider">
                                        <?php echo date('H:i', strtotime($lead['submission_date'])); ?>
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-navy font-bold text-xs group-hover:bg-gold group-hover:text-white transition-colors">
                                        <?php echo strtoupper(substr($lead['fullname'], 0, 1)); ?>
                                    </div>
                                    <span class="font-bold text-navy"><?php echo htmlspecialchars($lead['fullname']); ?></span>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <a href="tel:<?php echo htmlspecialchars($lead['phone']); ?>" class="text-gray-600 hover:text-gold transition-colors text-xs flex items-center gap-2">
                                        <i class="fas fa-phone-alt text-[10px] opacity-50"></i> <?php echo htmlspecialchars($lead['phone']); ?>
                                    </a>
                                    <a href="mailto:<?php echo htmlspecialchars($lead['email']); ?>" class="text-navy hover:text-gold transition-colors text-xs font-medium flex items-center gap-2">
                                        <i class="fas fa-envelope text-[10px] opacity-50"></i> <?php echo htmlspecialchars($lead['email']); ?>
                                    </a>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-block bg-white border border-gray-200 text-gray-600 text-[10px] font-bold uppercase px-3 py-1 rounded-sm shadow-sm">
                                    <?php echo htmlspecialchars($lead['interest']); ?>
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                    <a href="tel:<?php echo htmlspecialchars($lead['phone']); ?>" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-green-600 hover:bg-green-50 hover:border-green-200 transition-all" title="Call">
                                        <i class="fas fa-phone text-xs"></i>
                                    </a>
                                    <a href="mailto:<?php echo htmlspecialchars($lead['email']); ?>" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-all" title="Email">
                                        <i class="fas fa-paper-plane text-xs"></i>
                                    </a>
                                    <button onclick="deleteItem(<?php echo $lead['id']; ?>, 'message')" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition-all" title="Delete">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="md:hidden bg-gray-50 border-t border-gray-100 px-4 py-2 text-center">
                <span class="text-[10px] text-gray-400 uppercase tracking-widest flex items-center justify-center gap-2">
                    <i class="fas fa-arrows-alt-h"></i> Scroll to view details
                </span>
            </div>
        </div>
        <?php 
            endforeach; 
        } else {
            echo '
            <div class="flex flex-col items-center justify-center py-20 bg-white rounded-xl border border-dashed border-gray-300">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                    <i class="fas fa-inbox text-2xl"></i>
                </div>
                <h3 class="text-navy font-bold text-lg">No Inquiries Yet</h3>
                <p class="text-gray-400 text-sm mt-1">New contact requests will appear here.</p>
            </div>';
        }
        ?>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d4af77; 
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #B29243; 
        }
    </style>

    <script>
    function exportLeadsToExcel() {
        // 1. Define CSV Headers
        let csvContent = "data:text/csv;charset=utf-8,";
        csvContent += "Date,Client Name,Phone,Email,Interest,Message\n";

        // 2. Select all lead rows across all monthly tables
        const rows = document.querySelectorAll('.lead-row');
        
        if(rows.length === 0) {
            alert("No data to export.");
            return;
        }

        // 3. Iterate and parse data from data-attributes (cleaner than parsing HTML)
        rows.forEach(row => {
            const date = row.getAttribute('data-date');
            const name = `"${row.getAttribute('data-name')}"`; // Wrap in quotes to handle commas in names
            const phone = `"${row.getAttribute('data-phone')}"`;
            const email = row.getAttribute('data-email');
            const interest = `"${row.getAttribute('data-interest')}"`;
            const message = `"${row.getAttribute('data-message')}"`; // Handle commas/newlines in message

            // 4. Append row
            csvContent += `${date},${name},${phone},${email},${interest},${message}\n`;
        });

        // 5. Trigger Download
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        
        // Generate filename with current date
        const today = new Date();
        const dateStr = today.toISOString().slice(0,10);
        link.setAttribute("download", `Grafton_Leads_Export_${dateStr}.csv`);
        
        document.body.appendChild(link); // Required for FF
        link.click();
        document.body.removeChild(link);
    }
    </script>
</section>

            <section id="view-settings" class="section-view">
                <h2 class="text-3xl font-serif text-navy mb-8">Site Settings</h2>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
                    <h3 class="text-lg font-bold text-navy uppercase tracking-wide mb-6">Top Banner</h3>
                    <form id="banner_form" class="space-y-4">
                        <input type="hidden" name="action_banner" value="update">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Banner Text</label>
                            <input type="text" name="banner_text" value="<?php echo htmlspecialchars($banner['text'] ?? ''); ?>" class="w-full p-3 border rounded-lg" placeholder="e.g. Free shipping on orders over $5000">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Banner Link</label>
                            <input type="text" name="banner_url" value="<?php echo htmlspecialchars($banner['url'] ?? ''); ?>" class="w-full p-3 border rounded-lg" placeholder="e.g. #collections">
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="banner_active" id="b_active" <?php echo ($banner['is_active'] ?? 0) == 1 ? 'checked' : ''; ?> class="w-5 h-5 accent-navy">
                            <label for="b_active" class="text-sm font-bold text-navy">Show Banner</label>
                        </div>
                        <button type="submit" class="bg-navy text-white px-6 py-2 rounded font-bold uppercase text-xs tracking-widest hover:bg-gold transition-colors">Save Settings</button>
                    </form>
                </div>
            </section>

            <section id="view-collections" class="section-view">
                <div class="flex justify-between items-center mb-8"><h2 class="text-3xl font-serif text-navy">Collections</h2><button onclick="openModal('modal-collection'); resetColForm();" class="bg-navy text-white px-6 py-2 rounded font-bold uppercase text-xs tracking-widest hover:bg-gold transition-colors shadow-lg"><i class="fas fa-plus mr-2"></i> Add New</button></div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="collections-grid">
                    <?php
                    $cols = $conn->query("SELECT * FROM collections ORDER BY id DESC");
                    while($c = $cols->fetch_assoc()):
                    ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-lg transition-all" id="col-<?php echo $c['id']; ?>">
                        <div class="h-56 overflow-hidden relative">
                            <img src="<?php echo htmlspecialchars($c['cover_image']); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" id="col-img-<?php echo $c['id']; ?>">
                            <div class="absolute inset-0 bg-gradient-to-t from-navy/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4"><button onclick='openEditCollection(<?php echo json_encode($c); ?>)' class="bg-white text-navy px-4 py-2 rounded-full text-xs font-bold uppercase hover:bg-gold hover:text-white transition-colors">Edit Item</button></div>
                        </div>
                        <div class="p-5 flex justify-between items-start">
                            <div><h3 class="font-bold text-navy text-lg leading-tight" id="col-title-<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['title']); ?></h3><p class="text-xs text-gray-400 mt-1 line-clamp-1" id="col-desc-<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['description']); ?></p></div>
                            <button onclick="deleteItem(<?php echo $c['id']; ?>, 'collection')" class="text-gray-300 hover:text-red-500"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <section id="view-gallery" class="section-view">
                <div class="flex justify-between items-center mb-8"><h2 class="text-3xl font-serif text-navy">Shop Gallery</h2><button onclick="openModal('modal-gallery');" class="bg-navy text-white px-6 py-2 rounded font-bold uppercase text-xs tracking-widest hover:bg-gold transition-colors shadow-lg"><i class="fas fa-plus mr-2"></i> Upload Image</button></div>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4" id="gallery-grid">
                    <?php
                    $imgs = $conn->query("SELECT * FROM shop_gallery ORDER BY id DESC");
                    while($img = $imgs->fetch_assoc()):
                    ?>
                    <div class="relative group aspect-square overflow-hidden rounded-lg bg-gray-100 border border-gray-200" id="gallery-<?php echo $img['id']; ?>">
                        <img src="<?php echo htmlspecialchars($img['image_url']); ?>" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <button onclick="deleteItem(<?php echo $img['id']; ?>, 'gallery')" class="text-white hover:text-red-500"><i class="fas fa-trash text-xl"></i></button>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <section id="view-faqs" class="section-view">
                <div class="flex justify-between items-center mb-8"><h2 class="text-3xl font-serif text-navy">FAQs</h2><button onclick="openModal('modal-faq'); resetFaqForm();" class="bg-navy text-white px-6 py-2 rounded font-bold uppercase text-xs tracking-widest hover:bg-gold transition-colors shadow-lg"><i class="fas fa-plus mr-2"></i> Add FAQ</button></div>
                <div class="space-y-4 max-w-3xl" id="faq-list">
                    <?php
                    $faqs = $conn->query("SELECT * FROM faqs ORDER BY id DESC");
                    while($f = $faqs->fetch_assoc()):
                    ?>
                    <div class="bg-white p-5 rounded-lg border border-gray-100 flex justify-between items-start" id="faq-<?php echo $f['id']; ?>">
                        <div>
                            <h4 class="font-bold text-navy" id="faq-q-<?php echo $f['id']; ?>"><?php echo htmlspecialchars($f['question']); ?></h4>
                            <p class="text-sm text-gray-500 mt-1" id="faq-a-<?php echo $f['id']; ?>"><?php echo htmlspecialchars($f['answer']); ?></p>
                        </div>
                        <div class="flex gap-2">
                            <button onclick='openEditFaq(<?php echo json_encode($f); ?>)' class="text-blue-500 hover:text-navy"><i class="fas fa-pen"></i></button>
                            <button onclick="deleteItem(<?php echo $f['id']; ?>, 'faq')" class="text-gray-300 hover:text-red-500"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <section id="view-services" class="section-view">
                <div class="flex justify-between items-center mb-8"><h2 class="text-3xl font-serif text-navy">Services</h2><button onclick="openModal('modal-service'); resetServiceForm();" class="bg-navy text-white px-6 py-2 rounded font-bold uppercase text-xs tracking-widest hover:bg-gold transition-colors shadow-lg"><i class="fas fa-plus mr-2"></i> Add Service</button></div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6" id="services-grid">
                    <?php
                    $servs = $conn->query("SELECT * FROM services ORDER BY id DESC");
                    while($s = $servs->fetch_assoc()):
                    ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center group hover:shadow-lg transition-all" id="serv-<?php echo $s['id']; ?>">
                        <div class="w-24 h-24 mx-auto rounded-full overflow-hidden border-2 border-gray-100 mb-4 group-hover:border-gold transition-colors">
                            <img src="<?php echo htmlspecialchars($s['icon_image']); ?>" class="w-full h-full object-cover" id="serv-img-<?php echo $s['id']; ?>">
                        </div>
                        <h3 class="font-bold text-navy text-sm mb-2" id="serv-title-<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['title']); ?></h3>
                        <div class="flex justify-center gap-2 mt-4">
                            <button onclick='openEditService(<?php echo json_encode($s); ?>)' class="text-blue-500 hover:text-navy"><i class="fas fa-pen"></i></button>
                            <button onclick="deleteItem(<?php echo $s['id']; ?>, 'service')" class="text-gray-300 hover:text-red-500"><i class="fas fa-trash"></i></button>
                            
                        </div>
                        <p id="serv-desc-<?php echo $s['id']; ?>" class="hidden"><?php echo htmlspecialchars($s['description']); ?></p>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <section id="view-blog" class="section-view">
                <div class="flex justify-between items-center mb-8"><h2 class="text-3xl font-serif text-navy">Journal</h2><button onclick="openModal('modal-blog'); resetBlogForm();" class="bg-navy text-white px-6 py-2 rounded font-bold uppercase text-xs tracking-widest hover:bg-gold transition-colors shadow-lg"><i class="fas fa-plus mr-2"></i> Add Article</button></div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="blog-grid">
                    <?php
                    $blogs = $conn->query("SELECT * FROM blog_posts ORDER BY id DESC");
                    while($b = $blogs->fetch_assoc()):
                    ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-lg transition-all" id="blog-<?php echo $b['id']; ?>">
                        <div class="h-48 overflow-hidden relative">
                            <img src="<?php echo htmlspecialchars($b['cover_image']); ?>" class="w-full h-full object-cover" id="blog-img-<?php echo $b['id']; ?>">
                            <div class="absolute inset-0 bg-gradient-to-t from-navy/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4"><button onclick='openEditBlog(<?php echo json_encode($b); ?>)' class="bg-white text-navy px-4 py-2 rounded-full text-xs font-bold uppercase hover:bg-gold hover:text-white transition-colors">Edit</button></div>
                        </div>
                        <div class="p-5">
                            <span class="text-[10px] text-gold font-bold uppercase tracking-wider"><?php echo date('M d, Y', strtotime($b['created_at'])); ?></span>
                            <h3 class="font-bold text-navy text-lg leading-tight mt-1 mb-2 truncate" id="blog-title-<?php echo $b['id']; ?>"><?php echo htmlspecialchars($b['title']); ?></h3>
                            <div class="flex justify-end"><button onclick="deleteItem(<?php echo $b['id']; ?>, 'blog')" class="text-gray-300 hover:text-red-500"><i class="fas fa-trash"></i></button></div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <section id="view-insta" class="section-view">
                <div class="flex justify-between items-center mb-8"><h2 class="text-3xl font-serif text-navy">Instagram</h2><button onclick="openModal('modal-insta'); resetInstaForm();" class="bg-navy text-white px-6 py-2 rounded font-bold uppercase text-xs tracking-widest hover:bg-gold transition-colors shadow-lg"><i class="fas fa-plus mr-2"></i> Add Post</button></div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="insta-grid">
                    <?php
                    $posts = $conn->query("SELECT * FROM instagram_posts ORDER BY id DESC");
                    while($p = $posts->fetch_assoc()):
                    ?>
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden relative group" id="insta-<?php echo $p['id']; ?>">
                        <img src="<?php echo htmlspecialchars($p['image_url']); ?>" class="w-full aspect-square object-cover" id="insta-img-<?php echo $p['id']; ?>">
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-2">
                            <button onclick='openEditInsta(<?php echo json_encode($p); ?>)' class="text-white hover:text-gold"><i class="fas fa-pen"></i></button>
                            <button onclick="deleteItem(<?php echo $p['id']; ?>, 'insta')" class="text-white hover:text-red-500"><i class="fas fa-trash"></i></button>
                            <a href="<?php echo htmlspecialchars($p['post_url']); ?>" target="_blank" class="text-white text-xs hover:underline mt-2">View Link</a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <section id="view-reviews" class="section-view">
                <div class="flex justify-between items-center mb-8"><h2 class="text-3xl font-serif text-navy">Reviews</h2><button onclick="openModal('modal-review'); resetRevForm();" class="bg-navy text-white px-6 py-2 rounded font-bold uppercase text-xs tracking-widest hover:bg-gold transition-colors shadow-lg"><i class="fas fa-plus mr-2"></i> Add Review</button></div>
                <div id="reviews-container">
                    <?php
                    $revs = $conn->query("SELECT * FROM reviews ORDER BY date_posted DESC, id DESC");
                    $grouped_revs = [];
                    while($r = $revs->fetch_assoc()) {
                         $d = strtotime($r['date_posted']);
                         if(!$d) $d = time();
                         $dateKey = date('Y-m-d', $d);
                         $grouped_revs[$dateKey][] = $r;
                    }
                    foreach($grouped_revs as $date => $day_revs):
                        $headerLabel = formatDateHeader($date);
                    ?>
                    <div class="date-group-rev" data-date="<?php echo $headerLabel; ?>">
                        <div class="date-header"><span><?php echo $headerLabel; ?></span></div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <?php foreach($day_revs as $r): ?>
                            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative group" id="rev-<?php echo $r['id']; ?>">
                                <div class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity"><button onclick='openEditReview(<?php echo json_encode($r); ?>)' class="text-blue-500 hover:text-navy"><i class="fas fa-pen"></i></button><button onclick="deleteItem(<?php echo $r['id']; ?>, 'review')" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button></div>
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-full bg-navy text-white flex items-center justify-center font-bold text-sm shadow-sm" id="rev-initial-<?php echo $r['id']; ?>"><?php echo htmlspecialchars($r['reviewer_initial']); ?></div>
                                    <div><h4 class="font-bold text-sm text-navy" id="rev-name-<?php echo $r['id']; ?>"><?php echo htmlspecialchars($r['reviewer_name']); ?></h4><div class="text-gold text-[10px]" id="rev-stars-<?php echo $r['id']; ?>"><?php for($i=0; $i<$r['rating']; $i++) echo '★'; ?></div></div>
                                </div>
                                <p class="text-sm text-gray-600 italic leading-relaxed" id="rev-text-<?php echo $r['id']; ?>">"<?php echo htmlspecialchars($r['review_text']); ?>"</p>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>

        </div>
    </main>

    <nav class="md:hidden fixed bottom-0 w-full bg-white/95 backdrop-blur-md border-t border-gray-200 z-40 pb-safe">
        <div class="flex overflow-x-auto no-scrollbar snap-x snap-mandatory px-2 py-2 gap-2">
            <button onclick="switchView('view-dashboard', this)" class="mobile-nav-btn flex-none snap-start flex items-center gap-2 px-4 py-2 rounded-full transition-all text-gray-400 hover:bg-gray-50 focus:outline-none">
                <i class="fas fa-chart-line text-lg"></i><span class="text-xs whitespace-nowrap">Home</span>
            </button>
            <button onclick="switchView('view-inbox', this)" class="mobile-nav-btn flex-none snap-start flex items-center gap-2 px-4 py-2 rounded-full transition-all text-gray-400 hover:bg-gray-50 focus:outline-none">
                <i class="fas fa-envelope text-lg"></i><span class="text-xs whitespace-nowrap">Inbox</span>
            </button>
            <button onclick="switchView('view-collections', this)" class="mobile-nav-btn flex-none snap-start flex items-center gap-2 px-4 py-2 rounded-full transition-all text-gray-400 hover:bg-gray-50 focus:outline-none">
                <i class="fas fa-gem text-lg"></i><span class="text-xs whitespace-nowrap">Collection</span>
            </button>
            <button onclick="switchView('view-gallery', this)" class="mobile-nav-btn flex-none snap-start flex items-center gap-2 px-4 py-2 rounded-full transition-all text-gray-400 hover:bg-gray-50 focus:outline-none">
                <i class="fas fa-images text-lg"></i><span class="text-xs whitespace-nowrap">Gallery</span>
            </button>
            <button onclick="switchView('view-leads', this)" class="mobile-nav-btn flex-none snap-start flex items-center gap-2 px-4 py-2 rounded-full transition-all text-gray-400 hover:bg-gray-50 focus:outline-none">
                <i class="fas fa-address-book text-lg"></i><span class="text-xs whitespace-nowrap">Leads</span>
            </button>
            <button onclick="switchView('view-services', this)" class="mobile-nav-btn flex-none snap-start flex items-center gap-2 px-4 py-2 rounded-full transition-all text-gray-400 hover:bg-gray-50 focus:outline-none">
                <i class="fas fa-concierge-bell text-lg"></i><span class="text-xs whitespace-nowrap">Services</span>
            </button>
             <button onclick="switchView('view-blog', this)" class="mobile-nav-btn flex-none snap-start flex items-center gap-2 px-4 py-2 rounded-full transition-all text-gray-400 hover:bg-gray-50 focus:outline-none">
                <i class="fas fa-pen-nib text-lg"></i><span class="text-xs whitespace-nowrap">Blog</span>
            </button>
             <button onclick="switchView('view-reviews', this)" class="mobile-nav-btn flex-none snap-start flex items-center gap-2 px-4 py-2 rounded-full transition-all text-gray-400 hover:bg-gray-50 focus:outline-none">
                <i class="fas fa-star text-lg"></i><span class="text-xs whitespace-nowrap">Reviews</span>
            </button>
             <button onclick="switchView('view-settings', this)" class="mobile-nav-btn flex-none snap-start flex items-center gap-2 px-4 py-2 rounded-full transition-all text-gray-400 hover:bg-gray-50 focus:outline-none">
                <i class="fas fa-cog text-lg"></i><span class="text-xs whitespace-nowrap">Settings</span>
            </button>
        </div>
    </nav>

    <div id="modal-faq" class="modal fixed inset-0 z-50 bg-navy/90 backdrop-blur-sm flex justify-center items-center p-4">
        <div class="modal-content bg-white w-full max-w-lg rounded-2xl shadow-2xl p-8 relative">
            <button onclick="closeModal('modal-faq')" class="absolute top-4 right-4 z-10 text-2xl text-gray-500 hover:text-red-500">&times;</button>
            <h2 class="text-xl font-bold text-navy mb-6 border-b pb-4" id="faq_modal_title">Add FAQ</h2>
            <form id="faq_form" class="space-y-4">
                <input type="hidden" name="action_faq" id="faq_action" value="add"><input type="hidden" name="faq_id" id="faq_id" value="">
                <input type="text" name="question" id="faq_q" required class="w-full p-2 border rounded" placeholder="Question">
                <textarea name="answer" id="faq_a" required class="w-full p-2 border rounded h-32" placeholder="Answer"></textarea>
                <button type="submit" class="w-full bg-navy text-white py-3 rounded font-bold uppercase text-xs">Save</button>
            </form>
        </div>
    </div>

    <div id="modal-gallery" class="modal fixed inset-0 z-50 bg-navy/90 backdrop-blur-sm flex justify-center items-center p-4">
        <div class="modal-content bg-white w-full max-w-md rounded-2xl shadow-2xl p-8 relative">
            <button onclick="closeModal('modal-gallery')" class="absolute top-4 right-4 z-10 text-2xl text-gray-500 hover:text-red-500">&times;</button>
            <h2 class="text-xl font-bold text-navy mb-6 border-b pb-4">Upload to Gallery</h2>
            <form id="gallery_form" class="space-y-4">
                <input type="hidden" name="action_gallery" value="add">
                <div class="bg-gray-50 p-6 border-2 border-dashed border-gray-300 rounded text-center">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 mb-2"></i>
                    <input type="file" name="gallery_images[]" required multiple accept="image/*" class="w-full text-xs">
                    <p class="text-[10px] text-gray-400 mt-2">Select multiple files if needed</p>
                </div>
                <button type="submit" class="w-full bg-navy text-white py-3 rounded font-bold uppercase text-xs">Upload</button>
            </form>
        </div>
    </div>

    <div id="modal-collection" class="modal fixed inset-0 z-50 bg-navy/90 backdrop-blur-sm flex justify-center items-center p-4">
        <div class="modal-content bg-white w-full max-w-2xl max-h-[90vh] rounded-2xl shadow-2xl overflow-y-auto relative">
            <button onclick="closeModal('modal-collection')" class="absolute top-4 right-4 z-10 text-2xl text-gray-500 hover:text-red-500">&times;</button>
            <div class="p-8">
                <h2 class="text-xl font-bold text-navy mb-6 border-b pb-4" id="col_modal_title">Add Collection</h2>
                <form id="col_form" class="space-y-4">
                    <input type="hidden" name="action_collection" id="col_action" value="add"><input type="hidden" name="collection_id" id="col_id" value=""><input type="hidden" name="remove_cover_image" id="remove_cover_image" value="false">
                    <input type="text" name="title" id="col_title" required class="w-full p-2 border rounded" placeholder="Title">
                    <input type="url" name="calendly_link" id="col_link" class="w-full p-2 border rounded" placeholder="Calendly Link">
                    <textarea name="description" id="col_desc" required class="w-full p-2 border rounded h-24" placeholder="Description"></textarea>
                    
                    <div class="bg-gray-50 p-2 border border-dashed rounded">
                        <label class="text-xs font-bold uppercase mb-1 block">Cover Image</label>
                        <div id="current_cover_container" class="hidden mb-2"><img id="current_cover_img" src="" class="h-20 rounded"><button type="button" onclick="removeImage()" class="text-xs text-red-500">Remove</button></div>
                        <input type="file" name="cover_image" id="col_cover" accept="image/*" class="w-full text-xs">
                    </div>

                    <div id="existing_gallery_wrapper" class="hidden">
                        <label class="text-xs font-bold uppercase mb-2 block">Current Gallery Images</label>
                        <div id="existing_gallery_container" class="grid grid-cols-4 gap-2 mb-4">
                        </div>
                    </div>

                    <div class="bg-gray-50 p-2 border border-dashed rounded">
                        <label class="text-xs font-bold uppercase mb-1 block">Add More Gallery Images</label>
                        <input type="file" name="gallery_images[]" multiple accept="image/*" class="w-full text-xs">
                    </div>
                    
                    <button type="submit" class="w-full bg-navy text-white py-3 rounded font-bold uppercase text-xs" id="col_btn">Save</button>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-service" class="modal fixed inset-0 z-50 bg-navy/90 backdrop-blur-sm flex justify-center items-center p-4">
        <div class="modal-content bg-white w-full max-w-lg max-h-[90vh] rounded-2xl shadow-2xl overflow-y-auto relative">
            <button onclick="closeModal('modal-service')" class="absolute top-4 right-4 z-10 text-2xl text-gray-500 hover:text-red-500">&times;</button>
            <div class="p-8">
                <h2 class="text-xl font-bold text-navy mb-6 border-b pb-4" id="serv_modal_title">Add Service</h2>
                <form id="service_form" class="space-y-4">
                    <input type="hidden" name="action_service" id="serv_action" value="add">
                    <input type="hidden" name="service_id" id="serv_id" value="">
                    
                    <input type="text" name="title" id="serv_title" required class="w-full p-3 border rounded text-sm font-bold" placeholder="Service Title">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Booking Link (Optional)</label>
                            <input type="text" name="booking_url" id="serv_booking_url" class="w-full p-3 border rounded text-sm" placeholder="https://calendly.com/...">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Button Label</label>
                            <input type="text" name="button_text" id="serv_button_text" class="w-full p-3 border rounded text-sm" placeholder="e.g. Book Now" value="Book Now">
                        </div>
                    </div>

                    <textarea name="description" id="serv_desc" required class="w-full p-3 border rounded h-32 text-sm" placeholder="Full Description"></textarea>
                    
                    <div class="bg-gray-50 p-3 border border-dashed rounded">
                        <label class="text-xs font-bold uppercase mb-1 block">Icon/Image</label>
                        <input type="file" name="service_image" id="serv_image" accept="image/*" class="w-full text-xs">
                    </div>
                    
                    <button type="submit" class="w-full bg-navy text-white py-3 rounded font-bold uppercase text-xs" id="serv_btn">Save</button>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-blog" class="modal fixed inset-0 z-50 bg-navy/90 backdrop-blur-sm flex justify-center items-center p-4">
        <div class="modal-content bg-white w-full max-w-3xl max-h-[90vh] rounded-2xl shadow-2xl overflow-y-auto relative">
            <button onclick="closeModal('modal-blog')" class="absolute top-4 right-4 z-10 text-2xl text-gray-500 hover:text-red-500">&times;</button>
            <div class="p-8">
                <h2 class="text-xl font-bold text-navy mb-6 border-b pb-4" id="blog_modal_title">Add Article</h2>
                <form id="blog_form" class="space-y-4">
                    <input type="hidden" name="action_blog" id="blog_action" value="add"><input type="hidden" name="blog_id" id="blog_id" value="">
                    <input type="text" name="title" id="blog_title" required class="w-full p-3 border rounded text-lg font-bold" placeholder="Article Title">
                    <input type="text" name="subtitle" id="blog_subtitle" class="w-full p-2 border rounded" placeholder="Subtitle">
                    <textarea name="content" id="blog_content" required class="w-full p-3 border rounded h-64 font-serif" placeholder="Content..."></textarea>
                    <div class="bg-gray-50 p-3 border border-dashed rounded"><label class="text-xs font-bold uppercase mb-1 block">Cover Image</label><input type="file" name="cover_image" id="blog_cover" accept="image/*" class="w-full text-xs"></div>
                    <button type="submit" class="w-full bg-navy text-white py-3 rounded font-bold uppercase text-xs" id="blog_btn">Publish</button>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-insta" class="modal fixed inset-0 z-50 bg-navy/90 backdrop-blur-sm flex justify-center items-center p-4">
        <div class="modal-content bg-white w-full max-w-lg max-h-[90vh] rounded-2xl shadow-2xl overflow-y-auto relative">
            <button onclick="closeModal('modal-insta')" class="absolute top-4 right-4 z-10 text-2xl text-gray-500 hover:text-red-500">&times;</button>
            <div class="p-8">
                <h2 class="text-xl font-bold text-navy mb-6 border-b pb-4" id="insta_modal_title">Add Instagram Post</h2>
                <form id="insta_form" class="space-y-4">
                    <input type="hidden" name="action_insta" id="insta_action" value="add"><input type="hidden" name="insta_id" id="insta_id" value="">
                    <input type="text" name="caption" id="insta_caption" class="w-full p-2 border rounded" placeholder="Caption">
                    <input type="url" name="post_url" id="insta_url" required class="w-full p-2 border rounded" placeholder="Link">
                    <div class="bg-gray-50 p-3 border border-dashed rounded"><label class="text-xs font-bold uppercase mb-1 block">Image</label><input type="file" name="insta_image" id="insta_image" accept="image/*" class="w-full text-xs"></div>
                    <button type="submit" class="w-full bg-navy text-white py-3 rounded font-bold uppercase text-xs" id="insta_btn">Save</button>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-review" class="modal fixed inset-0 z-50 bg-navy/90 backdrop-blur-sm flex justify-center items-center p-4">
        <div class="modal-content bg-white w-full max-w-lg max-h-[90vh] rounded-2xl shadow-2xl overflow-y-auto relative">
            <button onclick="closeModal('modal-review')" class="absolute top-4 right-4 z-10 text-2xl text-gray-500 hover:text-red-500">&times;</button>
            <div class="p-8">
                <h2 class="text-xl font-bold text-navy mb-6 border-b pb-4" id="rev_modal_title">Add Review</h2>
                <form id="rev_form" class="space-y-4">
                    <input type="hidden" name="action_review" id="rev_action" value="add"><input type="hidden" name="review_id" id="rev_id" value="">
                    <input type="text" name="reviewer_name" id="rev_name" required class="w-full p-2 border rounded" placeholder="Name">
                    <div class="grid grid-cols-2 gap-4"><input type="text" name="date_posted" id="rev_date" required class="w-full p-2 border rounded" placeholder="Date (YYYY-MM-DD)"><select name="rating" id="rev_rating" class="w-full p-2 border rounded"><option value="5">5 Stars</option><option value="4">4 Stars</option></select></div>
                    <textarea name="review_text" id="rev_text" required class="w-full p-2 border rounded h-24" placeholder="Review..."></textarea>
                    <button type="submit" class="w-full bg-navy text-white py-3 rounded font-bold uppercase text-xs" id="rev_btn">Save</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function switchView(viewId, btnElement) {
            document.querySelectorAll('.section-view').forEach(el => el.classList.remove('active'));
            document.getElementById(viewId).classList.add('active');
            
            // Desktop active state
            if (window.innerWidth >= 768 && btnElement) {
                document.querySelectorAll('.nav-btn').forEach(btn => btn.classList.remove('active'));
                if(btnElement.classList.contains('nav-btn')) btnElement.classList.add('active');
            }
            // Mobile active state
            if (window.innerWidth < 768 && btnElement) {
                document.querySelectorAll('.mobile-nav-btn').forEach(btn => {
                    btn.classList.remove('active');
                    btn.querySelector('i').classList.remove('text-gold');
                    btn.querySelector('span').classList.remove('font-bold', 'text-navy');
                });
                if(btnElement.classList.contains('mobile-nav-btn')) {
                    btnElement.classList.add('active');
                    btnElement.querySelector('i').classList.add('text-gold');
                    btnElement.querySelector('span').classList.add('font-bold', 'text-navy');
                }
            }
        }
        function openModal(id) { document.getElementById(id).classList.add('active'); }
        function closeModal(id) { document.getElementById(id).classList.remove('active'); }
        function showToast(msg) {
            const toast = document.getElementById("toast");
            document.getElementById("toast-message").innerText = msg;
            toast.className = "show flex items-center justify-center gap-3 font-bold uppercase tracking-wider";
            setTimeout(function(){ toast.className = toast.className.replace("show", ""); }, 3000);
        }

        // --- DYNAMIC HTML GENERATORS ---
        function getCollectionHtml(d) {
            return `
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-lg transition-all" id="col-${d.id}">
                <div class="h-56 overflow-hidden relative">
                    <img src="${d.cover_image}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" id="col-img-${d.id}">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4"><button onclick='openEditCollection(${JSON.stringify(d)})' class="bg-white text-navy px-4 py-2 rounded-full text-xs font-bold uppercase hover:bg-gold hover:text-white transition-colors">Edit Item</button></div>
                </div>
                <div class="p-5 flex justify-between items-start">
                    <div><h3 class="font-bold text-navy text-lg leading-tight" id="col-title-${d.id}">${d.title}</h3><p class="text-xs text-gray-400 mt-1 line-clamp-1" id="col-desc-${d.id}">${d.description}</p></div>
                    <button onclick="deleteItem(${d.id}, 'collection')" class="text-gray-300 hover:text-red-500"><i class="fas fa-trash"></i></button>
                </div>
            </div>`;
        }

        function getServiceHtml(d) {
            return `
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center group hover:shadow-lg transition-all" id="serv-${d.id}">
                <div class="w-24 h-24 mx-auto rounded-full overflow-hidden border-2 border-gray-100 mb-4 group-hover:border-gold transition-colors">
                    <img src="${d.icon_image}" class="w-full h-full object-cover" id="serv-img-${d.id}">
                </div>
                <h3 class="font-bold text-navy text-sm mb-2" id="serv-title-${d.id}">${d.title}</h3>
                <div class="flex justify-center gap-2 mt-4">
                    <button onclick='openEditService(${JSON.stringify(d)})' class="text-blue-500 hover:text-navy"><i class="fas fa-pen"></i></button>
                    <button onclick="deleteItem(${d.id}, 'service')" class="text-gray-300 hover:text-red-500"><i class="fas fa-trash"></i></button>
                </div>
                <p id="serv-desc-${d.id}" class="hidden">${d.description}</p>
            </div>`;
        }

        function getBlogHtml(d) {
             return `
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-lg transition-all" id="blog-${d.id}">
                <div class="h-48 overflow-hidden relative">
                    <img src="${d.cover_image}" class="w-full h-full object-cover" id="blog-img-${d.id}">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4"><button onclick='openEditBlog(${JSON.stringify(d)})' class="bg-white text-navy px-4 py-2 rounded-full text-xs font-bold uppercase hover:bg-gold hover:text-white transition-colors">Edit</button></div>
                </div>
                <div class="p-5">
                    <span class="text-[10px] text-gold font-bold uppercase tracking-wider">${d.created_at}</span>
                    <h3 class="font-bold text-navy text-lg leading-tight mt-1 mb-2 truncate" id="blog-title-${d.id}">${d.title}</h3>
                    <div class="flex justify-end"><button onclick="deleteItem(${d.id}, 'blog')" class="text-gray-300 hover:text-red-500"><i class="fas fa-trash"></i></button></div>
                </div>
            </div>`;
        }
        
        function getInstaHtml(d) {
            return `
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden relative group" id="insta-${d.id}">
                <img src="${d.image_url}" class="w-full aspect-square object-cover" id="insta-img-${d.id}">
                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-2">
                    <button onclick='openEditInsta(${JSON.stringify(d)})' class="text-white hover:text-gold"><i class="fas fa-pen"></i></button>
                    <button onclick="deleteItem(${d.id}, 'insta')" class="text-white hover:text-red-500"><i class="fas fa-trash"></i></button>
                    <a href="${d.post_url}" target="_blank" class="text-white text-xs hover:underline mt-2">View Link</a>
                </div>
            </div>`;
        }

        function getReviewHtml(d) {
             let stars = ''; for(let i=0; i<d.rating; i++) stars+='★';
             return `
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative group" id="rev-${d.id}">
                <div class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity"><button onclick='openEditReview(${JSON.stringify(d)})' class="text-blue-500 hover:text-navy"><i class="fas fa-pen"></i></button><button onclick="deleteItem(${d.id}, 'review')" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button></div>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-navy text-white flex items-center justify-center font-bold text-sm shadow-sm" id="rev-initial-${d.id}">${d.reviewer_initial}</div>
                    <div><h4 class="font-bold text-sm text-navy" id="rev-name-${d.id}">${d.reviewer_name}</h4><div class="text-gold text-[10px]" id="rev-stars-${d.id}">${stars}</div></div>
                </div>
                <p class="text-sm text-gray-600 italic leading-relaxed" id="rev-text-${d.id}">"${d.review_text}"</p>
            </div>`;
        }
        
        function getFaqHtml(d) {
            return `
            <div class="bg-white p-5 rounded-lg border border-gray-100 flex justify-between items-start" id="faq-${d.id}">
                <div>
                    <h4 class="font-bold text-navy" id="faq-q-${d.id}">${d.question}</h4>
                    <p class="text-sm text-gray-500 mt-1" id="faq-a-${d.id}">${d.answer}</p>
                </div>
                <div class="flex gap-2">
                    <button onclick='openEditFaq(${JSON.stringify(d)})' class="text-blue-500 hover:text-navy"><i class="fas fa-pen"></i></button>
                    <button onclick="deleteItem(${d.id}, 'faq')" class="text-gray-300 hover:text-red-500"><i class="fas fa-trash"></i></button>
                </div>
            </div>`;
        }

        function getGalleryHtml(d) {
            return `
            <div class="relative group aspect-square overflow-hidden rounded-lg bg-gray-100 border border-gray-200" id="gallery-${d.id}">
                <img src="${d.image_url}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <button onclick="deleteItem(${d.id}, 'gallery')" class="text-white hover:text-red-500"><i class="fas fa-trash text-xl"></i></button>
                </div>
            </div>`;
        }

        // --- SUBMIT HANDLER ---
        function attachSubmit(formId, modalId) {
            document.getElementById(formId).addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetch('admin_submit_handle.php', { method: 'POST', body: formData })
                .then(r => r.json()).then(res => {
                    if(res.status === 'success') { 
                        showToast(res.message); 
                        if(modalId) closeModal(modalId);
                        
                        // NO REFRESH LOGIC
                        if(res.action === 'update') {
                            if(res.type === 'collection') {
                                document.getElementById('col-title-'+res.data.id).innerText = res.data.title;
                                document.getElementById('col-desc-'+res.data.id).innerText = res.data.description;
                                if(res.data.cover_image) document.getElementById('col-img-'+res.data.id).src = res.data.cover_image;
                            } else if(res.type === 'service') {
                                document.getElementById('serv-title-'+res.data.id).innerText = res.data.title;
                                document.getElementById('serv-desc-'+res.data.id).innerText = res.data.description;
                                if(res.data.icon_image) document.getElementById('serv-img-'+res.data.id).src = res.data.icon_image;
                            } else if(res.type === 'blog') {
                                document.getElementById('blog-title-'+res.data.id).innerText = res.data.title;
                                if(res.data.cover_image) document.getElementById('blog-img-'+res.data.id).src = res.data.cover_image;
                            } else if(res.type === 'insta') {
                                if(res.data.image_url) document.getElementById('insta-img-'+res.data.id).src = res.data.image_url;
                            } else if(res.type === 'review') {
                                document.getElementById('rev-name-'+res.data.id).innerText = res.data.reviewer_name;
                                document.getElementById('rev-text-'+res.data.id).innerText = '"'+res.data.review_text+'"';
                                document.getElementById('rev-initial-'+res.data.id).innerText = res.data.reviewer_initial;
                                let stars = ''; for(let i=0; i<res.data.rating; i++) stars+='★';
                                document.getElementById('rev-stars-'+res.data.id).innerText = stars;
                            } else if(res.type === 'faq') {
                                document.getElementById('faq-q-'+res.data.id).innerText = res.data.question;
                                document.getElementById('faq-a-'+res.data.id).innerText = res.data.answer;
                            }
                        } else if(res.action === 'add') {
                             if(res.type === 'collection') {
                                document.getElementById('collections-grid').insertAdjacentHTML('afterbegin', getCollectionHtml(res.data));
                             } else if(res.type === 'service') {
                                document.getElementById('services-grid').insertAdjacentHTML('afterbegin', getServiceHtml(res.data));
                             } else if(res.type === 'blog') {
                                document.getElementById('blog-grid').insertAdjacentHTML('afterbegin', getBlogHtml(res.data));
                             } else if(res.type === 'insta') {
                                document.getElementById('insta-grid').insertAdjacentHTML('afterbegin', getInstaHtml(res.data));
                             } else if(res.type === 'faq') {
                                document.getElementById('faq-list').insertAdjacentHTML('afterbegin', getFaqHtml(res.data));
                             } else if(res.type === 'gallery') {
                                // Handle array of new images for shop gallery
                                if(Array.isArray(res.data)) {
                                    res.data.forEach(imgData => {
                                        document.getElementById('gallery-grid').insertAdjacentHTML('afterbegin', getGalleryHtml(imgData));
                                    });
                                } else {
                                    document.getElementById('gallery-grid').insertAdjacentHTML('afterbegin', getGalleryHtml(res.data));
                                }
                             } else if(res.type === 'review') {
                                // For reviews, check if "Today" exists in the container
                                const container = document.getElementById('reviews-container');
                                let todayGroup = container.querySelector('.date-group-rev[data-date="Today"]');
                                const html = getReviewHtml(res.data);
                                if(todayGroup) {
                                    todayGroup.querySelector('.grid').insertAdjacentHTML('afterbegin', html);
                                } else {
                                    const groupHtml = `<div class="date-group-rev" data-date="Today"><div class="date-header"><span>Today</span></div><div class="grid grid-cols-1 md:grid-cols-3 gap-6">${html}</div></div>`;
                                    container.insertAdjacentHTML('afterbegin', groupHtml);
                                }
                             }
                        }
                    } else { alert('Error: ' + res.message); }
                });
            });
        }
        // Attach all forms
        attachSubmit('banner_form', null);
        attachSubmit('faq_form', 'modal-faq');
        attachSubmit('gallery_form', 'modal-gallery');
        attachSubmit('col_form', 'modal-collection');
        attachSubmit('rev_form', 'modal-review');
        attachSubmit('blog_form', 'modal-blog');
        attachSubmit('insta_form', 'modal-insta');
        attachSubmit('service_form', 'modal-service');

        // --- DELETE HANDLER ---
        function deleteItem(id, type) {
            if(confirm('Delete this item?')) {
                const fd = new FormData(); fd.append('action', 'delete'); fd.append('id', id); fd.append('type', type);
                fetch('admin_submit_handle.php', { method: 'POST', body: fd }).then(r => r.json()).then(d => {
                    if(d.status === 'success') { 
                        showToast(d.message); 
                        // Remove from DOM
                        const el = document.getElementById((type === 'message' ? 'msg' : (type === 'collection' ? 'col' : (type === 'service' ? 'serv' : type))) + '-' + id);
                        // Also check for lead-msg ID if it's a message in the leads view
                        const leadEl = document.getElementById('lead-msg-' + id);
                        
                        if(el) {
                            el.style.opacity = '0';
                            setTimeout(() => el.remove(), 300);
                        }
                        if(leadEl) {
                             leadEl.style.opacity = '0';
                             setTimeout(() => leadEl.remove(), 300);
                        }
                    }
                });
            }
        }

        // --- SPECIFIC HANDLER FOR DELETING COLLECTION GALLERY IMAGES ---
        function deleteCollectionImage(id) {
            if(confirm('Delete this image from gallery?')) {
                const fd = new FormData(); fd.append('action', 'delete_collection_image'); fd.append('id', id);
                fetch('admin_submit_handle.php', { method: 'POST', body: fd }).then(r => r.json()).then(d => {
                    if(d.status === 'success') {
                        document.getElementById('col_gal_img_'+id).remove();
                    }
                });
            }
        }

        // --- EDIT HANDLERS (Populate Modals) ---
        function openEditFaq(d) {
            document.getElementById('faq_modal_title').innerText = 'Edit FAQ';
            document.getElementById('faq_action').value = 'update';
            document.getElementById('faq_id').value = d.id;
            document.getElementById('faq_q').value = d.question;
            document.getElementById('faq_a').value = d.answer;
            openModal('modal-faq');
        }
        function resetFaqForm() {
            document.getElementById('faq_form').reset();
            document.getElementById('faq_modal_title').innerText = 'Add FAQ';
            document.getElementById('faq_action').value = 'add';
        }
        function removeImage() {
            if(confirm("Remove this image?")) {
                document.getElementById('current_cover_container').classList.add('hidden');
                document.getElementById('col_cover').classList.remove('hidden');
                document.getElementById('remove_cover_image').value = 'true';
            }
        }
        function openEditCollection(d) {
            document.getElementById('col_form').reset();
            document.getElementById('col_modal_title').innerText = 'Edit Collection';
            document.getElementById('col_action').value = 'update';
            document.getElementById('col_id').value = d.id;
            document.getElementById('col_title').value = d.title;
            document.getElementById('col_link').value = d.calendly_link;
            document.getElementById('col_desc').value = d.description;
            
            // Handle Cover Image
            if(d.cover_image) {
                document.getElementById('current_cover_img').src = d.cover_image;
                document.getElementById('current_cover_container').classList.remove('hidden');
                document.getElementById('col_cover').classList.add('hidden');
                document.getElementById('col_cover').removeAttribute('required');
            } else {
                document.getElementById('current_cover_container').classList.add('hidden');
                document.getElementById('col_cover').classList.remove('hidden');
            }

            // Fetch and Show Gallery Images
            const galContainer = document.getElementById('existing_gallery_container');
            const galWrapper = document.getElementById('existing_gallery_wrapper');
            galContainer.innerHTML = '<div class="col-span-4 text-center text-gray-400 text-xs py-2">Loading images...</div>';
            galWrapper.classList.remove('hidden');

            const fd = new FormData(); fd.append('action', 'get_collection_gallery'); fd.append('id', d.id);
            fetch('admin_submit_handle.php', { method: 'POST', body: fd }).then(r => r.json()).then(res => {
                galContainer.innerHTML = '';
                if(res.status === 'success' && res.data.length > 0) {
                    res.data.forEach(img => {
                        const div = document.createElement('div');
                        div.className = "relative group h-20 rounded overflow-hidden border";
                        div.id = 'col_gal_img_' + img.id;
                        div.innerHTML = `
                            <img src="${img.image_path}" class="w-full h-full object-cover">
                            <button type="button" onclick="deleteCollectionImage(${img.id})" class="absolute top-0 right-0 bg-red-500 text-white w-5 h-5 flex items-center justify-center text-[10px] opacity-0 group-hover:opacity-100 transition-opacity">&times;</button>
                        `;
                        galContainer.appendChild(div);
                    });
                } else {
                    galContainer.innerHTML = '<div class="col-span-4 text-center text-gray-400 text-xs py-2">No gallery images found</div>';
                }
            });

            document.getElementById('col_btn').innerText = 'Update';
            openModal('modal-collection');
        }
        function resetColForm() {
            document.getElementById('col_form').reset();
            document.getElementById('col_modal_title').innerText = 'Add Collection';
            document.getElementById('col_action').value = 'add';
            document.getElementById('col_id').value = '';
            document.getElementById('col_cover').setAttribute('required', 'required');
            document.getElementById('current_cover_container').classList.add('hidden');
            document.getElementById('col_cover').classList.remove('hidden');
            document.getElementById('existing_gallery_wrapper').classList.add('hidden');
            document.getElementById('existing_gallery_container').innerHTML = '';
            document.getElementById('col_btn').innerText = 'Create';
        }
        function openEditBlog(d) {
            document.getElementById('blog_form').reset();
            document.getElementById('blog_modal_title').innerText = 'Edit Article';
            document.getElementById('blog_action').value = 'update';
            document.getElementById('blog_id').value = d.id;
            document.getElementById('blog_title').value = d.title;
            document.getElementById('blog_subtitle').value = d.subtitle;
            document.getElementById('blog_content').value = d.content;
            document.getElementById('blog_cover').removeAttribute('required');
            document.getElementById('blog_btn').innerText = 'Update';
            openModal('modal-blog');
        }
        function resetBlogForm() {
            document.getElementById('blog_form').reset();
            document.getElementById('blog_modal_title').innerText = 'Add Article';
            document.getElementById('blog_action').value = 'add';
            document.getElementById('blog_id').value = '';
            document.getElementById('blog_cover').setAttribute('required', 'required');
            document.getElementById('blog_btn').innerText = 'Publish';
        }
        function openEditInsta(d) {
            document.getElementById('insta_form').reset();
            document.getElementById('insta_modal_title').innerText = 'Edit Post';
            document.getElementById('insta_action').value = 'update';
            document.getElementById('insta_id').value = d.id;
            document.getElementById('insta_caption').value = d.caption;
            document.getElementById('insta_url').value = d.post_url;
            document.getElementById('insta_image').removeAttribute('required');
            document.getElementById('insta_btn').innerText = 'Update';
            openModal('modal-insta');
        }
        function resetInstaForm() {
            document.getElementById('insta_form').reset();
            document.getElementById('insta_modal_title').innerText = 'Add Post';
            document.getElementById('insta_action').value = 'add';
            document.getElementById('insta_id').value = '';
            document.getElementById('insta_image').setAttribute('required', 'required');
            document.getElementById('insta_btn').innerText = 'Save';
        }
        function openEditService(d) {
            document.getElementById('service_form').reset();
            document.getElementById('serv_modal_title').innerText = 'Edit Service';
            document.getElementById('serv_action').value = 'update';
            document.getElementById('serv_id').value = d.id;
            document.getElementById('serv_title').value = d.title;
            document.getElementById('serv_desc').value = d.description;
            
            // --- NEW: Populate URL and Button Text ---
            document.getElementById('serv_booking_url').value = d.booking_url || '';
            document.getElementById('serv_button_text').value = d.button_text || 'Book Now';
            // -----------------------------------------

            document.getElementById('serv_image').removeAttribute('required');
            document.getElementById('serv_btn').innerText = 'Update';
            openModal('modal-service');
        }

        function resetServiceForm() {
            document.getElementById('service_form').reset();
            document.getElementById('serv_modal_title').innerText = 'Add Service';
            document.getElementById('serv_action').value = 'add';
            document.getElementById('serv_id').value = '';
            
            // --- NEW: Ensure default button text is set ---
            document.getElementById('serv_booking_url').value = '';
            document.getElementById('serv_button_text').value = 'Book Now'; 
            // ----------------------------------------------

            document.getElementById('serv_image').setAttribute('required', 'required');
            document.getElementById('serv_btn').innerText = 'Save';
        }
        function openEditReview(d) {
            document.getElementById('rev_modal_title').innerText = 'Edit Review';
            document.getElementById('rev_action').value = 'update';
            document.getElementById('rev_id').value = d.id;
            document.getElementById('rev_name').value = d.reviewer_name;
            document.getElementById('rev_date').value = d.date_posted;
            document.getElementById('rev_rating').value = d.rating;
            document.getElementById('rev_text').value = d.review_text;
            document.getElementById('rev_btn').innerText = 'Update';
            openModal('modal-review');
        }
        function resetRevForm() {
            document.getElementById('rev_form').reset();
            document.getElementById('rev_modal_title').innerText = 'Add Review';
            document.getElementById('rev_action').value = 'add';
            document.getElementById('rev_id').value = '';
            document.getElementById('rev_btn').innerText = 'Save';
        }
    </script>
</body>
</html>