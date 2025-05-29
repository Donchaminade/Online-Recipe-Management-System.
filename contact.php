<?php
// contactus.php

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email   = htmlspecialchars(trim($_POST['email'] ?? ''));
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $msg     = htmlspecialchars(trim($_POST['message'] ?? ''));

    if ($name && $email && $subject && $msg) {
        $message = '<div class="text-green-600 font-semibold mb-4 animate-bounce">Thank you for contacting us. We will get back to you soon.</div>';
    } else {
        $message = '<div class="text-red-600 font-semibold mb-4 animate-shake">Please fill in all fields.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - Online Recipe Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes shake {
            0% { transform: translateX(0); }
            20% { transform: translateX(-8px); }
            40% { transform: translateX(8px); }
            60% { transform: translateX(-8px); }
            80% { transform: translateX(8px); }
            100% { transform: translateX(0); }
        }
        .animate-shake {
            animation: shake 0.5s;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="container mx-auto max-w-4xl bg-white rounded-xl shadow-lg p-8 flex flex-col md:flex-row gap-8 animate-fade-in">
        <div class="form-section flex-1">
            <h2 class="text-3xl font-bold text-center mb-6 text-green-700 animate-fade-in-down">Contact Us</h2>
            <?php echo $message; ?>
            <form method="post" action="contact.php" autocomplete="off" class="space-y-4">
                <div>
                    <label for="name" class="block font-semibold mb-1">Name:</label>
                    <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-400 transition">
                </div>
                <div>
                    <label for="email" class="block font-semibold mb-1">Email:</label>
                    <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-400 transition">
                </div>
                <div>
                    <label for="subject" class="block font-semibold mb-1">Subject:</label>
                    <input type="text" id="subject" name="subject" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-400 transition">
                </div>
                <div>
                    <label for="message" class="block font-semibold mb-1">Message:</label>
                    <textarea id="message" name="message" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-400 transition"></textarea>
                </div>
                <button type="submit" class="w-full py-3 bg-green-600 text-white font-bold rounded hover:bg-green-700 transition transform hover:scale-105 shadow-lg animate-pulse">Send Message</button>
            </form>
        </div>
        <div class="info-section flex-1 bg-green-50 rounded-xl p-6 shadow-md animate-fade-in-up">
            <h3 class="text-2xl font-bold mb-4 text-green-800">Contact Information</h3>
            <div class="mb-4 flex items-start gap-3">
                <svg class="w-6 h-6 text-green-600 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 12.414a2 2 0 00-2.828 0l-4.243 4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <div>
                    <span class="font-semibold">Address:</span><br>
                    123 Main Street,<br>
                    Cityville, 12345,<br>
                    Country
                </div>
            </div>
            <div class="mb-4 flex items-center gap-3">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm0 12a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2zm12-12a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zm0 12a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <div>
                    <span class="font-semibold">Phone:</span><br>
                    +1 234 567 8901
                </div>
            </div>
            <div class="mb-4 flex items-center gap-3">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 12a4 4 0 01-8 0V8a4 4 0 018 0v4z"/><path d="M12 16v2m0 0h-2m2 0h2"/></svg>
                <div>
                    <span class="font-semibold">Email:</span><br>
                    info@onlinerecipe.com
                </div>
            </div>
            <div class="mb-4 flex items-center gap-3">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10.5a8.38 8.38 0 01-.9 3.8l-7.1 7.1a2 2 0 01-2.8 0l-7.1-7.1A8.38 8.38 0 013 10.5C3 6.36 6.36 3 10.5 3S18 6.36 18 10.5z"/></svg>
                <div>
                    <span class="font-semibold">Location:</span><br>
                    <a href="https://maps.google.com/?q=123+Main+Street+Cityville" target="_blank" class="text-green-700 underline hover:text-green-900 transition">View on Google Maps</a>
                </div>
            </div>
            <div class="mb-2 flex items-center gap-3">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10m-9 4h6m-7 4h8"/></svg>
                <div>
                    <span class="font-semibold">Working Hours:</span><br>
                    Mon - Fri: 9:00 AM - 6:00 PM
                </div>
            </div>
        </div>
    </div>
    <style>
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fade-in {
            animation: fade-in 1s ease;
        }
        @keyframes fade-in-down {
            from { opacity: 0; transform: translateY(-30px);}
            to { opacity: 1; transform: translateY(0);}
        }
        .animate-fade-in-down {
            animation: fade-in-down 1s ease;
        }
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(30px);}
            to { opacity: 1; transform: translateY(0);}
        }
        .animate-fade-in-up {
            animation: fade-in-up 1s ease;
        }
    </style>
</body>
</html>