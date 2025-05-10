/**
 * Internationalization module for Xafladia
 */

// Import translations
import { languages } from './translations.js';

// Current language (default to English if not set)
let currentLanguage = localStorage.getItem('language') || 'en';

/**
 * Sets up language switcher functionality
 */
export function setupLanguageSwitcher() {
    const languageButtons = document.querySelectorAll('.language-btn');
    
    languageButtons.forEach(button => {
        const lang = button.getAttribute('data-language');
        
        // Add active class to current language button
        if (lang === currentLanguage) {
            button.classList.add('active');
        }
        
        // Add click event
        button.addEventListener('click', () => {
            // Skip if already active
            if (lang === currentLanguage) return;
            
            // Update current language
            currentLanguage = lang;
            
            // Save to localStorage
            localStorage.setItem('language', lang);
            
            // Update UI
            languageButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            
            // Apply translation
            applyLanguage(lang);
            
            // Update dynamic content
            translateDynamicContent(lang);
        });
    });
}

/**
 * Applies language to all elements with data-i18n attribute
 * @param {string} lang - Language code (en, so)
 */
export function applyLanguage(lang) {
    if (!languages[lang]) return;
    
    document.querySelectorAll('[data-i18n]').forEach(element => {
        const key = element.getAttribute('data-i18n');
        const translation = languages[lang][key];
        
        if (translation) {
            // Special handling for placeholders
            if (element.hasAttribute('placeholder')) {
                element.setAttribute('placeholder', translation);
            } else {
                element.textContent = translation;
            }
        }
    });
}

/**
 * Translates dynamic content like document title
 * @param {string} lang - Language code (en, so)
 */
export function translateDynamicContent(lang) {
    if (!languages[lang]) return;
    
    // Translate document title
    const pageTitleKey = getPageTitleKey();
    if (pageTitleKey && languages[lang][pageTitleKey]) {
        document.title = `Xafladia - ${languages[lang][pageTitleKey]}`;
    }
}

/**
 * Gets page title key based on current URL
 * @returns {string|null} - Title key or null
 */
function getPageTitleKey() {
    const url = window.location.href;
    
    if (url.includes('services.html')) return 'our_services_title';
    if (url.includes('events.html')) return 'events_title';
    if (url.includes('about.html')) return 'about_xafladia';
    if (url.includes('gallery.html')) return 'nav_gallery';
    if (url.includes('cameraman.html')) return 'nav_cameraman';
    if (url.includes('contact.html')) return 'nav_contact';
    
    return 'home_title';
}

/**
 * Initializes i18n attributes on DOM elements
 */
export function initializeI18nAttributes() {
    // Common navigation elements
    applyI18nAttribute('.nav-home', 'nav_home');
    applyI18nAttribute('.nav-events', 'nav_events');
    applyI18nAttribute('.nav-services', 'nav_services');
    applyI18nAttribute('.nav-about', 'nav_about');
    applyI18nAttribute('.nav-gallery', 'nav_gallery');
    applyI18nAttribute('.nav-cameraman', 'nav_cameraman');
    applyI18nAttribute('.nav-contact', 'nav_contact');
    
    // Footer elements
    applyI18nAttribute('[data-i18n="footer_description"]', 'footer_description');
    applyI18nAttribute('[data-i18n="quick_links"]', 'quick_links');
    applyI18nAttribute('[data-i18n="our_services"]', 'our_services');
    applyI18nAttribute('[data-i18n="contact_info"]', 'contact_info');
    applyI18nAttribute('[data-i18n="copyright"]', 'copyright');
    applyI18nAttribute('[data-i18n="privacy_policy"]', 'privacy_policy');
    applyI18nAttribute('[data-i18n="terms_conditions"]', 'terms_conditions');
    
    // Common button text
    applyI18nAttribute('[data-i18n="learn_more"]', 'learn_more');
    applyI18nAttribute('[data-i18n="contact_us_button"]', 'contact_us_button');
    applyI18nAttribute('[data-i18n="explore_events_button"]', 'explore_events_button');
    applyI18nAttribute('[data-i18n="close"]', 'close');
}

/**
 * Helper function to apply data-i18n attribute to elements
 * @param {string} selector - CSS selector
 * @param {string} key - Translation key
 * @param {boolean} isPlaceholder - Is this for a placeholder attribute
 */
export function applyI18nAttribute(selector, key, isPlaceholder = false) {
    const elements = document.querySelectorAll(selector);
    
    elements.forEach(element => {
        if (element) {
            element.setAttribute('data-i18n', key);
            
            // If this is a placeholder, translate it immediately
            if (isPlaceholder && languages[currentLanguage][key]) {
                element.setAttribute('placeholder', languages[currentLanguage][key]);
            }
        }
    });
}

/**
 * Initialize language support
 */
export function initializeLanguage() {
    // Set up language switcher
    setupLanguageSwitcher();
    
    // Initialize i18n attributes
    initializeI18nAttributes();
    
    // Apply current language
    applyLanguage(currentLanguage);
    
    // Translate dynamic content
    translateDynamicContent(currentLanguage);
}

// Export current language getter
export function getCurrentLanguage() {
    return currentLanguage;
} 