// Search functionality
function handleSearch() {
    const searchInput = document.getElementById('searchInput');
    const searchTerm = searchInput.value.trim();
    
    if (searchTerm) {
        window.location.href = `search.php?q=${encodeURIComponent(searchTerm)}`;
    } else {
        searchInput.style.borderColor = 'red';
        setTimeout(() => searchInput.style.borderColor = '#ddd', 2000);
    }
}

// Form validation
function validateForm(form) {
    let isValid = true;
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.style.borderColor = 'red';
            setTimeout(() => input.style.borderColor = '#ddd', 2000);
        }
    });
    
    if (!isValid) {
        const errorElement = form.querySelector('.error-message') || createErrorMessage(form);
        errorElement.textContent = 'Please fill in all required fields';
    }
    
    return isValid;
}

function createErrorMessage(form) {
    const errorElement = document.createElement('div');
    errorElement.className = 'error-message';
    errorElement.style.color = 'red';
    errorElement.style.margin = '10px 0';
    form.prepend(errorElement);
    return errorElement;
}

// Mobile menu handling
function setupMobileMenu() {
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const mainNav = document.querySelector('.main-nav');
    
    if (!mobileToggle || !mainNav) return;
    
    function toggleMenu() {
        mainNav.classList.toggle('active');
        mobileToggle.classList.toggle('fa-times');
    }
    
    mobileToggle.addEventListener('click', toggleMenu);
    
    // Close when clicking outside or on links
    document.addEventListener('click', (e) => {
        if (!mainNav.contains(e.target) && !mobileToggle.contains(e.target)) {
            mainNav.classList.remove('active');
            mobileToggle.classList.remove('fa-times');
        }
    });
    
    // Smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
}

// Initialize everything
document.addEventListener('DOMContentLoaded', function() {
    // Search
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') handleSearch();
        });
    }
    
    // Forms
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) e.preventDefault();
        });
    });
    
    // Mobile menu
    setupMobileMenu();
});