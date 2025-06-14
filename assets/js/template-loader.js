/**
 * Template loader module
 * Handles loading and processing HTML templates
 */

/**
 * Loads an HTML template and inserts it into an element
 * @param {string} url - URL of the template file
 * @param {string} targetSelector - Selector of target element
 * @returns {Promise} - Promise that resolves when template is loaded
 */
export function loadTemplate(url, targetSelector) {
    const targetElement = document.querySelector(targetSelector);
    if (!targetElement) {
        console.error(`Target element not found: ${targetSelector}`);
        return Promise.reject(`Target element not found: ${targetSelector}`);
    }
    
    return fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Failed to load template: ${url}`);
            }
            return response.text();
        })
        .then(html => {
            targetElement.innerHTML = html;
            return targetElement;
        })
        .catch(error => {
            console.error('Error loading template:', error);
            throw error;
        });
}

/**
 * Processes a template by replacing placeholders with values
 * @param {string} templateId - ID of template element
 * @param {Object} data - Object with placeholder values
 * @returns {HTMLElement} - Processed template
 */
export function processTemplate(templateId, data) {
    const template = document.getElementById(templateId);
    if (!template) {
        console.error(`Template not found: ${templateId}`);
        return null;
    }
    
    let html = template.innerHTML;
    
    // Replace placeholders
    for (const [key, value] of Object.entries(data)) {
        const placeholder = new RegExp(`%${key}%`, 'g');
        html = html.replace(placeholder, value);
    }
    
    // Create temporary element to hold processed HTML
    const tempContainer = document.createElement('div');
    tempContainer.innerHTML = html;
    
    return tempContainer.firstElementChild;
}

/**
 * Creates elements from a template and data array
 * @param {string} templateId - ID of template element
 * @param {Array} dataArray - Array of data objects
 * @param {string} containerSelector - Selector of container element
 */
export function renderTemplateList(templateId, dataArray, containerSelector) {
    const container = document.querySelector(containerSelector);
    if (!container) {
        console.error(`Container not found: ${containerSelector}`);
        return;
    }
    
    // Clear container
    container.innerHTML = '';
    
    // Process each data item
    dataArray.forEach(data => {
        const element = processTemplate(templateId, data);
        if (element) {
            container.appendChild(element);
        }
    });
}

/**
 * Loads all common components (header, footer)
 * @returns {Promise} - Promise that resolves when all components are loaded
 */
export function loadCommonComponents() {
    const promises = [
        loadTemplate('../components/header.html', '#header-container'),
        loadTemplate('../components/footer.html', '#footer-container')
    ];
    
    return Promise.all(promises);
}

/**
 * Creates HTML from a component template with data
 * @param {string} templateUrl - URL of the component file
 * @param {Object} data - Data to fill placeholders
 * @returns {Promise<string>} - Promise resolving to processed HTML
 */
export function getComponentHtml(templateUrl, data) {
    return fetch(templateUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Failed to load component: ${templateUrl}`);
            }
            return response.text();
        })
        .then(html => {
            // Replace placeholders
            for (const [key, value] of Object.entries(data)) {
                const placeholder = new RegExp(`%${key}%`, 'g');
                html = html.replace(placeholder, value);
            }
            
            return html;
        })
        .catch(error => {
            console.error('Error loading component:', error);
            throw error;
        });
} 