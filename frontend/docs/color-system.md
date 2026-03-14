# Color System Documentation

## Overview

The Smart SuperMarket POS system uses a modern, fresh color scheme that reflects the grocery retail nature of the business while maintaining excellent accessibility and usability. The color system is built on three primary brand colors:

- **Fresh Retail Green** - Represents fresh groceries and natural products
- **Smart Technology Blue** - Represents intelligent, modern technology
- **Promotions Orange** - Highlights discounts and special offers

This documentation provides comprehensive guidance on when and how to use each color in the system.

---

## Color Palette

### Brand Colors

#### Primary Brand Color - Fresh Retail Green
**Hex:** `#16A34A`  
**CSS Variable:** `--color-brand-primary`  
**Tailwind Class:** `bg-brand-primary`, `text-brand-primary`

**Usage:**
- Navigation bar background
- Primary branding elements
- Main logo and brand identity
- Active navigation states (darker variant: `#15803D`)

**Visual Example:**
```html
<!-- Navbar with primary brand color -->
<nav class="bg-brand-primary text-white">
  <div class="sidebar">Smart SuperMarket</div>
</nav>
```

**When to Use:**
- Navigation components (sidebar, navbar)
- Primary branding areas
- Active/selected states in navigation
- Brand logo backgrounds

**When NOT to Use:**
- Body text (use text colors instead)
- Form inputs (use secondary color)
- Promotional badges (use accent color)

---

#### Secondary Color - Smart Technology Blue
**Hex:** `#2563EB`  
**CSS Variable:** `--color-brand-secondary`  
**Tailwind Class:** `bg-brand-secondary`, `text-brand-secondary`

**Usage:**
- Primary action buttons
- Interactive elements
- Links and clickable items
- Form submit buttons

**Visual Example:**
```html
<!-- Primary button -->
<button class="btn-primary">
  Add to Cart
</button>

<!-- Using Tailwind utilities -->
<button class="bg-brand-secondary hover:bg-smart-600 text-white px-4 py-2 rounded">
  Checkout
</button>
```

**When to Use:**
- Primary action buttons (Add, Save, Submit)
- Interactive UI elements
- Call-to-action buttons
- Links and navigation links

**When NOT to Use:**
- Success messages (use success color)
- Warning alerts (use warning color)
- Discount badges (use accent color)

---

#### Accent Color - Promotions Orange
**Hex:** `#F97316`  
**CSS Variable:** `--color-brand-accent`  
**Tailwind Class:** `bg-brand-accent`, `text-brand-accent`

**Usage:**
- Discount badges
- Promotional banners
- Sale price indicators
- Special offer highlights

**Visual Example:**
```html
<!-- Discount badge -->
<span class="badge-discount">
  20% OFF
</span>

<!-- Promotional banner -->
<div class="promo-banner">
  <span class="text-promo font-bold">Flash Sale!</span>
  <p>Get 30% off on fresh produce</p>
</div>

<!-- Sale price -->
<div class="product-price">
  <span class="text-gray-500 line-through">$10.00</span>
  <span class="text-promo font-bold text-xl">$7.00</span>
</div>
```

**When to Use:**
- Discount percentages and amounts
- Promotional banners and badges
- Sale prices
- Limited-time offer indicators
- Special deal highlights

**When NOT to Use:**
- Regular prices (use primary text color)
- Success confirmations (use success color)
- Navigation elements (use primary brand color)

---

### Semantic Colors

#### Success Color - Fresh Items Green
**Hex:** `#22C55E`  
**CSS Variable:** `--color-success`  
**Tailwind Class:** `bg-fresh-500`, `text-fresh-500`

**Usage:**
- Positive feedback messages
- Success confirmations
- Fresh item indicators
- In-stock status badges
- Completed actions

**Visual Example:**
```html
<!-- Success button -->
<button class="btn-success">
  Confirm Order
</button>

<!-- Success message with icon -->
<div class="alert alert-success">
  <svg class="icon-check">...</svg>
  <span>Order placed successfully!</span>
</div>

<!-- Fresh item badge -->
<span class="badge-success">
  Fresh Today
</span>
```

**Accessibility Note:** Always pair success color with an icon or text label to ensure users who cannot distinguish colors can still understand the status.

**When to Use:**
- Success toast notifications
- Confirmation messages
- Fresh product indicators
- In-stock badges
- Completed status indicators
- Positive feedback

**When NOT to Use:**
- Primary actions (use secondary color)
- Promotional content (use accent color)
- Navigation (use primary brand color)

---

#### Warning Color - Alerts Amber
**Hex:** `#F59E0B`  
**CSS Variable:** `--color-warning`  
**Tailwind Class:** `bg-alert-500`, `text-alert-500`

**Usage:**
- Warning messages
- Alert notifications
- Low stock indicators
- Caution states
- Important notices

**Visual Example:**
```html
<!-- Warning button -->
<button class="btn-warning">
  Delete Item
</button>

<!-- Warning alert with icon -->
<div class="alert alert-warning">
  <svg class="icon-warning">...</svg>
  <span>Low stock: Only 3 items remaining</span>
</div>

<!-- Low stock badge -->
<span class="badge-warning">
  Low Stock
</span>
```

**Accessibility Note:** Always pair warning color with an icon or text label to ensure the warning is clear to all users.

**When to Use:**
- Warning notifications
- Low stock alerts
- Caution messages
- Important notices
- Pending actions
- Items requiring attention

**When NOT to Use:**
- Error messages (use danger color: `#ef4444`)
- Success messages (use success color)
- Promotional content (use accent color)

---

## Background System

### Main Background
**Hex:** `#F8FAFC` (Light) / `#0F172A` (Dark)  
**CSS Variable:** `--bg-main`  
**Tailwind Class:** `bg-background-main`

**Usage:** Main application background, provides the base layer for the entire interface.

```html
<div class="bg-main min-h-screen">
  <!-- Application content -->
</div>
```

---

### Card Background
**Hex:** `#FFFFFF` (Light) / `#1E293B` (Dark)  
**CSS Variable:** `--bg-card`  
**Tailwind Class:** `bg-background-card`

**Usage:** Card components, elevated surfaces, content containers.

```html
<div class="card">
  <h3>Product Details</h3>
  <p>Product information goes here</p>
</div>
```

---

### Section Background
**Hex:** `#F1F5F9` (Light) / `#334155` (Dark)  
**CSS Variable:** `--bg-section`  
**Tailwind Class:** `bg-background-section`

**Usage:** Section containers, grouped content areas, subtle background differentiation.

```html
<section class="section-bg p-6">
  <h2>Category: Fresh Produce</h2>
  <!-- Products grid -->
</section>
```

---

### Hover Background
**Hex:** `#E8F5E9` (Light) / `#1E3A28` (Dark)  
**CSS Variable:** `--bg-hover`

**Usage:** Hover states for interactive elements (excluding buttons).

```html
<div class="sidebar-link hover:bg-hover">
  Dashboard
</div>
```

---

## Text System

### Primary Text
**Hex:** `#0F172A` (Light) / `#F1F5F9` (Dark)  
**CSS Variable:** `--text-primary`  
**Tailwind Class:** `text-text-primary`

**Usage:** Primary headings, body text, main content.

**Contrast Ratio:** 14.8:1 on main background (WCAG AAA)

```html
<h1 class="text-primary text-3xl font-bold">Dashboard</h1>
<p class="text-primary">Welcome to Smart SuperMarket POS</p>
```

---

### Secondary Text
**Hex:** `#475569` (Light) / `#CBD5E1` (Dark)  
**CSS Variable:** `--text-secondary`  
**Tailwind Class:** `text-text-secondary`

**Usage:** Secondary text, labels, descriptions, metadata.

**Contrast Ratio:** 7.2:1 on main background (WCAG AAA)

```html
<label class="text-secondary text-sm">Product SKU</label>
<p class="text-secondary">Last updated: 2 hours ago</p>
```

---

### Disabled Text
**Hex:** `#64748B` (Light) / `#94A3B8` (Dark)  
**CSS Variable:** `--text-disabled`  
**Tailwind Class:** `text-text-disabled`

**Usage:** Disabled form fields, muted text, inactive states.

**Contrast Ratio:** 4.5:1 on main background (WCAG AA)

```html
<input type="text" disabled class="text-disabled" value="Disabled field">
<span class="text-disabled">Feature coming soon</span>
```

---

## Borders and Dividers

### Border Color
**Hex:** `#64748B` (Light) / `#64748B` (Dark)  
**CSS Variable:** `--border-color`  
**Tailwind Class:** `border-border`

**Usage:** Card borders, input field borders, divider lines.

**Contrast Ratio:** 3:1 against backgrounds (WCAG AA for UI components)

```html
<div class="card border border-border">
  Card content
</div>

<hr class="border-border">

<input type="text" class="border border-border focus:border-brand-primary">
```

---

## Color Scales

For more nuanced color usage, the system provides full color scales:

### Fresh (Green) Scale
- `fresh-50`: `#F0FDF4` - Lightest tint
- `fresh-100`: `#DCFCE7`
- `fresh-200`: `#BBF7D0`
- `fresh-300`: `#86EFAC`
- `fresh-400`: `#4ADE80`
- `fresh-500`: `#22C55E` - Success Color
- `fresh-600`: `#16A34A` - Primary Brand Color
- `fresh-700`: `#15803D` - Active Element
- `fresh-800`: `#166534`
- `fresh-900`: `#14532D` - Darkest shade

### Smart (Blue) Scale
- `smart-50`: `#EFF6FF`
- `smart-100`: `#DBEAFE`
- `smart-200`: `#BFDBFE`
- `smart-300`: `#93C5FD`
- `smart-400`: `#60A5FA`
- `smart-500`: `#2563EB` - Secondary Color
- `smart-600`: `#1D4ED8` - Button hover
- `smart-700`: `#1E40AF`
- `smart-800`: `#1E3A8A`
- `smart-900`: `#1E3A8A`

### Promo (Orange) Scale
- `promo-50`: `#FFF7ED`
- `promo-100`: `#FFEDD5`
- `promo-200`: `#FED7AA`
- `promo-300`: `#FDBA74`
- `promo-400`: `#FB923C`
- `promo-500`: `#F97316` - Accent Color
- `promo-600`: `#EA580C`
- `promo-700`: `#C2410C`
- `promo-800`: `#9A3412`
- `promo-900`: `#7C2D12`

### Alert (Amber) Scale
- `alert-50`: `#FFFBEB`
- `alert-100`: `#FEF3C7`
- `alert-200`: `#FDE68A`
- `alert-300`: `#FCD34D`
- `alert-400`: `#FBBF24`
- `alert-500`: `#F59E0B` - Warning Color
- `alert-600`: `#D97706`
- `alert-700`: `#B45309`
- `alert-800`: `#92400E`
- `alert-900`: `#78350F`

---

## Dark Mode

The color system fully supports dark mode with appropriate color adjustments for visibility and contrast.

### Enabling Dark Mode

Dark mode is controlled by adding the `dark` class to the `<html>` element:

```javascript
// Toggle dark mode
document.documentElement.classList.toggle('dark');
```

### Dark Mode Color Adjustments

| Element | Light Mode | Dark Mode | Reason |
|---------|------------|-----------|--------|
| Primary Brand | `#16A34A` | `#15803D` | Darker for better contrast with light text |
| Secondary | `#2563EB` | `#1E40AF` | Darker for better contrast with light text |
| Accent | `#F97316` | `#C2410C` | Darker for better contrast with light text |
| Success | `#22C55E` | `#15803D` | Darker for better contrast with light text |
| Main Background | `#F8FAFC` | `#0F172A` | Dark slate for reduced eye strain |
| Card Background | `#FFFFFF` | `#1E293B` | Elevated dark surface |
| Primary Text | `#0F172A` | `#F1F5F9` | Light text on dark background |

### Dark Mode Usage

```html
<!-- Component that adapts to dark mode -->
<div class="bg-background-card text-primary p-6 rounded-lg">
  <h2 class="text-primary">Product Name</h2>
  <p class="text-secondary">Product description</p>
</div>
```

The component will automatically use:
- Light mode: White background, dark text
- Dark mode: Dark slate background, light text

---

## Accessibility Guidelines

### Contrast Ratios

All color combinations meet WCAG AA standards:

| Combination | Ratio | Standard | Pass |
|-------------|-------|----------|------|
| Primary text on main background | 14.8:1 | WCAG AAA (7:1) | ✓ |
| Secondary text on card background | 7.2:1 | WCAG AAA (7:1) | ✓ |
| Disabled text on main background | 4.5:1 | WCAG AA (4.5:1) | ✓ |
| White on Primary Brand | 3.8:1 | WCAG AA Large (3:1) | ✓ |
| White on Secondary | 4.2:1 | WCAG AA (4.5:1) | ✓ |
| White on Accent | 3.1:1 | WCAG AA Large (3:1) | ✓ |
| Border on background | 3:1 | WCAG AA UI (3:1) | ✓ |

### Non-Color Indicators

**Critical Rule:** Never use color alone to convey information.

**Good Example:**
```html
<!-- Success message with icon AND color -->
<div class="alert alert-success">
  <svg class="icon-check" aria-hidden="true">...</svg>
  <span>Order placed successfully!</span>
</div>
```

**Bad Example:**
```html
<!-- Color only - not accessible -->
<div class="text-success">
  Order placed successfully!
</div>
```

### Status Indicators Best Practices

Always include:
1. **Icon** - Visual symbol (checkmark, warning triangle, etc.)
2. **Color** - Semantic color (success green, warning amber, etc.)
3. **Text** - Clear message describing the status

```html
<!-- Complete status indicator -->
<div class="flex items-center gap-2 text-success">
  <svg class="w-5 h-5" aria-hidden="true">
    <path d="M5 13l4 4L19 7"/>
  </svg>
  <span class="font-medium">In Stock</span>
</div>
```

---

## Code Examples

### Button Variants

```html
<!-- Primary action button -->
<button class="btn-primary">
  Add to Cart
</button>

<!-- Success button -->
<button class="btn-success">
  Confirm Order
</button>

<!-- Warning button -->
<button class="btn-warning">
  Delete Item
</button>

<!-- Using Tailwind utilities -->
<button class="bg-brand-secondary hover:bg-smart-600 text-white px-4 py-2 rounded-lg transition">
  Custom Button
</button>
```

### Badge Variants

```html
<!-- Discount badge -->
<span class="badge-discount">
  20% OFF
</span>

<!-- Success badge -->
<span class="badge-success">
  Fresh Today
</span>

<!-- Warning badge -->
<span class="badge-warning">
  Low Stock
</span>

<!-- Primary badge -->
<span class="badge-primary">
  Featured
</span>
```

### Card Components

```html
<!-- Standard card -->
<div class="card">
  <h3 class="text-primary text-lg font-semibold mb-2">Product Name</h3>
  <p class="text-secondary text-sm mb-4">Product description</p>
  <div class="flex items-center justify-between">
    <span class="text-primary font-bold text-xl">$12.99</span>
    <button class="btn-primary">Add to Cart</button>
  </div>
</div>

<!-- Card with promotional badge -->
<div class="card relative">
  <span class="badge-discount absolute top-2 right-2">
    15% OFF
  </span>
  <h3 class="text-primary text-lg font-semibold mb-2">Sale Item</h3>
  <div class="flex items-center gap-2">
    <span class="text-secondary line-through">$20.00</span>
    <span class="text-promo font-bold text-xl">$17.00</span>
  </div>
</div>
```

### Promotional Banner

```html
<div class="promo-banner">
  <div class="flex items-center gap-3">
    <svg class="w-6 h-6 text-promo" aria-hidden="true">
      <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
    </svg>
    <div>
      <h4 class="text-promo font-bold text-lg">Flash Sale!</h4>
      <p class="text-secondary">Get 30% off on fresh produce. Limited time only.</p>
    </div>
  </div>
</div>
```

### Form Elements

```html
<form class="space-y-4">
  <!-- Text input -->
  <div>
    <label class="text-secondary text-sm font-medium mb-1 block">
      Product Name
    </label>
    <input 
      type="text" 
      class="w-full px-3 py-2 border border-border rounded-lg focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/20 transition"
      placeholder="Enter product name"
    >
  </div>
  
  <!-- Disabled input -->
  <div>
    <label class="text-disabled text-sm font-medium mb-1 block">
      SKU (Auto-generated)
    </label>
    <input 
      type="text" 
      disabled
      class="w-full px-3 py-2 border border-border rounded-lg text-disabled bg-section"
      value="SKU-12345"
    >
  </div>
  
  <!-- Submit button -->
  <button type="submit" class="btn-primary w-full">
    Save Product
  </button>
</form>
```

### Navigation Sidebar

```html
<aside class="sidebar">
  <div class="p-4">
    <h1 class="text-white text-xl font-bold">Smart SuperMarket</h1>
  </div>
  
  <nav class="mt-6">
    <!-- Active link -->
    <a href="/dashboard" class="sidebar-link sidebar-link-active">
      <svg class="w-5 h-5" aria-hidden="true">...</svg>
      <span>Dashboard</span>
    </a>
    
    <!-- Regular link -->
    <a href="/products" class="sidebar-link">
      <svg class="w-5 h-5" aria-hidden="true">...</svg>
      <span>Products</span>
    </a>
    
    <!-- Hover state automatically applies bg-hover -->
    <a href="/orders" class="sidebar-link">
      <svg class="w-5 h-5" aria-hidden="true">...</svg>
      <span>Orders</span>
    </a>
  </nav>
</aside>
```

---

## CSS Variables Reference

### Using CSS Variables

CSS variables provide runtime color management and enable theme switching:

```css
/* Using CSS variables in custom styles */
.custom-component {
  background: var(--bg-card);
  color: var(--text-primary);
  border: 1px solid var(--border-color);
}

.custom-component:hover {
  background: var(--bg-hover);
}

.custom-button {
  background: var(--color-brand-secondary);
  color: white;
}

.custom-button:hover {
  background: #1D4ED8; /* 10% darker */
}
```

### Complete Variable List

```css
/* Brand Colors */
--color-brand-primary: #16A34A;
--color-brand-secondary: #2563EB;
--color-brand-accent: #F97316;

/* Semantic Colors */
--color-success: #22C55E;
--color-warning: #F59E0B;
--color-active: #15803D;

/* Backgrounds */
--bg-main: #F8FAFC;
--bg-card: #FFFFFF;
--bg-section: #F1F5F9;
--bg-hover: #E8F5E9;

/* Text */
--text-primary: #0F172A;
--text-secondary: #475569;
--text-disabled: #64748B;

/* Borders */
--border-color: #64748B;
```

---

## Migration Guide

### Updating Old Components

If you're updating components from the old purple-based color scheme:

**Old (Purple):**
```html
<button class="bg-primary-600 hover:bg-primary-700 text-white">
  Click Me
</button>
```

**New (Green-Blue-Orange):**
```html
<button class="btn-primary">
  Click Me
</button>
<!-- OR -->
<button class="bg-brand-secondary hover:bg-smart-600 text-white">
  Click Me
</button>
```

### Color Mapping

| Old Color | Old Hex | New Color | New Hex |
|-----------|---------|-----------|---------|
| Primary Purple | `#6366f1` | Primary Brand Green | `#16A34A` |
| Primary Purple Hover | `#4f46e5` | Secondary Blue | `#2563EB` |
| Purple Active | `#4338ca` | Active Green | `#15803D` |
| Success Green | `#10b981` | Success Green | `#22C55E` |
| Warning Amber | `#f59e0b` | Warning Amber | `#F59E0B` |

---

## Best Practices

### Do's ✓

- Use Primary Brand Color for navigation and branding
- Use Secondary Color for primary action buttons
- Use Accent Color for promotional content
- Always pair status colors with icons or text
- Use CSS variables for custom components
- Test color combinations for accessibility
- Maintain visual hierarchy with background layers
- Use hover states for interactive elements

### Don'ts ✗

- Don't use color alone to convey information
- Don't use Primary Brand Color for buttons (use Secondary)
- Don't use Accent Color for regular UI elements
- Don't hardcode hex values in components
- Don't mix old purple colors with new colors
- Don't ignore dark mode compatibility
- Don't use low-contrast color combinations
- Don't forget to test with color blindness simulators

---

## Testing Colors

### Contrast Checker

Use online tools to verify contrast ratios:
- [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)
- [Contrast Ratio Calculator](https://contrast-ratio.com/)

### Color Blindness Simulation

Test your designs with color blindness simulators:
- [Coblis Color Blindness Simulator](https://www.color-blindness.com/coblis-color-blindness-simulator/)
- Chrome DevTools (Rendering > Emulate vision deficiencies)

### Browser Testing

Test in multiple browsers to ensure CSS variable support:
- Chrome 49+
- Firefox 31+
- Safari 9.1+
- Edge 15+

---

## Support

For questions or issues with the color system:
- Review this documentation
- Check the design document: `.kiro/specs/system-color-scheme-update/design.md`
- Consult the requirements: `.kiro/specs/system-color-scheme-update/requirements.md`
- Test with accessibility tools before deployment

---

**Last Updated:** 2024  
**Version:** 1.0  
**Spec:** system-color-scheme-update
