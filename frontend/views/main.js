// Fade-in animation for sections
function revealOnScroll() {
    const reveals = document.querySelectorAll('section');
    for (let i = 0; i < reveals.length; i++) {
        const windowHeight = window.innerHeight;
        const elementTop = reveals[i].getBoundingClientRect().top;
        const elementVisible = 100;
        if (elementTop < windowHeight - elementVisible) {
            reveals[i].classList.add('opacity-100', 'translate-y-0');
        } else {
            reveals[i].classList.remove('opacity-100', 'translate-y-0');
        }
    }
}
window.addEventListener('scroll', revealOnScroll);
document.addEventListener('DOMContentLoaded', function() {
    // Initial state for fade-in
    document.querySelectorAll('section').forEach(section => {
        section.classList.add('opacity-0', 'translate-y-8', 'transition-all', 'duration-700');
    });
    revealOnScroll();

    // Mobile menu functionality
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeMenuBtn = document.getElementById('close-menu');
    const menuLinks = document.querySelectorAll('#mobile-menu a');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.remove('translate-x-full');
        });

        closeMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.add('translate-x-full');
        });

        // Close menu when clicking on links
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('translate-x-full');
            });
        });
    }

    // Formspree response handler
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(contactForm);
            fetch(contactForm.action, {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json' }
            })
            .then(response => {
                if (response.ok) {
                    contactForm.reset();
                    showFormMessage('Thank you for your message!', true);
                } else {
                    showFormMessage('There was an error. Please try again.', false);
                }
            })
            .catch(() => {
                showFormMessage('There was an error. Please try again.', false);
            });
        });
    }
    function showFormMessage(msg, success) {
        let msgDiv = document.getElementById('form-msg');
        if (!msgDiv) {
            msgDiv = document.createElement('div');
            msgDiv.id = 'form-msg';
            contactForm.parentNode.insertBefore(msgDiv, contactForm);
        }
        msgDiv.textContent = msg;
        msgDiv.className = success ? 'mb-4 text-green-600 text-center' : 'mb-4 text-red-600 text-center';
    }
});

lucide.createIcons();
