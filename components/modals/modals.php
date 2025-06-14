<?php
// Modals Component
// Get the base path for assets based on whether we're in the home page or not
$base_path = isset($is_home) && $is_home ? '' : '../../';
?>

<!-- Coming Soon Modal -->
<div
  class="modal fade"
  id="comingSoonModal"
  tabindex="-1"
  aria-labelledby="comingSoonModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="comingSoonModalLabel">Coming Soon</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <p>
          This page is currently under development and will be available soon.
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Close
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Contact Modal -->
<div
  class="modal fade"
  id="contactModal"
  tabindex="-1"
  aria-labelledby="contactModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="contactModalLabel">Contact Us</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <form id="contactForm" action="<?php echo $base_path; ?>pages/process_contact.php" method="POST">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="name"
                  name="name"
                  placeholder="Your Name"
                  required
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  name="email"
                  placeholder="Your Email"
                  required
                />
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="subject" class="form-label">Subject</label>
            <input
              type="text"
              class="form-control"
              id="subject"
              name="subject"
              placeholder="Subject"
              required
            />
          </div>
          <div class="form-group">
            <label for="message" class="form-label">Message</label>
            <textarea
              class="form-control"
              id="message"
              name="message"
              rows="5"
              placeholder="Your Message"
              required
            ></textarea>
          </div>
          <div class="success-message" id="contactSuccess">
            <div class="success-icon">
              <i class="fas fa-check-circle"></i>
            </div>
            <h4>Thank You!</h4>
            <p>
              Your message has been sent successfully. We'll get back to you
              shortly.
            </p>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" form="contactForm" class="btn btn-primary" id="sendMessageBtn">
          Send Message
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Video Modal -->
<div
  class="modal fade"
  id="videoModal"
  tabindex="-1"
  aria-labelledby="videoModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="videoModalLabel">Xafladia Introduction</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body p-0">
        <div class="ratio ratio-16x9">
          <iframe
            src="https://www.youtube.com/embed/qC_T9ePzANg?controls=1&showinfo=0&rel=0"
            title="Xafladia Introduction"
            allowfullscreen
          ></iframe>
        </div>
      </div>
    </div>
  </div>
</div> 