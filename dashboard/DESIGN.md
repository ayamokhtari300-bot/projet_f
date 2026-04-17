# Design System Specification: The Ethereal Professional

## 1. Overview & Creative North Star
**Creative North Star: "The Digital Curator"**
This design system moves beyond the utility of a standard SaaS dashboard and into the realm of a high-end editorial experience. It is designed to feel like a premium physical workspace—spacious, quiet, and meticulously organized. 

By rejecting the "boxed-in" nature of traditional software, we utilize **intentional asymmetry** and **tonal layering** to create a sense of breath. The layout should never feel "crowded." Instead of filling every pixel, we treat white space as a premium material, using it to guide the eye toward high-value data insights.

---

## 2. Colors & Surface Philosophy
The palette is rooted in a sophisticated "Cool Slate" foundation, punctuated by vibrant, gemstone-inspired accents.

### Color Tokens (Material Convention)
*   **Surface Foundation:** `surface` (#f7f9fb), `surface_container_lowest` (#ffffff).
*   **Brand Accents:** `primary` (#4648d4 / Indigo), `secondary` (#006c49 / Emerald), `tertiary` (#b90538 / Rose).
*   **Typography:** `on_surface` (#191c1e), `on_surface_variant` (#464554).

### The "No-Line" Rule
**Explicit Instruction:** Designers are prohibited from using 1px solid borders for sectioning or containment. 
Boundaries must be defined through background color shifts. A `surface_container_low` section sitting on a `surface` background provides all the definition required. This creates a "seamless" interface that feels modern and expansive.

### Surface Hierarchy & Nesting
Treat the UI as a series of physical layers—like stacked sheets of frosted glass:
1.  **Level 0 (Canvas):** `surface` (#f7f9fb) – The base layer.
2.  **Level 1 (Sections):** `surface_container_low` (#f2f4f6) – Large structural areas.
3.  **Level 2 (Active Cards):** `surface_container_lowest` (#ffffff) – The primary focus area.
4.  **Level 3 (Popovers):** `surface_bright` (#f7f9fb) with high diffusion shadows.

### The "Glass & Gradient" Rule
To elevate CTAs, use **Signature Textures**. Instead of flat Indigo, use a linear gradient from `primary` (#4648d4) to `primary_container` (#6063ee) at a 135-degree angle. For floating decorative elements, apply a 20px `backdrop-blur` to semi-transparent surface colors to create a "frosted glass" depth that integrates with the background.

---

## 3. Typography
We utilize **Inter** for its mathematical precision and neutral elegance.

*   **Display (lg/md):** Used for "Hero" data points. Set with a tight tracking (-0.02em) to feel authoritative and editorial.
*   **Headline (sm/md):** Used for page titles. These should have ample top-margin to establish a clear hierarchy.
*   **Body (lg/md):** The workhorse. Always use `on_surface_variant` for body text to reduce visual vibration against the pure white cards.
*   **Label (sm):** All-caps with increased letter-spacing (+0.05em) for secondary metadata.

The hierarchy is designed to be "Top-Heavy." Large, bold headlines paired with generous white space create the "Apple-like" premium feel, signaling that the information presented is curated and important.

---

## 4. Elevation & Depth
Depth is achieved through **Tonal Layering** rather than traditional structural lines.

*   **The Layering Principle:** Place a `surface_container_lowest` card on a `surface_container_low` section to create a soft, natural lift. No shadow is required for static cards.
*   **Ambient Shadows:** For floating elements (Modals/Dropdowns), use an extra-diffused shadow: `0px 20px 40px rgba(25, 28, 30, 0.06)`. The shadow must feel like an ambient glow, not a dark smudge.
*   **The "Ghost Border" Fallback:** If a container requires further definition (e.g., in a complex data table), use a "Ghost Border": `outline_variant` (#c7c4d7) at **15% opacity**. 
*   **Roundedness Scale:** 
    *   **Cards/Containers:** `lg` (2rem) or `md` (1.5rem) to maintain a soft, approachable aesthetic.
    *   **Buttons/Pills:** `full` (9999px) for a sleek, modern touch.

---

## 5. Components

### Buttons
*   **Primary:** Indigo gradient (`primary` to `primary_container`), white text, `full` radius.
*   **Secondary:** `surface_container_high` background with `on_surface` text. No border.
*   **Tertiary:** Transparent background, `primary` text. Use for low-emphasis actions.

### Status Badges (Pill Style)
*   **Success:** `secondary_fixed` (#6ffbbe) background at 40% opacity with `on_secondary_container` (#00714d) text. 
*   **Error:** `tertiary_fixed` (#ffdadb) background at 40% opacity with `on_tertiary_fixed_variant` (#92002a) text.

### Minimalist Tables & Lists
*   **Rule:** Forbid divider lines. 
*   **Structure:** Use vertical white space (32px between rows) to separate content.
*   **Hover Effect:** On hover, the row background should shift to `surface_container_low` and the border-radius should be `sm` (0.5rem) to "hug" the data.

### Input Fields
*   **Style:** Minimalist. No bottom line or full box. Use a `surface_container_lowest` background with a `Ghost Border` (15% opacity).
*   **Focus State:** The Ghost Border transitions to 100% opacity `primary` color with a 4px soft glow.

---

## 6. Do's and Don'ts

### Do:
*   **Do** use asymmetrical layouts (e.g., a wide 2/3 column next to a narrow 1/3 column) to create visual interest.
*   **Do** use "Micro-Transitions." Elements should subtly slide up 4px when appearing to mimic physical placement.
*   **Do** prioritize legibility. Ensure `on_surface_variant` is used for long-form text to keep the interface "soft."

### Don't:
*   **Don't** use 100% black (#000000). It is too harsh for this system. Use `on_surface` (#191c1e).
*   **Don't** use standard 4px or 8px border radii. They feel "legacy." Stick to the `md` (1.5rem) and `lg` (2rem) scale.
*   **Don't** crowd the edges. Components should have at least 24px of internal padding (inset) to maintain the spacious, premium feel.