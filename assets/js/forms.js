/**
 * Form handling and validation module
 */

import { isValidEmail, showNotification } from './utils.js';
import { getCurrentLanguage } from './i18n.js';
import { languages } from './translations.js';

/**
 * Initializes contact form validation and submission
 * @param {string} formId - Form element ID
 */
export function initContactForm(formId = 'contactForm') {
    const form = document.getElementById(formId);
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (validateContactForm(form)) {
            simulateFormSubmission(form);
        }
    });
    
    // Add input validation on blur
    const emailInput = form.querySelector('#email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            validateEmail(emailInput);
        });
    }
    
    const subjectInput = form.querySelector('#subject');
    if (subjectInput) {
        subjectInput.addEventListener('blur', function() {
            validateField(subjectInput, 3);
        });
    }
    
    const messageInput = form.querySelector('#message');
    if (messageInput) {
        messageInput.addEventListener('blur', function() {
            validateField(messageInput, 10);
        });
    }
}

/**
 * Validates all fields in the contact form
 * @param {HTMLFormElement} form - The form element
 * @returns {boolean} - True if valid
 */
function validateContactForm(form) {
    const emailInput = form.querySelector('#email');
    const subjectInput = form.querySelector('#subject');
    const messageInput = form.querySelector('#message');
    
    const isEmailValid = validateEmail(emailInput);
    const isSubjectValid = validateField(subjectInput, 3);
    const isMessageValid = validateField(messageInput, 10);
    
    return isEmailValid && isSubjectValid && isMessageValid;
}

/**
 * Validates an email field
 * @param {HTMLInputElement} input - The email input element
 * @returns {boolean} - True if valid
 */
function validateEmail(input) {
    if (!input) return true;
    
    const value = input.value.trim();
    const isValid = value !== '' && isValidEmail(value);
    
    updateValidationUI(input, isValid);
    
    if (!isValid && value !== '') {
        const lang = getCurrentLanguage();
        const errorMessage = languages[lang].invalid_email || 'Please enter a valid email address';
        showFieldError(input, errorMessage);
    }
    
    return isValid;
}

/**
 * Validates a text field has minimum length
 * @param {HTMLInputElement|HTMLTextAreaElement} input - The input element
 * @param {number} minLength - Minimum required length
 * @returns {boolean} - True if valid
 */
function validateField(input, minLength = 1) {
    if (!input) return true;
    
    const value = input.value.trim();
    const isValid = value.length >= minLength;
    
    updateValidationUI(input, isValid);
    
    if (!isValid && value !== '') {
        const lang = getCurrentLanguage();
        const errorMessage = languages[lang].field_too_short || `Minimum ${minLength} characters required`;
        showFieldError(input, errorMessage);
    }
    
    return isValid;
}

/**
 * Updates UI to show validation state
 * @param {HTMLElement} input - The input element
 * @param {boolean} isValid - Whether input is valid
 */
function updateValidationUI(input, isValid) {
    if (isValid) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    } else {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
    }
}

/**
 * Shows error message for a field
 * @param {HTMLElement} input - The input element
 * @param {string} message - Error message
 */
function showFieldError(input, message) {
    // Check if error message already exists
    let errorElement = input.nextElementSibling;
    if (!errorElement || !errorElement.classList.contains('invalid-feedback')) {
        errorElement = document.createElement('div');
        errorElement.className = 'invalid-feedback';
        input.parentNode.insertBefore(errorElement, input.nextSibling);
    }
    
    errorElement.textContent = message;
}

/**
 * Simulates form submission with loading state and success message
 * @param {HTMLFormElement} form - The form element
 */
function simulateFormSubmission(form) {
    const submitButton = form.querySelector('[type="submit"]');
    const originalButtonText = submitButton.innerHTML;
    
    // Show loading state
    submitButton.disabled = true;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...';
    
    // Simulate server request
    setTimeout(() => {
        // Reset form
        form.reset();
        form.querySelectorAll('.is-valid').forEach(el => el.classList.remove('is-valid'));
        
        // Reset button
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
        
        // Show success message
        const lang = getCurrentLanguage();
        const successMessage = languages[lang].message_sent_success || 'Your message has been sent successfully!';
        showNotification(successMessage, 'success');
        
        // Show thank you modal if it exists
        const thankYouModal = document.getElementById('contactSuccess');
        if (thankYouModal) {
            const bsModal = new bootstrap.Modal(thankYouModal);
            bsModal.show();
        }
    }, 1500);
}

/**
 * Initializes newsletter subscription form
 * @param {string} formSelector - CSS selector for the newsletter form
 */
export function initNewsletterForm(formSelector = '.newsletter-form') {
    const forms = document.querySelectorAll(formSelector);
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const emailInput = this.querySelector('input[type="email"]');
            if (!emailInput) return;
            
            if (validateEmail(emailInput)) {
                // Show success message
                const lang = getCurrentLanguage();
                const successMessage = languages[lang].newsletter_success || 'Thanks for subscribing to our newsletter!';
                showNotification(successMessage, 'success');
                
                // Reset form
                this.reset();
            }
        });
    });
}

/**
 * Initializes all forms on the page
 */
export function initForms() {
    initContactForm();
    initNewsletterForm();
} 