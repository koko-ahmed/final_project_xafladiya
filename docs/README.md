# Xafladia - Event Planning Platform

Xafladia is a comprehensive event planning platform tailored for Somalia, offering a range of services from venue booking to catering and decoration.

## 🔄 Refactored Codebase

This project has been refactored to improve organization, maintainability, and scalability using modern front-end practices.

### Key Improvements

- **Modular CSS**: Split into variables, layout, components, and page-specific styles
- **Component-Based Architecture**: Reusable UI components for consistent design
- **JavaScript Modules**: Properly structured JS with clear separation of concerns
- **Internationalization**: Enhanced multi-language support (English/Somali)
- **Template System**: Dynamic content loading and rendering
- **Build System**: Vite-based build process for modern development

## 📁 Project Structure

```
xafladia/
├── src/                  # Source files
│   ├── assets/           # Static assets
│   │   ├── images/       # Images and icons
│   │   └── fonts/        # Custom fonts
│   ├── components/       # Reusable HTML components
│   │   ├── header.html
│   │   ├── footer.html
│   │   ├── service-card.html
│   │   └── ...
│   ├── css/              # CSS modules
│   │   ├── variables.css # Variables and theme configuration
│   │   ├── layout.css    # Layout styles
│   │   ├── components.css # Component styles
│   │   ├── pages.css     # Page-specific styles
│   │   └── main.css      # Main CSS file importing all modules
│   ├── js/               # JavaScript modules
│   │   ├── utils.js      # Utility functions
│   │   ├── i18n.js       # Internationalization module
│   │   ├── forms.js      # Form handling and validation
│   │   ├── template-loader.js # Template system
│   │   ├── translations.js # Language translations
│   │   └── main.js       # Main JavaScript entry point
│   └── templates/        # Page templates
│       ├── index.html
│       ├── services.html
│       └── ...
├── public/              # Built files (generated)
├── package.json         # Project configuration
└── README.md            # Project documentation
```

## 🚀 Getting Started

### Prerequisites

- Node.js (v14+)
- npm or yarn

### Installation

1. Clone the repository

   ```bash
   git clone https://github.com/your-username/xafladia.git
   cd xafladia
   ```

2. Install dependencies

   ```bash
   npm install
   ```

3. Start the development server

   ```bash
   npm run dev
   ```

4. Build for production

   ```bash
   npm run build
   ```

5. Preview production build
   ```bash
   npm run preview
   ```

## 🌐 Internationalization

The platform supports both English and Somali languages. Language switching is handled by the `i18n.js` module and language-specific content is defined in `translations.js`.

## 🎨 Theming and Customization

The theme is controlled through CSS variables in `src/css/variables.css`. You can easily customize:

- Color scheme
- Typography
- Spacing
- Shadows
- Border radii

## 📱 Responsive Design

The platform is fully responsive and works across:

- Desktop
- Tablet
- Mobile devices

## 🧩 Components

Reusable components are stored in `src/components/` and can be loaded dynamically using the template loader:

```javascript
import { loadTemplate } from "./js/template-loader.js";

// Load header and footer
loadTemplate("../components/header.html", "#header-container");
loadTemplate("../components/footer.html", "#footer-container");
```

## 📋 Feature Roadmap

- [ ] User Authentication System
- [ ] Online Booking and Payment
- [ ] Vendor Management Portal
- [ ] Admin Dashboard
- [ ] Customer Reviews and Ratings
- [ ] Event Planning Timeline Tool
- [ ] Mobile App Version

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.
