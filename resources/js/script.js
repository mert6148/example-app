/**
 * Script.js - Ek DOM olay dinleyicileri ve işlevleri
 */

/**
 * DOM Ready'de başlat
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('✓ Script.js yüklendi');

    // Sayfa yüklendikten sonra çalıştırılacak kodlar
    initializeEventListeners();
    setupAnimations();
    setupScrollEffects();
});

/**
 * Olay dinleyicilerini başlat
 */
function initializeEventListeners() {
    // Buton click event'leri
    const buttons = document.querySelectorAll('button, [role="button"]');
    buttons.forEach(button => {
        button.addEventListener('click', handleButtonClick);
    });

    // Form gönderme event'leri
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', handleFormSubmit);
    });

    // Input change event'leri
    const inputs = document.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('change', handleInputChange);
        input.addEventListener('input', handleInputInput);
    });
}

/**
 * Buton click handler
 */
function handleButtonClick(event) {
    const button = event.currentTarget;
    const action = button.getAttribute('data-action');

    console.log(`Button clicked: ${action || 'unknown'}`);

    // Loading durumu ekle
    const originalText = button.textContent;
    button.disabled = true;
    button.textContent = 'İşleniyor...';

    // 1 saniye sonra eski duruma döndür (demo)
    setTimeout(() => {
        button.disabled = false;
        button.textContent = originalText;
    }, 1000);
}

/**
 * Form gönderme handler
 */
function handleFormSubmit(event) {
    const form = event.currentTarget;
    const formData = new FormData(form);

    console.log('Form gönderiliyor:', {
        action: form.action,
        fields: Array.from(formData.entries())
    });

    // Form geçerleme
    if (!validatePreviousForm(form)) {
        event.preventDefault();
        console.warn('Form geçerlemesi başarısız');
    }
}

/**
 * Input change handler
 */
function handleInputChange(event) {
    const input = event.currentTarget;
    console.log(`Input changed: ${input.name || input.id} = ${input.value}`);
}

/**
 * Input input handler
 */
function handleInputInput(event) {
    const input = event.currentTarget;

    // Real-time işlemler
    if (input.type === 'email') {
        validateEmail(input.value);
    } else if (input.type === 'password') {
        validatePasswordStrength(input.value);
    }
}

/**
 * Email geçerleme
 */
function validateEmail(email) {
    const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    console.log(`Email valid: ${isValid}`);
    return isValid;
}

/**
 * Şifre gücü geçerleme
 */
function validatePasswordStrength(password) {
    let strength = 0;

    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[@$!%*?&]/.test(password)) strength++;

    const strengthLabels = ['Zayıf', 'Orta', 'İyi', 'Güçlü', 'Çok Güçlü'];
    console.log(`Şifre gücü: ${strengthLabels[strength] || 'Zayıf'}`);

    return strength;
}

/**
 * Form geçerleme
 */
function validatePreviousForm(form) {
    const inputs = form.querySelectorAll('[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value || input.value.trim() === '') {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });

    return isValid;
}

/**
 * Animasyonları başlat
 */
function setupAnimations() {
    // Görünümü sağlayan elemanları tanımla
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('[data-animate]').forEach(el => {
        observer.observe(el);
    });
}

/**
 * Scroll efektlerini başlat
 */
function setupScrollEffects() {
    let ticking = false;

    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                handleScroll();
                ticking = false;
            });
            ticking = true;
        }
    });
}

/**
 * Scroll event handler
 */
function handleScroll() {
    const scrollTop = window.scrollY;

    // Navbar'ı sabitle
    const navbar = document.querySelector('nav');
    if (navbar && scrollTop > 50) {
        navbar.classList.add('scrolled');
    } else if (navbar) {
        navbar.classList.remove('scrolled');
    }

    // Geri dön butonunu göster/gizle
    const backToTop = document.getElementById('back-to-top');
    if (backToTop) {
        if (scrollTop > 300) {
            backToTop.style.display = 'block';
        } else {
            backToTop.style.display = 'none';
        }
    }
}

/**
 * Geri dön butonunun event'i
 */
document.addEventListener('DOMContentLoaded', () => {
    const backToTopBtn = document.getElementById('back-to-top');
    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});

console.log('✓ Inline event listeners başlatıldı');
