<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($settings['couple_names'] ?? 'Wedding') ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Hero Section -->
    <header class="hero parallax">
        <div class="hero-overlay"></div>
        <div class="hero-content fade-in-up">
            <div class="date-badge"><?= date('d.m.Y', strtotime($settings['wedding_date'] ?? 'now')) ?></div>
            <h1 class="couple-names"><?= htmlspecialchars($settings['couple_names'] ?? 'Maria & João') ?></h1>
            <p class="subtitle">Vamos celebrar o amor</p>
            <a href="#rsvp" class="btn-outline">Confirme sua Presença</a>
        </div>
    </header>

    <!-- Info Section -->
    <section class="section info-section">
        <div class="container">
            <div class="section-header">
                <span class="overline">O Grande Dia</span>
                <h2>Detalhes da Cerimônia</h2>
            </div>
            <div class="info-grid">
                <div class="info-card">
                    <div class="icon">📅</div>
                    <h3>Quando</h3>
                    <p class="info-text"><?= date('d \d\e F \d\e Y', strtotime($settings['wedding_date'] ?? 'now')) ?></p>
                    <p class="info-subtext">Às <?= date('H:i', strtotime($settings['wedding_date'] ?? 'now')) ?> horas</p>
                </div>
                <div class="info-card">
                    <div class="icon">📍</div>
                    <h3>Onde</h3>
                    <p class="info-text"><?= htmlspecialchars($settings['wedding_address'] ?? '') ?></p>
                    <a href="https://maps.google.com/?q=<?= urlencode($settings['wedding_address'] ?? '') ?>" target="_blank" class="link-underline">Ver no Mapa</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Parallax Divider 1 -->
    <div class="parallax-divider" style="background-image: url('/assets/img/divider1.png');"></div>

    <!-- Gallery Section -->
    <?php if (!empty($photos)): ?>
    <section class="section gallery-section">
        <div class="container">
            <div class="section-header">
                <span class="overline">Momentos</span>
                <h2>Nossa História</h2>
            </div>
            <div class="gallery-masonry">
                <?php foreach ($photos as $photo): ?>
                    <div class="gallery-item">
                        <img src="/uploads/<?= htmlspecialchars($photo['filename']) ?>" alt="Photo" loading="lazy">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Parallax Divider 2 -->
    <div class="parallax-divider" style="background-image: url('/assets/img/divider2.png');"></div>

    <!-- Gift Section -->
    <section class="section gifts-section">
        <div class="container">
            <div class="section-header">
                <span class="overline">Presentes</span>
                <h2>Lista de Casamento</h2>
            </div>
            <div class="gift-content">
                <p>Sua presença é o nosso maior presente! Mas se quiser nos presentear, aceitamos mimos via PIX para nossa lua de mel.</p>
                <div class="pix-card">
                    <h3>Chave PIX</h3>
                    <div class="pix-key-container">
                        <code id="pix-key"><?= htmlspecialchars($settings['pix_key'] ?? '') ?></code>
                        <button onclick="copyPix()" class="btn-copy" title="Copiar">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- RSVP Section -->
    <section id="rsvp" class="section rsvp-section">
        <div class="container">
            <div class="rsvp-box">
                <div class="section-header">
                    <span class="overline">RSVP</span>
                    <h2>Confirme sua Presença</h2>
                </div>
                
                <?php if (isset($_GET['rsvp_success'])): ?>
                    <div class="success-message fade-in">
                        <h3>Obrigado!</h3>
                        <p>Sua presença foi confirmada com sucesso.</p>
                    </div>
                <?php else: ?>
                    <form action="/rsvp" method="POST" class="rsvp-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nome Completo</label>
                                <input type="text" name="name" required placeholder="Seu nome">
                            </div>
                            <div class="form-group">
                                <label>Telefone (WhatsApp)</label>
                                <input type="tel" name="phone" placeholder="(00) 00000-0000">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Total de Pessoas</label>
                            <select name="guests" required>
                                <option value="1">1 Pessoa</option>
                                <option value="2">2 Pessoas</option>
                                <option value="3">3 Pessoas</option>
                                <option value="4">4 Pessoas</option>
                                <option value="5">5 Pessoas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mensagem para os Noivos</label>
                            <textarea name="message" rows="3" placeholder="Deixe uma mensagem carinhosa..."></textarea>
                        </div>
                        <button type="submit" class="btn-primary btn-block">Confirmar Presença</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <footer>
        <p>Feito com ❤️ para <?= htmlspecialchars($settings['couple_names'] ?? 'os noivos') ?></p>
    </footer>

    <script>
        function copyPix() {
            const key = document.getElementById('pix-key').innerText;
            navigator.clipboard.writeText(key).then(() => {
                const btn = document.querySelector('.btn-copy');
                btn.innerHTML = '✓';
                setTimeout(() => {
                    btn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>';
                }, 2000);
            });
        }

        // Intersection Observer for fade-in animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.section-header, .info-card, .gallery-item').forEach(el => {
            el.classList.add('fade-in-up');
            observer.observe(el);
        });
    </script>
</body>
</html>
