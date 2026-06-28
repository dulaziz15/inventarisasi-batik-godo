# Implementation Plan: UI/UX Refactoring

## Overview

This implementation plan transforms the Batik Banyuwangi inventory application from a Bootstrap 5.3.3 + Tailwind CSS mixed approach to a unified Tailwind CSS 4-only design system. The refactoring implements WCAG 2.1 Level AA accessibility standards, establishes a cohesive cultural design language, and optimizes performance across all devices.

The implementation follows a 6-week phased approach:
- **Phase 1 (Week 1)**: Foundation - Tailwind CSS 4 setup, design tokens, file structure
- **Phase 2 (Weeks 2-3)**: Component Library - 10 reusable Blade components with accessibility
- **Phase 3 (Week 4)**: Page Migration - Migrate all public, auth, and admin pages
- **Phase 4 (Week 5)**: Testing and Refinement - Visual regression, accessibility audit, performance optimization
- **Phase 5 (Week 6)**: Deployment - Pre-deployment prep, production deployment, verification

## Tasks

### Phase 1: Foundation (Week 1)

- [ ] 1. Setup Tailwind CSS 4 Configuration and Design System
  - [-] 1.1 Create Tailwind CSS 4 configuration file with design tokens
    - Create `tailwind.config.js` with complete color palette (batik-ink, batik-clay, batik-emerald, batik-amber, batik-cream)
    - Define typography scale with Cormorant Garamond (serif) and Manrope (sans) font families
    - Configure spacing scale, border radius values, box shadows, and animation keyframes
    - Set up responsive breakpoints (mobile: 0-767px, tablet: 768-1023px, desktop: 1024px+)
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5, 2.6, 2.7, 2.8, 6.1, 6.2, 6.3_
  
  - [-] 1.2 Create main CSS entry point with custom layers
    - Create `resources/css/app.css` with Tailwind imports and custom @theme definitions
    - Define base layer styles (typography, focus-visible, scrollbar, reduced motion support)
    - Define component layer styles (pattern-batik, glass morphism, surface-card)
    - Define utility layer styles (text-balance, gradient-text, touch-target, sr-only)
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5, 2.6, 1.1, 1.2, 1.3, 1.5, 1.8, 13.8_

  - [-] 1.3 Update Vite configuration for Tailwind CSS 4
    - Update `vite.config.js` to include Tailwind CSS 4 Vite plugin
    - Configure CSS purging for production builds
    - Set up source maps for development
    - _Requirements: 2.8, 3.6, 5.4_
  
  - [ ] 1.4 Establish file structure for components and styles
    - Create directory structure: `resources/views/components/ui/` for UI components
    - Create directory structure: `resources/views/components/layout/` for layout components
    - Create directory structure: `resources/css/components/` for component-specific styles
    - Create directory structure: `resources/css/utilities/` for custom utilities
    - Create directory structure: `resources/css/base/` for base styles
    - Create directory structure: `resources/js/components/` for interactive JavaScript
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5, 2.6, 2.7, 2.8_

- [ ] 2. Remove Bootstrap Dependencies
  - [~] 2.1 Remove Bootstrap from package.json and rebuild
    - Remove Bootstrap 5.3.3 from `package.json` dependencies
    - Run `npm install` to update lock file
    - _Requirements: 3.1, 3.6_
  
  - [~] 2.2 Remove Bootstrap CDN links from layout files
    - Remove Bootstrap CSS CDN link from `resources/views/layout/app.blade.php`
    - Remove Bootstrap JS CDN link from `resources/views/layout/app.blade.php`
    - Remove Bootstrap CSS CDN link from `resources/views/layout/admin.blade.php`
    - Remove Bootstrap JS CDN link from `resources/views/layout/admin.blade.php`
    - _Requirements: 3.1, 3.6_
  
  - [~] 2.3 Update Vite entry points to use only Tailwind CSS
    - Update `resources/js/app.js` to import `resources/css/app.css`
    - Remove any Bootstrap imports from JavaScript files
    - Build assets with `npm run build` to verify no Bootstrap in output
    - _Requirements: 3.1, 3.6, 5.4_

- [~] 3. Checkpoint - Foundation Complete
  - Verify Tailwind CSS 4 configuration is working correctly
  - Verify Bootstrap is completely removed from build output
  - Verify file structure is established
  - Ensure all tests pass, ask the user if questions arise.


### Phase 2: Component Library (Weeks 2-3)

- [ ] 4. Create Core UI Components (Part 1)
  - [~] 4.1 Create Button component with all variants
    - Create `resources/views/components/ui/button.blade.php` with props (variant, size, type, disabled, loading, icon, iconPosition, href)
    - Implement variants: primary, secondary, outline, ghost, danger
    - Implement sizes: sm, md, lg
    - Implement loading state with spinner animation
    - Implement icon support with Font Awesome
    - Add ARIA attributes and keyboard accessibility
    - Ensure minimum 44x44px touch targets
    - _Requirements: 12.1, 1.1, 1.2, 1.6, 13.1, 13.2, 14.2, 14.3, 14.4_
  
  - [~] 4.2 Create Card component with variants
    - Create `resources/views/components/ui/card.blade.php` with props (variant, padding, hover)
    - Implement variants: default, glass, elevated
    - Implement padding options: none, sm, md, lg
    - Implement header and footer slots
    - Add hover lift effect option
    - _Requirements: 12.2, 6.5, 13.1, 13.2_
  
  - [~] 4.3 Create Badge component with variants
    - Create `resources/views/components/ui/badge.blade.php` with props (variant, size, icon)
    - Implement variants: default, success, warning, danger, sacred
    - Implement sizes: sm, md, lg
    - Add icon support with proper spacing
    - Implement sacred motif styling with red accent and shadow
    - _Requirements: 12.3, 6.6, 14.2, 14.4_

- [ ] 5. Create Core UI Components (Part 2)
  - [~] 5.1 Create Input component with validation states
    - Create `resources/views/components/ui/input.blade.php` with props (type, name, label, placeholder, value, error, required, disabled, icon, iconPosition, helpText)
    - Implement input types: text, email, password, number, tel, url, search
    - Implement error state styling with red border and error message
    - Implement icon support (left/right positioning)
    - Add ARIA attributes (aria-invalid, aria-describedby, aria-required)
    - Implement focus ring with 3px outline and sufficient contrast
    - Associate labels with inputs using for attribute
    - _Requirements: 12.4, 8.1, 8.2, 8.3, 8.5, 8.8, 1.1, 1.2, 1.4, 14.2_

  
  - [~] 5.2 Create Select component with custom styling
    - Create `resources/views/components/ui/select.blade.php` with props (name, label, options, selected, placeholder, error, required, disabled)
    - Implement custom dropdown arrow using SVG data URI
    - Implement error state styling
    - Add ARIA attributes (aria-invalid, aria-describedby, aria-required)
    - Implement focus ring with 3px outline
    - Associate labels with selects using for attribute
    - _Requirements: 12.5, 8.1, 8.2, 8.5, 8.8, 1.1, 1.2, 1.4_
  
  - [~] 5.3 Create Alert component with variants
    - Create `resources/views/components/ui/alert.blade.php` with props (variant, dismissible, icon, title)
    - Implement variants: success, error, warning, info
    - Implement auto-icon selection based on variant
    - Implement dismissible functionality with close button
    - Add ARIA role="alert" for screen reader announcements
    - Implement slide-in and fade-out animations
    - _Requirements: 12.6, 8.4, 10.3, 1.5, 13.7, 14.4, 14.5_

- [ ] 6. Create Advanced UI Components
  - [~] 6.1 Create Modal component with accessibility
    - Create `resources/views/components/ui/modal.blade.php` with props (id, title, size, dismissible)
    - Implement backdrop with blur effect
    - Implement close button with keyboard escape handling
    - Add ARIA attributes (role="dialog", aria-modal="true", aria-labelledby)
    - Implement focus trap to keep focus within modal
    - Implement fade-in and scale-in animations
    - Add keyboard accessibility (Escape to close, Tab to cycle focus)
    - _Requirements: 12.7, 1.1, 1.2, 1.5, 13.2, 13.8_
  
  - [~] 6.2 Create Breadcrumb component
    - Create `resources/views/components/ui/breadcrumb.blade.php` with items array prop
    - Implement breadcrumb navigation with proper ARIA attributes (aria-label="breadcrumb")
    - Style active and inactive breadcrumb items
    - Add separator icons between items
    - _Requirements: 12.8, 7.5, 14.2, 14.5_
  
  - [~] 6.3 Create Pagination component
    - Create `resources/views/components/ui/pagination.blade.php` compatible with Laravel pagination
    - Implement previous/next buttons with icons
    - Implement page number buttons with active state
    - Add ARIA attributes (aria-label, aria-current)
    - Ensure minimum 44x44px touch targets for all buttons
    - _Requirements: 12.9, 1.1, 1.6, 14.2_

  
  - [~] 6.4 Create Skeleton loader component
    - Create `resources/views/components/ui/skeleton.blade.php` with props (type, count, height, width)
    - Implement skeleton types: text, card, image, button
    - Implement pulse animation for loading effect
    - Add ARIA attribute aria-busy="true" and aria-live="polite"
    - _Requirements: 12.10, 9.1, 9.2, 1.5_

- [ ] 7. Create Layout Components
  - [~] 7.1 Create Navbar component for public pages
    - Create `resources/views/components/layout/navbar.blade.php`
    - Implement responsive navigation with hamburger menu for mobile
    - Implement active link highlighting
    - Add ARIA attributes (role="navigation", aria-label, aria-expanded for mobile menu)
    - Implement sticky positioning with shadow on scroll
    - Ensure all navigation links have minimum 44x44px touch targets
    - _Requirements: 7.1, 7.2, 4.2, 4.7, 1.1, 1.2, 1.6, 14.2_
  
  - [~] 7.2 Create Sidebar component for admin panel
    - Create `resources/views/components/layout/sidebar.blade.php`
    - Implement collapsible sidebar for mobile
    - Implement active link highlighting with icon and text
    - Add ARIA attributes (role="navigation", aria-label, aria-current)
    - Implement smooth transitions for collapse/expand
    - _Requirements: 11.4, 7.1, 7.2, 1.1, 1.2, 13.1, 14.2_
  
  - [~] 7.3 Create Footer component
    - Create `resources/views/components/layout/footer.blade.php`
    - Implement dark background with warm accent colors (batik-clay, batik-amber)
    - Implement responsive grid layout (stacked on mobile, multi-column on desktop)
    - Add ARIA landmark role="contentinfo"
    - Style footer links with hover effects
    - _Requirements: 6.7, 4.1, 1.2, 14.2_

- [~] 8. Checkpoint - Component Library Complete
  - Verify all 10 UI components are created and functional
  - Verify all components have proper accessibility attributes
  - Verify all components follow design system tokens
  - Test components in isolation with different props
  - Ensure all tests pass, ask the user if questions arise.


### Phase 3: Page Migration (Week 4)

- [ ] 9. Migrate Public Layout and Pages
  - [~] 9.1 Refactor public layout (app.blade.php)
    - Update `resources/views/layout/app.blade.php` to use new Navbar and Footer components
    - Replace Bootstrap grid classes with Tailwind CSS flexbox/grid utilities
    - Add proper ARIA landmarks (role="main" for main content)
    - Implement pattern-batik background on hero sections
    - Update font loading to use font-display: swap
    - _Requirements: 3.2, 7.1, 1.2, 6.4, 5.2_
  
  - [~] 9.2 Migrate home page
    - Update `resources/views/public/home.blade.php` to use new Card and Button components
    - Replace Bootstrap classes with Tailwind CSS utilities
    - Implement hero section with batik pattern overlay
    - Implement responsive grid for feature cards (1 column mobile, 3 columns desktop)
    - Add lazy loading for images below the fold
    - Ensure proper heading hierarchy (h1 for main title, h2 for sections)
    - _Requirements: 3.2, 3.3, 4.1, 4.4, 5.3, 1.7, 6.4_
  
  - [~] 9.3 Migrate catalog page
    - Update `resources/views/public/catalog.blade.php` to use new Input, Select, Card, and Badge components
    - Replace Bootstrap form controls with new Input and Select components
    - Implement responsive motif grid (1 column mobile, 2 columns tablet, 3 columns desktop)
    - Implement search and filter controls with proper ARIA labels
    - Update URL with query parameters when filters are applied
    - Add empty state message when no results found
    - Implement Skeleton loaders for loading state
    - _Requirements: 3.2, 3.3, 4.3, 4.4, 7.3, 7.4, 10.1, 9.1, 9.5_
  
  - [~] 9.4 Migrate motif detail page
    - Update `resources/views/public/motif-detail.blade.php` to use new Card, Badge, and Breadcrumb components
    - Replace Bootstrap layout with Tailwind CSS grid (stacked on mobile, side-by-side on desktop)
    - Implement Breadcrumb navigation trail
    - Implement sacred motif badge with distinct styling
    - Add image placeholder for loading state
    - Implement responsive image sizing
    - Ensure proper heading hierarchy
    - _Requirements: 3.2, 3.3, 4.5, 6.6, 7.5, 9.2, 4.8, 1.7_

  
  - [~] 9.5 Migrate about and contact pages
    - Update `resources/views/public/about.blade.php` to use new Card component
    - Update `resources/views/public/contact.blade.php` to use new Card component
    - Replace Bootstrap classes with Tailwind CSS utilities
    - Implement responsive layouts (single column mobile, multi-column desktop)
    - Ensure proper heading hierarchy
    - _Requirements: 3.2, 3.3, 4.1, 1.7_

- [ ] 10. Migrate Authentication Pages
  - [~] 10.1 Migrate login page
    - Update `resources/views/auth/login.blade.php` to use new Input, Button, and Alert components
    - Replace Bootstrap form controls with new components
    - Implement form validation error display with inline error messages
    - Implement loading state on submit button
    - Add ARIA attributes for form accessibility
    - Implement responsive layout (centered card on all devices)
    - _Requirements: 3.2, 3.3, 3.4, 8.1, 8.2, 8.3, 8.4, 8.7, 9.3, 4.1_

- [ ] 11. Migrate Admin Layout and Pages
  - [~] 11.1 Refactor admin layout (admin.blade.php)
    - Update `resources/views/layout/admin.blade.php` to use new Sidebar component
    - Replace Bootstrap grid classes with Tailwind CSS flexbox/grid utilities
    - Update alert messages to use new Alert component
    - Add proper ARIA landmarks (role="main", role="navigation")
    - Implement responsive layout (collapsible sidebar on mobile)
    - _Requirements: 3.2, 11.1, 11.5, 1.2, 4.2_
  
  - [~] 11.2 Migrate admin dashboard page
    - Update `resources/views/admin/dashboard.blade.php` to use new Card and Badge components
    - Replace Bootstrap classes with Tailwind CSS utilities
    - Implement responsive grid for stat cards (1 column mobile, 2 columns tablet, 4 columns desktop)
    - Implement consistent card styling with shadows and borders
    - _Requirements: 3.2, 3.3, 11.2, 11.6, 4.1, 4.4_
  
  - [~] 11.3 Migrate admin motif management pages
    - Update `resources/views/admin/motifs/index.blade.php` to use new Button, Badge, and Pagination components
    - Update `resources/views/admin/motifs/create.blade.php` to use new Input, Select, Button, and Alert components
    - Update `resources/views/admin/motifs/edit.blade.php` to use new Input, Select, Button, and Alert components
    - Replace Bootstrap table styling with Tailwind CSS table utilities
    - Implement form validation with inline error messages
    - Implement loading states on form submission
    - Add "back to list" links for easy navigation
    - _Requirements: 3.2, 3.3, 3.4, 11.2, 11.3, 11.7, 7.6, 8.1, 8.2, 8.3, 8.7, 9.3_

  
  - [~] 11.4 Migrate admin information and account pages
    - Update `resources/views/admin/information/index.blade.php` to use new Button and Card components
    - Update `resources/views/admin/information/edit.blade.php` to use new Input, Button, and Alert components
    - Update `resources/views/admin/account/edit.blade.php` to use new Input, Button, and Alert components
    - Replace Bootstrap form controls with new components
    - Implement form validation with inline error messages
    - Implement consistent styling with public interface
    - _Requirements: 3.2, 3.3, 3.4, 11.1, 11.3, 8.1, 8.2, 8.3_

- [~] 12. Checkpoint - Page Migration Complete
  - Verify all public pages are migrated and functional
  - Verify all auth pages are migrated and functional
  - Verify all admin pages are migrated and functional
  - Verify no Bootstrap classes remain in any view files
  - Test navigation flows across all pages
  - Ensure all tests pass, ask the user if questions arise.

### Phase 4: Testing and Refinement (Week 5)

- [ ] 13. Accessibility Testing and Fixes
  - [~] 13.1 Conduct keyboard navigation testing
    - Test all pages with keyboard-only navigation (Tab, Shift+Tab, Enter, Escape)
    - Verify visible focus indicators on all interactive elements
    - Verify logical tab order follows visual layout
    - Fix any keyboard accessibility issues found
    - _Requirements: 1.1, 1.2_
  
  - [~] 13.2 Conduct screen reader testing
    - Test all pages with NVDA (Windows) or VoiceOver (Mac)
    - Verify all interactive elements have proper ARIA labels
    - Verify all images have appropriate alt text
    - Verify form errors are announced to screen readers
    - Verify dynamic content updates are announced with ARIA live regions
    - Fix any screen reader accessibility issues found
    - _Requirements: 1.2, 1.4, 1.5, 1.8_
  
  - [~] 13.3 Conduct color contrast testing
    - Use browser DevTools or axe DevTools to check color contrast ratios
    - Verify minimum 4.5:1 contrast for normal text
    - Verify minimum 3:1 contrast for large text
    - Fix any color contrast issues found
    - _Requirements: 1.3_
  
  - [~] 13.4 Conduct touch target testing
    - Test all interactive elements on touch devices (or browser DevTools device emulation)
    - Verify all touch targets are minimum 44x44 pixels
    - Fix any touch target size issues found
    - _Requirements: 1.6_


- [ ] 14. Performance Optimization
  - [~] 14.1 Optimize CSS bundle size
    - Run production build with `npm run build`
    - Verify Tailwind CSS purging is removing unused classes
    - Analyze CSS bundle size and compare to baseline
    - Optimize custom CSS if bundle is too large
    - _Requirements: 5.4, 5.5_
  
  - [~] 14.2 Optimize font loading
    - Verify font-display: swap is applied to Google Fonts
    - Consider self-hosting fonts for better performance
    - Preload critical fonts in layout head
    - _Requirements: 5.2_
  
  - [~] 14.3 Optimize image loading
    - Implement lazy loading for images below the fold
    - Verify images have appropriate width and height attributes
    - Consider using responsive images with srcset for different screen sizes
    - _Requirements: 5.3, 4.8_
  
  - [~] 14.4 Run Lighthouse performance audit
    - Run Lighthouse audit on desktop for all major pages
    - Run Lighthouse audit on mobile for all major pages
    - Verify desktop performance score ≥90
    - Verify mobile performance score ≥80
    - Fix any performance issues identified
    - _Requirements: 5.6, 5.7_

- [ ] 15. Cross-Browser and Responsive Testing
  - [~] 15.1 Test on multiple browsers
    - Test on Chrome/Edge (Chromium)
    - Test on Firefox
    - Test on Safari (if available)
    - Fix any browser-specific issues found
    - _Requirements: 4.1, 4.2, 4.3, 4.4, 4.5, 4.6, 4.7, 4.8_
  
  - [~] 15.2 Test on multiple device sizes
    - Test on mobile devices (320px - 767px width)
    - Test on tablet devices (768px - 1023px width)
    - Test on desktop devices (1024px+ width)
    - Verify responsive layouts work correctly at all breakpoints
    - Fix any responsive layout issues found
    - _Requirements: 4.1, 4.2, 4.3, 4.4, 4.5, 4.6, 4.7, 4.8_

- [ ] 16. Visual Regression Testing
  - [~] 16.1 Create baseline screenshots of all pages
    - Take screenshots of all public pages (home, catalog, motif detail, about, contact)
    - Take screenshots of all auth pages (login)
    - Take screenshots of all admin pages (dashboard, motif management, information, account)
    - Store baseline screenshots for comparison
    - _Requirements: 11.1, 11.2, 11.3, 11.4, 11.5, 11.6, 11.7_

  
  - [~] 16.2 Compare current state to baseline
    - Compare current screenshots to baseline screenshots
    - Identify any unintended visual regressions
    - Fix any visual regressions found
    - Update baseline screenshots if intentional changes were made
    - _Requirements: 11.1, 11.2, 11.3, 11.4, 11.5, 11.6, 11.7_

- [~] 17. Checkpoint - Testing and Refinement Complete
  - Verify all accessibility issues are resolved
  - Verify performance targets are met
  - Verify cross-browser compatibility
  - Verify responsive design works on all devices
  - Verify no visual regressions
  - Ensure all tests pass, ask the user if questions arise.

### Phase 5: Deployment (Week 6)

- [ ] 18. Pre-Deployment Preparation
  - [~] 18.1 Create deployment checklist
    - Document all environment variables needed
    - Document all build commands needed
    - Document all database migrations needed (if any)
    - Document rollback procedure
    - _Requirements: All requirements_
  
  - [~] 18.2 Run final production build
    - Run `npm run build` to create production assets
    - Verify all assets are generated correctly
    - Verify CSS bundle size is optimized
    - Verify JavaScript bundle size is optimized
    - _Requirements: 5.4, 5.5_
  
  - [~] 18.3 Test production build locally
    - Serve production build locally
    - Test all critical user flows
    - Verify no console errors
    - Verify all assets load correctly
    - _Requirements: All requirements_

- [ ] 19. Production Deployment
  - [~] 19.1 Deploy to staging environment (if available)
    - Deploy code to staging environment
    - Run smoke tests on staging
    - Verify all functionality works on staging
    - Get stakeholder approval from staging
    - _Requirements: All requirements_
  
  - [~] 19.2 Deploy to production environment
    - Deploy code to production environment
    - Run database migrations (if any)
    - Clear application cache
    - Verify deployment was successful
    - _Requirements: All requirements_


- [ ] 20. Post-Deployment Verification
  - [~] 20.1 Verify production functionality
    - Test all critical user flows on production
    - Verify public pages load correctly
    - Verify admin panel works correctly
    - Verify authentication works correctly
    - Verify no console errors on production
    - _Requirements: All requirements_
  
  - [~] 20.2 Run production performance audit
    - Run Lighthouse audit on production
    - Verify desktop performance score ≥90
    - Verify mobile performance score ≥80
    - Verify accessibility score ≥90
    - _Requirements: 5.6, 5.7, 1.1, 1.2, 1.3, 1.4, 1.5, 1.6, 1.7, 1.8_
  
  - [~] 20.3 Monitor for issues
    - Monitor application logs for errors
    - Monitor user feedback for issues
    - Monitor performance metrics
    - Address any issues found promptly
    - _Requirements: All requirements_

- [ ] 21. Documentation and Handoff
  - [~] 21.1 Create component documentation
    - Document all UI components with usage examples
    - Document component props and variants
    - Document accessibility features
    - Create visual component library reference
    - _Requirements: 12.1, 12.2, 12.3, 12.4, 12.5, 12.6, 12.7, 12.8, 12.9, 12.10_
  
  - [~] 21.2 Create design system documentation
    - Document color palette with hex codes and usage guidelines
    - Document typography scale with font families and sizes
    - Document spacing scale and usage guidelines
    - Document shadow levels and usage guidelines
    - Document animation system and usage guidelines
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5, 2.6, 13.1, 13.2, 13.3, 13.4, 13.5, 13.6, 13.7, 13.8_
  
  - [~] 21.3 Create maintenance guide
    - Document how to add new components
    - Document how to modify design tokens
    - Document how to test accessibility
    - Document how to optimize performance
    - Document common troubleshooting steps
    - _Requirements: All requirements_

- [~] 22. Final Checkpoint - Deployment Complete
  - Verify production deployment is successful
  - Verify all functionality works on production
  - Verify performance targets are met on production
  - Verify documentation is complete
  - Project complete!


## Notes

- **No Property-Based Testing**: This is a UI/UX refactoring project focused on visual design, accessibility, and user experience. Property-based testing is not applicable as there are no universal correctness properties to test. Testing will focus on visual regression, accessibility audits, cross-browser compatibility, and performance metrics.

- **Incremental Implementation**: Tasks are organized in phases to allow testing and validation at each stage. Complete each phase before moving to the next.

- **Accessibility Priority**: Accessibility testing (Phase 4) is critical and should not be skipped. Use actual screen readers (NVDA, JAWS, VoiceOver) for testing.

- **Performance Validation**: Performance metrics should be measured before and after refactoring to validate improvements. Use Lighthouse for consistent measurements.

- **Cultural Design Validation**: Cultural design elements (colors, patterns, typography) should be validated with stakeholders familiar with Batik Banyuwangi heritage.

- **Component Reusability**: All components are designed to be reusable across public and admin interfaces. Maintain consistency in styling and behavior.

- **Bootstrap Removal**: Ensure complete removal of Bootstrap dependencies. No Bootstrap classes should remain in any view files after migration.

- **Responsive Design**: All pages must work seamlessly on mobile (320px+), tablet (768px+), and desktop (1024px+) devices.

- **Browser Support**: Test on Chrome/Edge (Chromium), Firefox, and Safari (if available) to ensure cross-browser compatibility.

- **Documentation**: Component and design system documentation is essential for future maintenance and development.

## Task Dependency Graph

```json
{
  "waves": [
    {
      "id": 0,
      "tasks": ["1.1", "1.2", "1.3", "1.4"]
    },
    {
      "id": 1,
      "tasks": ["2.1", "2.2"]
    },
    {
      "id": 2,
      "tasks": ["2.3"]
    },
    {
      "id": 3,
      "tasks": ["4.1", "4.2", "4.3"]
    },
    {
      "id": 4,
      "tasks": ["5.1", "5.2", "5.3"]
    },
    {
      "id": 5,
      "tasks": ["6.1", "6.2", "6.3", "6.4"]
    },
    {
      "id": 6,
      "tasks": ["7.1", "7.2", "7.3"]
    },
    {
      "id": 7,
      "tasks": ["9.1"]
    },
    {
      "id": 8,
      "tasks": ["9.2", "9.5", "10.1"]
    },
    {
      "id": 9,
      "tasks": ["9.3", "9.4"]
    },
    {
      "id": 10,
      "tasks": ["11.1"]
    },
    {
      "id": 11,
      "tasks": ["11.2", "11.4"]
    },
    {
      "id": 12,
      "tasks": ["11.3"]
    },
    {
      "id": 13,
      "tasks": ["13.1", "13.2", "13.3", "13.4"]
    },
    {
      "id": 14,
      "tasks": ["14.1", "14.2", "14.3"]
    },
    {
      "id": 15,
      "tasks": ["14.4"]
    },
    {
      "id": 16,
      "tasks": ["15.1", "15.2"]
    },
    {
      "id": 17,
      "tasks": ["16.1"]
    },
    {
      "id": 18,
      "tasks": ["16.2"]
    },
    {
      "id": 19,
      "tasks": ["18.1", "18.2"]
    },
    {
      "id": 20,
      "tasks": ["18.3"]
    },
    {
      "id": 21,
      "tasks": ["19.1"]
    },
    {
      "id": 22,
      "tasks": ["19.2"]
    },
    {
      "id": 23,
      "tasks": ["20.1", "20.2", "20.3"]
    },
    {
      "id": 24,
      "tasks": ["21.1", "21.2", "21.3"]
    }
  ]
}
```
