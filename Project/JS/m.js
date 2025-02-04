// Mobile menu toggle
const hamburger = document.querySelector(".hamburger");
const navLinks = document.querySelector(".nav__links");

hamburger?.addEventListener("click", () => {
    navLinks.classList.toggle("active");
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


//search bar
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
