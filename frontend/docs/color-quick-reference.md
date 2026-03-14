# Color System Quick Reference

A quick reference guide for developers working with the Smart SuperMarket color system.

---

## Quick Color Lookup

### Brand Colors

| Color | Hex | CSS Variable | Tailwind | Usage |
|-------|-----|--------------|----------|-------|
| **Primary Brand** | `#16A34A` | `--color-brand-primary` | `bg-brand-primary` | Navbar, branding |
| **Secondary** | `#2563EB` | `--color-brand-secondary` | `bg-brand-secondary` | Buttons, interactive |
| **Accent** | `#F97316` | `--color-brand-accent` | `bg-brand-accent` | Discounts, promos |
| **Success** | `#22C55E` | `--color-success` | `bg-fresh-500` | Positive feedback |
| **Warning** | `#F59E0B` | `--color-warning` | `bg-alert-500` | Alerts, warnings |
| **Active** | `#15803D` | `--color-active` | `bg-fresh-700` | Active states |

### Background Colors

| Color | Light Mode | Dark Mode | CSS Variable | Usage |
|-------|------------|-----------|--------------|-------|
| **Main** | `#F8FAFC` | `#0F172A` | `--bg-main` | App background |
| **Card** | `#FFFFFF` | `#1E293B` | `--bg-card` | Cards, containers |
| **Section** | `#F1F5F9` | `#334155` | `--bg-section` | Section backgrounds |
| **Hover** | `#E8F5E9` | `#1E3A28` | `--bg-hover` | Hover states |

### Text Colors

| Color | Light Mode | Dark Mode | CSS Variable | Usage |
|-------|------------|-----------|--------------|-------|
| **Primary** | `#0F172A` | `#F1F5F9` | `--text-primary` | Headings, body text |
| **Secondary** | `#475569` | `#CBD5E1` | `--text-secondary` | Labels, descriptions |
| **Disabled** | `#64748B` | `#94A3B8` | `--text-disabled` | Disabled states |

### Border Color

| Color | Light Mode | Dark Mode | CSS Variable | Usage |
|-------|------------|-----------|--------------|-------|
| **Border** | `#64748B` | `#64748B` | `--border-color` | Borders, dividers |

---

## Common Patterns

### Buttons

```html
<!-- Primary action -->
<button class="btn-primary">Action</button>

<!-- Success action -->
<button class="btn-success">Confirm</button>

<!-- Warning action -->
<button class="btn-warning">Delete</button>
```

### Badges

```html
<!-- Discount -->
<span class="badge-discount">20% OFF</span>

<!-- Success -->
<span class="badge-success">Fresh</span>

<!-- Warning -->
<span class="badge-warning">Low Stock</span>

<!-- Primary -->
<span class="badge-primary">Featured</span>
```

### Cards

```html
<div class="card">
  <h3 class="text-primary">Title</h3>
  <p class="text-secondary">Description</p>
</div>
```

### Forms

```html
<label class="text-secondary">Label</label>
<input class="border border-border focus:border-brand-primary">
```

### Status Indicators (with icons)

```html
<!-- Success -->
<div class="flex items-center gap-2 text-success">
  <svg class="w-5 h-5">...</svg>
  <span>Success message</span>
</div>

<!-- Warning -->
<div class="flex items-center gap-2 text-warning">
  <svg class="w-5 h-5">...</svg>
  <span>Warning message</span>
</div>
```

---

## Color Scale Reference

### Fresh (Green)

```
50  → #F0FDF4  (Lightest)
100 → #DCFCE7
200 → #BBF7D0
300 → #86EFAC
400 → #4ADE80
500 → #22C55E  ← Success Color
600 → #16A34A  ← Primary Brand
700 → #15803D  ← Active Element
800 → #166534
900 → #14532D  (Darkest)
```

### Smart (Blue)

```
50  → #EFF6FF  (Lightest)
100 → #DBEAFE
200 → #BFDBFE
300 → #93C5FD
400 → #60A5FA
500 → #2563EB  ← Secondary Color
600 → #1D4ED8  ← Button Hover
700 → #1E40AF
800 → #1E3A8A
900 → #1E3A8A  (Darkest)
```

### Promo (Orange)

```
50  → #FFF7ED  (Lightest)
100 → #FFEDD5
200 → #FED7AA
300 → #FDBA74
400 → #FB923C
500 → #F97316  ← Accent Color
600 → #EA580C
700 → #C2410C
800 → #9A3412
900 → #7C2D12  (Darkest)
```

### Alert (Amber)

```
50  → #FFFBEB  (Lightest)
100 → #FEF3C7
200 → #FDE68A
300 → #FCD34D
400 → #FBBF24
500 → #F59E0B  ← Warning Color
600 → #D97706
700 → #B45309
800 → #92400E
900 → #78350F  (Darkest)
```

---

## Dark Mode Adjustments

| Element | Light | Dark | Change |
|---------|-------|------|--------|
| Primary Brand | `#16A34A` | `#15803D` | Darker |
| Secondary | `#2563EB` | `#1E40AF` | Darker |
| Accent | `#F97316` | `#C2410C` | Darker |
| Success | `#22C55E` | `#15803D` | Darker |
| Warning | `#F59E0B` | `#B45309` | Darker |

**Why darker in dark mode?** To maintain proper contrast with light text on dark backgrounds.

---

## Accessibility Checklist

- [ ] Text contrast ratio ≥ 4.5:1 for normal text
- [ ] Text contrast ratio ≥ 3:1 for large text
- [ ] UI component contrast ratio ≥ 3:1
- [ ] Status indicators include icons or text (not color alone)
- [ ] Tested with color blindness simulator
- [ ] Tested in both light and dark modes
- [ ] Keyboard focus states are visible

---

## Common Mistakes to Avoid

❌ **Don't:**
```html
<!-- Using primary brand color for buttons -->
<button class="bg-brand-primary">Click</button>

<!-- Color-only status indicator -->
<span class="text-success">Success</span>

<!-- Hardcoded hex values -->
<div style="background: #16A34A">Content</div>
```

✅ **Do:**
```html
<!-- Using secondary color for buttons -->
<button class="btn-primary">Click</button>

<!-- Status with icon -->
<div class="flex items-center gap-2 text-success">
  <svg>...</svg>
  <span>Success</span>
</div>

<!-- Using CSS variables -->
<div style="background: var(--color-brand-primary)">Content</div>
```

---

## When to Use Each Color

### Primary Brand Green (`#16A34A`)
✓ Navigation bar  
✓ Sidebar  
✓ Logo backgrounds  
✓ Active navigation items  
✗ Buttons (use Secondary)  
✗ Promotional badges (use Accent)

### Secondary Blue (`#2563EB`)
✓ Primary action buttons  
✓ Links  
✓ Interactive elements  
✓ Call-to-action buttons  
✗ Navigation (use Primary Brand)  
✗ Success messages (use Success)

### Accent Orange (`#F97316`)
✓ Discount badges  
✓ Sale prices  
✓ Promotional banners  
✓ Special offers  
✗ Regular buttons (use Secondary)  
✗ Navigation (use Primary Brand)

### Success Green (`#22C55E`)
✓ Success messages  
✓ Confirmation toasts  
✓ Fresh item badges  
✓ In-stock indicators  
✗ Primary actions (use Secondary)  
✗ Navigation (use Primary Brand)

### Warning Amber (`#F59E0B`)
✓ Warning messages  
✓ Low stock alerts  
✓ Caution notices  
✓ Delete confirmations  
✗ Error messages (use Danger)  
✗ Success messages (use Success)

---

## CSS Variable Usage

```css
/* Custom component with theme support */
.my-component {
  background: var(--bg-card);
  color: var(--text-primary);
  border: 1px solid var(--border-color);
}

.my-component:hover {
  background: var(--bg-hover);
}

.my-button {
  background: var(--color-brand-secondary);
  color: white;
}

.my-badge {
  background: var(--color-brand-accent);
  color: white;
}
```

---

## Tailwind Utility Classes

```html
<!-- Brand colors -->
<div class="bg-brand-primary text-white">Primary Brand</div>
<div class="bg-brand-secondary text-white">Secondary</div>
<div class="bg-brand-accent text-white">Accent</div>

<!-- Color scales -->
<div class="bg-fresh-500 text-white">Success</div>
<div class="bg-smart-600 text-white">Button Hover</div>
<div class="bg-promo-500 text-white">Promotion</div>
<div class="bg-alert-500 text-white">Warning</div>

<!-- Backgrounds -->
<div class="bg-background-main">Main Background</div>
<div class="bg-background-card">Card Background</div>
<div class="bg-background-section">Section Background</div>

<!-- Text -->
<p class="text-text-primary">Primary Text</p>
<p class="text-text-secondary">Secondary Text</p>
<p class="text-text-disabled">Disabled Text</p>

<!-- Borders -->
<div class="border border-border">Bordered Element</div>
```

---

## Testing Tools

### Contrast Checkers
- [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)
- [Contrast Ratio](https://contrast-ratio.com/)

### Color Blindness Simulators
- [Coblis](https://www.color-blindness.com/coblis-color-blindness-simulator/)
- Chrome DevTools → Rendering → Emulate vision deficiencies

### Browser DevTools
- Chrome: F12 → Elements → Styles
- Firefox: F12 → Inspector → Rules
- Safari: Develop → Show Web Inspector

---

## Need More Details?

See the full documentation: `frontend/docs/color-system.md`

---

**Quick Tip:** When in doubt, use component classes (`.btn-primary`, `.card`, `.badge-success`) instead of raw Tailwind utilities. They're pre-configured with the correct colors and accessibility features.
