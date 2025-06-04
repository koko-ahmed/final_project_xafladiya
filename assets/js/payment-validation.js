// Form validation and payment processing
document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('bookingForm');
    const toastContainer = document.createElement('div');
    toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
    document.body.appendChild(toastContainer);

    // Create Bootstrap toast
    function showToast(message, type = 'error') {
        const toastEl = document.createElement('div');
        toastEl.className = `toast align-items-center text-white border-0`;
        toastEl.setAttribute('role', 'alert');
        toastEl.setAttribute('aria-live', 'assertive');
        toastEl.setAttribute('aria-atomic', 'true');
        
        const icon = type === 'error' ? 
            '<i class="fas fa-exclamation-circle me-2"></i>' : 
            '<i class="fas fa-check-circle me-2"></i>';
        
        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${icon}${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        
        toastContainer.appendChild(toastEl);
        const toast = new bootstrap.Toast(toastEl, {
            delay: 4000,
            animation: true
        });
        toast.show();
        
        // Remove toast after it's hidden
        toastEl.addEventListener('hidden.bs.toast', function() {
            toastEl.remove();
        });
    }

    // Form validation
    function validateForm(form) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        let emptyFields = [];

        // Remove all existing validation states
        form.querySelectorAll('.is-invalid').forEach(field => {
            field.classList.remove('is-invalid');
        });

        requiredFields.forEach(field => {
            const label = field.closest('.form-floating')?.querySelector('label')?.textContent.trim() || 
                         field.getAttribute('placeholder') || 
                         field.getAttribute('name');
            
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
                emptyFields.push(label.replace(/[*]|\s*\([^)]*\)/g, '').trim());
            }
        });

        if (!isValid) {
            showToast(`
                <div class="mb-2">✨ Please fill in the following fields:</div>
                ${emptyFields.map(field => `<div class="ms-3">• ${field}</div>`).join('')}
            `);
        }

        return isValid;
    }

    // Payment method selection
    const paymentMethods = document.querySelectorAll('input[name="paymentMethod"]');
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            // Remove active class from all labels
            document.querySelectorAll('.payment-label').forEach(label => {
                label.classList.remove('active');
            });
            
            // Add active class to selected label
            this.closest('.payment-option').querySelector('.payment-label').classList.add('active');
        });
    });

    // Handle form submission
    if (bookingForm) {
        bookingForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (validateForm(this)) {
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Processing your booking...
                `;

                try {
                    // Process payment based on selected method
                    const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked');
                    if (!paymentMethod) {
                        throw new Error('Please select a payment method');
                    }

                    // Simulate payment processing with the selected method
                    const paymentResult = await processPayment(paymentMethod.value);
                    
                    if (paymentResult.success) {
                        // Only show success message and modal after payment is confirmed
                        showToast('🎉 Booking confirmed! Redirecting to confirmation page...', 'success');
                        
                        // Hide booking modal and show success modal
                        const bookingModal = bootstrap.Modal.getInstance(document.getElementById('bookingModal'));
                        const successModal = new bootstrap.Modal(document.getElementById('paymentSuccessModal'));
                        
                        bookingModal.hide();
                        this.reset();
                        setTimeout(() => {
                            successModal.show();
                        }, 500);
                    } else {
                        throw new Error(paymentResult.error || 'Payment failed. Please try again.');
                    }
                } catch (error) {
                    showToast(error.message);
                } finally {
                    // Reset button state
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }
        });
    }
});

// Simulate payment processing
async function processPayment(paymentMethod) {
    // In a real implementation, this would make API calls to a payment processor
    return new Promise((resolve) => {
        setTimeout(() => {
            // Validate payment details based on method
            const isValid = validatePaymentDetails(paymentMethod);
            
            if (isValid) {
                resolve({ success: true });
            } else {
                resolve({ 
                    success: false, 
                    error: 'Invalid payment details. Please check and try again.' 
                });
            }
        }, 2000); // Simulate network delay
    });
}

// Validate payment details based on payment method
function validatePaymentDetails(paymentMethod) {
    if (paymentMethod === 'card') {
        const cardNumber = document.getElementById('cardNumber')?.value;
        const cardHolder = document.getElementById('cardHolder')?.value;
        const expiryDate = document.getElementById('expiryDate')?.value;
        const cvv = document.getElementById('cvv')?.value;

        return (
            cardNumber?.match(/^[0-9]{16}$/) &&
            cardHolder?.trim().length > 0 &&
            expiryDate?.match(/^(0[1-9]|1[0-2])\/([0-9]{2})$/) &&
            cvv?.match(/^[0-9]{3,4}$/)
        );
    } else if (paymentMethod === 'evc') {
        const phoneNumber = document.getElementById('phoneNumber')?.value;
        return phoneNumber?.match(/^[0-9]{10}$/);
    }

    return false;
} 