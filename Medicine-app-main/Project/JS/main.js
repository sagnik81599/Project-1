
document.querySelector('form').addEventListener('submit', function(e) {
    const emailInput = document.getElementById('email');
    const ageInput = document.getElementById('age');

    // Convert email to lowercase
    const email = emailInput.value.trim().toLowerCase();
    const age = parseInt(ageInput.value.trim());

    // 1. Email format check
    const emailRegex = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;

    const commonTypos = {
        "gamil.com": "gmail.com",
        "gmial.com": "gmail.com",
        "gnail.com": "gmail.com",
        "gmaill.com": "gmail.com",
        "gmail.con": "gmail.com",
        "gmail.co": "gmail.com",
        "yahoo.con": "yahoo.com",
        "hotmial.com": "hotmail.com"
    };

    if (!emailRegex.test(email)) {
        alert("❌ Please enter a valid email address.");
        e.preventDefault();
        return;
    }

    const domain = email.split("@")[1];
    if (commonTypos[domain]) {
        const suggestion = email.split("@")[0] + "@" + commonTypos[domain];
        const confirmFix = confirm(`Did you mean "${suggestion}"? Click OK to fix it.`);
        if (confirmFix) {
            emailInput.value = suggestion;
            e.preventDefault(); // Pause form submission so user can confirm correction
            return;
        }
    }

    // Update the input field value with lowercase version
    emailInput.value = email;


    // 2. Age restriction check
    if (isNaN(age) || age < 18) {
        alert("🔞 You must be 18 or older to register and buy medicines.");
        e.preventDefault();
        return;
    }
});



document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.getElementById("hamburger");
    const navLinks = document.querySelector(".nav__links");
    const links = document.querySelectorAll(".nav__links a");

    // Toggle menu on hamburger click
    hamburger.addEventListener("click", function () {
        navLinks.classList.toggle("active");
        hamburger.classList.toggle("open");
    });

    // Close menu when clicking on a link
    links.forEach(link => {
        link.addEventListener("click", function () {
            navLinks.classList.remove("active");
            hamburger.classList.remove("open");
        });
    });

    // Close menu on scroll
    window.addEventListener("scroll", function () {
        navLinks.classList.remove("active");
        hamburger.classList.remove("open");
    });
});



  const links = document.querySelectorAll('.nav-link');
  links.forEach(link => {
    link.addEventListener('click', () => {
      links.forEach(l => l.classList.remove('active'));
      link.classList.add('active');
    });
  });




// Function to handle message fade out and removal
function hideMessages() {
    const messages = document.querySelectorAll('.message');
    if (messages.length === 0) return;

    messages.forEach(message => {
        // Add fade out class after delay
        setTimeout(() => {
            message.classList.add('fade-out');
            
            // Remove element after animation
            message.addEventListener('transitionend', () => {
                message.remove();
            });
        }, 3000);
    });
}

// Function to update cart count in the header
function updateCartCount() {
    fetch('get_cart_count.php')
        .then(response => response.json())
        .then(data => {
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                cartCount.textContent = data.count;
            }
        })
        .catch(error => console.error('Error:', error));
}

// Function to handle adding items to cart
function addToCart(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    fetch('add_to_cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count
            updateCartCount();
            
            // Add temporary success animation to button
            const button = form.querySelector('button');
            button.textContent = 'Added!';
            button.classList.add('added');
            
            setTimeout(() => {
                button.textContent = 'Add to Cart';
                button.classList.remove('added');
            }, 2000);
        }
    })
    .catch(error => console.error('Error:', error));
    
    return false;
}

// Function to clear the entire cart
function clearCart() {
    if (!confirm('Are you sure you want to clear your cart? This action cannot be undone.')) {
        return;
    }
    
    fetch('clear_cart.php', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Refresh the page to show empty cart
            window.location.reload();
        } else {
            console.error('Failed to clear cart:', data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    hideMessages();
});



// 🧠 Medicine name suggestions
const medicineNames = [
    "Dextrose", "Aspirin", "Amoxicillin", "Azithromycin",
    "Metformin", "Atorvastatin", "Omeprazole", "Cetirizine", "Ciprofloxacin"
];

const datalist = document.getElementById("medicineList");
medicineNames.forEach(med => {
    const option = document.createElement("option");
    option.value = med;
    datalist.appendChild(option);
});






const search = document.querySelector(".search-bar-container");
const magnifier = document.querySelector(".magnifier");
const micIcon = document.querySelector(".mic-icon");
const input = document.querySelector(".input");
const listItem = document.querySelector(".voice-text");
const recognition = new webkitSpeechRecognition() || SpeechRecognition();

magnifier.addEventListener("click", (e) => {
	search.classList.toggle("active");
	e.stopPropagation();
});

document.body.addEventListener("click", (e) => {
	if (!search.contains(e.target)) {
		search.classList.remove("active");
	}
});

micIcon.addEventListener("click", () => {
	recognition.start();

	recognition.onresult = (e) => {
		const result = event.results[0][0].transcript;
		input.value = result;
	};
	input.value = "";

	recognition.onerror = (event) => {
		alert("Speech recognition error: " + event.error);
	};
});


document.addEventListener("DOMContentLoaded", function() {
    const voiceSearchBtn = document.getElementById("voiceSearch");
    const searchInput = document.getElementById("searchInput");

    // Check if browser supports speech recognition
    if ('webkitSpeechRecognition' in window) {
        const recognition = new webkitSpeechRecognition();
        recognition.continuous = false;
        recognition.lang = "en-US";  

        voiceSearchBtn.addEventListener("click", function() {
            recognition.start();
        });

        recognition.onresult = function(event) {
            const transcript = event.results[0][0].transcript;
            searchInput.value = transcript;  
            document.querySelector(".search-box").submit(); 
        };

        recognition.onerror = function(event) {
            console.error("Speech recognition error:", event.error);
        };
    } else {
        console.warn("Speech recognition not supported in this browser.");
    }
});

const searchInput = document.getElementById("searchInput");

// Watch for clearing the input
searchInput.addEventListener("input", function () {
    if (this.value.trim() === "") {
        // Delay reload slightly to allow for typing
        setTimeout(() => {
            window.location.href = "http://localhost/Medicine-app-main/Project/home.php#products";
        }, 300);
    }
});





















// document.getElementById("voiceSearch").addEventListener("click", function () {
//     let recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
//     recognition.lang = "en-US"; // Set language
//     recognition.start();

//     recognition.onresult = function (event) {
//         let voiceInput = event.results[0][0].transcript;
//         document.getElementById("searchInput").value = voiceInput; // Set input field with voice text
//         highlightAndSpeakMedicine(voiceInput); // Call highlight function
//     };

//     recognition.onerror = function () {
//         alert("Voice recognition failed. Please try again.");
//     };
// });



//search bar
