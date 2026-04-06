<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Miracale Design — Handmade Art from Virginia</title>
    <meta name="description" content="Unique handmade art and crafts from Virginia. Clay animals, watercolors, wood art, and custom keychains — all crafted with love by Miracale Design." />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Nunito:wght@300;400;500;600&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
</head>
<body>

    <?php include 'includes/nav.php'; ?>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <div class="hero-blob hero-blob-3"></div>

        <div class="hero-text">
            <div class="hero-eyebrow">Handmade in Virginia</div>
            <h1 class="hero-title">
                Art made with
                <em>genuine</em>
                <span class="script-word">love &amp; craft</span>
            </h1>
            <p class="hero-subtitle">
                Every piece from Miracale Design is handcrafted with care — from
                delicate clay animals to vibrant watercolors and textured wood art.
                One-of-a-kind treasures, made just for you.
            </p>
            <div class="hero-ctas">
                <a href="shop.php" class="btn-primary">
                    Browse the Shop
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg>
                </a>
                <a href="about.php" class="btn-ghost">
                    Our Story
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 6h8M7 3l3 3-3 3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" /></svg>
                </a>
            </div>
        </div>

        <div class="hero-collage">
            <div class="collage-card card-1">
                <div class="card-placeholder">
                    <div class="icon">🎨</div>
                    <div class="label">Watercolors</div>
                </div>
            </div>
            <div class="collage-card card-2">
                <div class="card-placeholder">
                    <div class="icon">🐾</div>
                    <div class="label">Clay Animals</div>
                </div>
            </div>
            <div class="collage-card card-3">
                <div class="card-placeholder">
                    <div class="icon">🪵</div>
                    <div class="label">Wood Art</div>
                </div>
            </div>
            <div class="collage-card card-4">
                <div class="card-placeholder">
                    <div class="icon">🗝️</div>
                    <div class="label">Keychains</div>
                </div>
            </div>

            <div class="hero-badge">
                <div style="font-size:1.6rem">⭐</div>
                <div class="badge-text">
                    <strong>5-Star Reviews</strong>
                    Loved by collectors in VA &amp; beyond
                </div>
            </div>
        </div>

        <div class="scroll-hint">
            Explore
            <div class="scroll-arrow"></div>
        </div>
    </section>

    <!-- MARQUEE -->
    <div class="marquee-strip">
        <div class="marquee-track">
            <span class="marquee-item"><span class="marquee-dot">✦</span> Handcrafted in Virginia</span>
            <span class="marquee-item"><span class="marquee-dot">✦</span> Watercolor Paintings</span>
            <span class="marquee-item"><span class="marquee-dot">✦</span> Clay Sculptures</span>
            <span class="marquee-item"><span class="marquee-dot">✦</span> Wood Art</span>
            <span class="marquee-item"><span class="marquee-dot">✦</span> Custom Keychains</span>
            <span class="marquee-item"><span class="marquee-dot">✦</span> One-of-a-Kind Pieces</span>
            <span class="marquee-item"><span class="marquee-dot">✦</span> Made with Love</span>
            <span class="marquee-item"><span class="marquee-dot">✦</span> Handcrafted in Virginia</span>
            <span class="marquee-item"><span class="marquee-dot">✦</span> Watercolor Paintings</span>
            <span class="marquee-item"><span class="marquee-dot">✦</span> Clay Sculptures</span>
            <span class="marquee-item"><span class="marquee-dot">✦</span> Wood Art</span>
            <span class="marquee-item"><span class="marquee-dot">✦</span> Custom Keychains</span>
            <span class="marquee-item"><span class="marquee-dot">✦</span> One-of-a-Kind Pieces</span>
            <span class="marquee-item"><span class="marquee-dot">✦</span> Made with Love</span>
        </div>
    </div>

    <!-- GALLERY -->
    <section class="gallery-section reveal">
        <div class="section-header">
            <div>
                <div class="section-eyebrow">The Collection</div>
                <h2 class="section-title">Artistry in every<br><em>detail</em></h2>
            </div>
            <a href="shop.php" class="section-link">View Full Shop →</a>
        </div>

        <div class="gallery-grid">

            <!--
                HOW IMAGES WORK HERE:
                Replace the <img src="..."> path to point at any file in assets/ folder.
                Pattern: src="assets/YOUR-FILENAME.png"
                The object-fit:cover CSS will crop/fill the container automatically.
                alt="..." should describe the image for accessibility.
            -->
            <!-- Clay Animals → assets/clay-figures.png -->
            <div class="gallery-item">
                <img src="assets/clay-figures.png"
                     alt="Handmade clay animal figures"
                     style="width:100%; height:100%; object-fit:cover; display:block;" />
                <div class="gallery-overlay">
                    <div class="gallery-overlay-text">
                        <h3>Clay Animals</h3>
                        <p>Sculpted by hand</p>
                    </div>
                </div>
            </div>

            <!-- Watercolors → assets/watercolors.png -->
            <div class="gallery-item">
                <img src="assets/watercolors.png"
                     alt="Original watercolor paintings"
                     style="width:100%; height:100%; object-fit:cover; display:block;" />
                <div class="gallery-overlay">
                    <div class="gallery-overlay-text">
                        <h3>Watercolor Art</h3>
                        <p>Original paintings</p>
                    </div>
                </div>
            </div>

            <!-- Keychains → assets/keychains.png -->
            <div class="gallery-item">
                <img src="assets/keychains.png"
                     alt="Handmade custom keychains"
                     style="width:100%; height:100%; object-fit:cover; display:block;" />
                <div class="gallery-overlay">
                    <div class="gallery-overlay-text">
                        <h3>Custom Keychains</h3>
                        <p>Carry art with you</p>
                    </div>
                </div>
            </div>

            <!-- Wood Art → assets/wood-coasters.png -->
            <div class="gallery-item">
                <img src="assets/wood-coasters.png"
                     alt="Handcrafted wood art and coasters"
                     style="width:100%; height:100%; object-fit:cover; display:block;" />
                <div class="gallery-overlay">
                    <div class="gallery-overlay-text">
                        <h3>Wood Art</h3>
                        <p>Textured &amp; natural</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- SPOTLIGHT -->
    <section class="spotlight reveal">
        <div class="spotlight-text">
            <div class="spotlight-tag">Why Miracale Design?</div>
            <h2 class="spotlight-title">
                Each piece tells<br>a <em>story</em>
            </h2>
            <p class="spotlight-body">
                Miracale Design was born from a passion for creating something truly
                personal. Every sculpture, painting, and carved piece is made by hand
                in Virginia — no mass production, no shortcuts. Just time, care, and
                a whole lot of heart poured into every single creation.
            </p>
            <a href="about.php" class="spotlight-link">
                Read our story
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg>
            </a>
        </div>

        <div class="spotlight-visual">
            <div class="spotlight-card">
                <img src="assets/bb8-coaster.png"
                     alt="Handcrafted wood art and coasters"
                     style="width:100%; height:100%; object-fit:cover; display:block;" />
            </div>
            <div class="spotlight-card">
                <img src="assets/howls-moving-castle.png"
                     alt="Handcrafted wood art and coasters"
                     style="width:100%; height:100%; object-fit:cover; display:block;" />
            </div>
            <div class="spotlight-card">
                <img src="assets/raccoon.png"
                     alt="Handcrafted wood art and coasters"
                     style="width:100%; height:100%; object-fit:cover; display:block;" />
            </div>
            <div class="spotlight-card">
                <img src="assets/clay-earrings.png"
                     alt="Handcrafted wood art and coasters"
                     style="width:100%; height:100%; object-fit:cover; display:block;" />
            </div>
        </div>
    </section>

    <!-- TESTIMONIAL -->
    <section class="testimonial-section reveal">
        <div class="testimonial-content">
            <p class="testimonial-quote">
                "Miracale Design's handmade art is simply stunning! Each piece reflects true craftsmanship and creativity. I love supporting this small business from Virginia."
            </p>
            <div class="testimonial-author">
                <div class="author-avatar">🌸</div>
                <div class="author-info">
                    <div class="author-name">Emily R.</div>
                    <div class="author-stars">★★★★★</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT STRIP -->
    <div class="contact-strip reveal">
        <div>
            <h2 class="contact-title">Ready to find your<br><em>perfect piece?</em></h2>
            <p class="contact-subtitle">Reach out — commissions &amp; custom orders welcome.</p>
        </div>
        <div class="contact-actions">
            <div class="contact-detail">
                <span>📧</span>
                <span>miracaledesign2021@gmail.com</span>
            </div>
            <div class="contact-detail">
                <span>📞</span>
                <span>540-241-0764</span>
            </div>
            <a href="contact.php" class="btn-primary" style="justify-content:center; margin-top:0.4rem;">
                Send a Message
            </a>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>