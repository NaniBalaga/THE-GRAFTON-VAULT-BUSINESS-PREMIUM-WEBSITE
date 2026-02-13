<?php
// --- ENABLE ERROR REPORTING ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Start Session for duplicate check
include 'db.php';

$state = 'error'; // Default state
$error_msg = "";
$fullname = "";
$interest = "";

// Only handle POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Create a unique hash of the current submission data
    $current_hash = md5(serialize($_POST));

    // 2. Check if this exact data was just submitted successfully
    if (isset($_SESSION['last_submission_hash']) && $_SESSION['last_submission_hash'] === $current_hash) {
        // DUPLICATE DETECTED (User refreshed the page)
        $state = 'already_submitted';
        // Retrieve info from session for display purposes
        $fullname = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : "Valued Client";
        $interest = isset($_SESSION['last_interest']) ? $_SESSION['last_interest'] : "Inquiry";
    } else {
        // NEW SUBMISSION
        if (isset($_POST['submit_contact'])) {
            $fullname = $conn->real_escape_string($_POST['fullname']);
            $phone = $conn->real_escape_string($_POST['phone']);
            $email = $conn->real_escape_string($_POST['email']);
            $message = $conn->real_escape_string($_POST['message']);
            $interest = isset($_POST['interest']) ? $conn->real_escape_string($_POST['interest']) : "General Inquiry";

            $sql = "INSERT INTO contact_submissions (fullname, phone, email, interest, message) VALUES ('$fullname', '$phone', '$email', '$interest', '$message')";
            
            if ($conn->query($sql) === TRUE) {
                $state = 'success';
                // Store success data in session to handle refresh logic
                $_SESSION['last_submission_hash'] = $current_hash;
                $_SESSION['last_name'] = $fullname;
                $_SESSION['last_interest'] = $interest;
            } else {
                $state = 'error';
                $error_msg = "Database Error: " . $conn->error;
            }
        }
    }
} else {
    // If someone tries to access this page directly via URL (GET), send them back
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" class="no-scrollbar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status - The Grafton Vault</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { cream: '#f7f0e3', navy: '#0A1A33', gold: '#B29243' },
                    fontFamily: { serif: ['"Libre Baskerville"', 'serif'], sans: ['"Lato"', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        body { background-color: #0A1A33; color: white; }
        
        /* Smooth Fade In */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeInUp 1s ease-out forwards; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen px-6 bg-navy selection:bg-gold selection:text-white">

    <div class="max-w-2xl w-full text-center relative animate-fade-up">
        
        <div class="absolute inset-0 border border-gold/20 -m-4 md:-m-8 pointer-events-none"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-px h-16 bg-gold/40"></div>

        <?php if ($state === 'success'): ?>
            
            <div class="mb-10 inline-block relative">
                <div class="absolute inset-0 bg-gold blur-2xl opacity-20 rounded-full"></div>
                <i class="far fa-envelope-open text-5xl text-gold relative z-10"></i>
            </div>
            
            <h1 class="text-4xl md:text-5xl font-serif mb-6 tracking-wide text-white leading-tight">
                Request Acknowledged
            </h1>
            
            <div class="w-16 h-px bg-gold mx-auto mb-8"></div>

            <p class="text-lg md:text-xl font-sans text-cream/80 mb-8 leading-relaxed">
                Dear <?php echo htmlspecialchars($fullname); ?>,
            </p>

            <p class="text-base md:text-lg font-sans text-cream/60 mb-12 leading-relaxed max-w-lg mx-auto">
                We have successfully received your inquiry regarding 
                <span class="text-gold font-serif italic"><?php echo htmlspecialchars($interest); ?></span>. 
                Our concierge team is reviewing your details and will contact you shortly to arrange your private consultation.
            </p>

        <?php elseif ($state === 'already_submitted'): ?>

            <div class="mb-10 inline-block relative">
                <div class="absolute inset-0 bg-blue-500 blur-2xl opacity-10 rounded-full"></div>
                <i class="fas fa-info-circle text-5xl text-cream/80 relative z-10"></i>
            </div>
            
            <h1 class="text-3xl md:text-4xl font-serif mb-6 tracking-wide text-white leading-tight">
                Previously Submitted
            </h1>
            
            <div class="w-16 h-px bg-white/20 mx-auto mb-8"></div>

            <p class="text-base md:text-lg font-sans text-cream/60 mb-12 leading-relaxed max-w-lg mx-auto">
                We have already received your request regarding 
                <span class="text-gold font-serif italic"><?php echo htmlspecialchars($interest); ?></span>. 
                Rest assured, our team is currently processing your inquiry. There is no need to resubmit.
            </p>

        <?php else: ?>
            
            <div class="mb-8">
                <i class="fas fa-exclamation-triangle text-5xl text-red-400/80"></i>
            </div>
            <h1 class="text-3xl font-serif mb-6 text-white">Transmission Error</h1>
            <p class="text-base font-sans text-white/60 mb-10"><?php echo htmlspecialchars($error_msg); ?></p>
            
        <?php endif; ?>

        <button onclick="history.back()" class="group inline-block border-b border-gold text-gold pb-1 font-sans text-xs font-bold uppercase tracking-[0.2em] hover:text-white hover:border-white transition-all duration-500 cursor-pointer bg-transparent focus:outline-none">
            <span class="group-hover:-translate-x-1 transition-transform inline-block mr-2">&larr;</span> Return
        </button>

        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 w-px h-16 bg-gold/40"></div>

    </div>

</body>
</html>