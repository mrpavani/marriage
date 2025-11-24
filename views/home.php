<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($settings['couple_names'] ?? 'Wedding') ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet">
</head>

<body>
    <!-- Hero Section -->
    <header class="hero parallax">
        <div class="hero-overlay"></div>
        <div class="hero-content fade-in-up">
            <div class="date-badge"><?= date('d.m.Y', strtotime($settings['wedding_date'] ?? 'now')) ?></div>
            <h1 class="couple-names"
                style="color: <?= htmlspecialchars($settings['couple_names_color'] ?? '#000000') ?>">
                <?= htmlspecialchars($settings['couple_names'] ?? 'Maria & João') ?>
            </h1>
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
                    <p class="info-text"><?= date('d \d\e F \d\e Y', strtotime($settings['wedding_date'] ?? 'now')) ?>
                    </p>
                    <p class="info-subtext">Às <?= date('H:i', strtotime($settings['wedding_date'] ?? 'now')) ?> horas
                    </p>
                </div>
                <div class="info-card">
                    <div class="icon">📍</div>
                    <h3>Onde</h3>
                    <p class="info-text"><?= htmlspecialchars($settings['wedding_address'] ?? '') ?></p>
                    <a href="https://maps.google.com/?q=<?= urlencode($settings['wedding_address'] ?? '') ?>"
                        target="_blank" class="link-underline">Ver no Mapa</a>
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
                <p>Sua presença é o nosso maior presente! Mas se quiser nos presentear, aceitamos mimos via PIX para
                    nossa lua de mel.</p>
                <div class="pix-card">
                    <h3>Chave PIX</h3>
                    <div class="pix-key-container">
                        <code id="pix-key"><?= htmlspecialchars($settings['pix_key'] ?? '') ?></code>
                        <button onclick="copyPix()" class="btn-copy" title="Copiar">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Countdown Section -->
    <section class="section countdown-section" style="background: #f8f9fa; padding: 4rem 0; text-align: center;">
        <div class="container">
            <div class="section-header">
                <span class="overline">Contagem Regressiva</span>
                <h2>Falta Pouco!</h2>
            </div>
            <div id="countdown"
                style="display: flex; justify-content: center; gap: 2rem; font-family: 'Playfair Display', serif;">
                <div class="countdown-item">
                    <span id="days" style="font-size: 3rem; color: #d4af37; font-weight: bold;">00</span>
                    <span style="display: block; font-size: 0.9rem; letter-spacing: 2px;">DIAS</span>
                </div>
                <div class="countdown-item">
                    <span id="hours" style="font-size: 3rem; color: #d4af37; font-weight: bold;">00</span>
                    <span style="display: block; font-size: 0.9rem; letter-spacing: 2px;">HORAS</span>
                </div>
                <div class="countdown-item">
                    <span id="minutes" style="font-size: 3rem; color: #d4af37; font-weight: bold;">00</span>
                    <span style="display: block; font-size: 0.9rem; letter-spacing: 2px;">MINUTOS</span>
                </div>
                <div class="countdown-item">
                    <span id="seconds" style="font-size: 3rem; color: #d4af37; font-weight: bold;">00</span>
                    <span style="display: block; font-size: 0.9rem; letter-spacing: 2px;">SEGUNDOS</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Poll Section -->
    <section class="section poll-section" style="padding: 4rem 0;">
        <div class="container">
            <div class="section-header">
                <span class="overline">Lua de Mel</span>
                <h2>Para onde devemos ir?</h2>
                <p>Ajude-nos a escolher o destino da nossa viagem dos sonhos!</p>
            </div>

            <?php if (isset($_GET['vote_success'])): ?>
                <div class="success-message fade-in"
                    style="text-align: center; color: #155724; background: #d4edda; padding: 1rem; border-radius: 4px; max-width: 600px; margin: 0 auto;">
                    <h3>Voto Registrado!</h3>
                    <p>Obrigado por nos ajudar a escolher.</p>
                </div>
            <?php else: ?>
                <form action="/vote" method="POST" class="poll-form" style="max-width: 600px; margin: 0 auto;">
                    <div class="poll-options" style="display: grid; gap: 1rem;">
                        <?php
                        $poll_options = [
                            1 => $settings['honeymoon_dest_1'] ?? 'Destino Surpresa 1',
                            2 => $settings['honeymoon_dest_2'] ?? 'Destino Surpresa 2',
                            3 => $settings['honeymoon_dest_3'] ?? 'Destino Surpresa 3',
                            4 => 'Lua de mel mais caseira'
                        ];
                        ?>
                        <?php foreach ($poll_options as $key => $label): ?>
                            <label class="poll-option"
                                style="display: block; padding: 1rem; border: 1px solid #ddd; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                <input type="radio" name="option" value="<?= $key ?>" required style="margin-right: 10px;">
                                <span style="font-size: 1.1rem;"><?= htmlspecialchars($label) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="btn-primary btn-block" style="margin-top: 1.5rem;">Votar</button>
                </form>
            <?php endif; ?>
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
                                <input type="tel" name="phone" id="phone" placeholder="(99) 99999-9999" maxlength="15">
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
        <p style="margin-top: 10px; font-size: 0.8rem;"><a href="/admin/login"
                style="color: #555; text-decoration: none;">Área Administrativa</a></p>
    </footer>

    <script>
        // Countdown Timer
        const weddingDate = new Date("<?= $settings['wedding_date'] ?? 'now' ?>").getTime();

        const x = setInterval(function () {
            const now = new Date().getTime();
            const distance = weddingDate - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("days").innerText = String(days).padStart(2, '0');
            document.getElementById("hours").innerText = String(hours).padStart(2, '0');
            document.getElementById("minutes").innerText = String(minutes).padStart(2, '0');
            document.getElementById("seconds").innerText = String(seconds).padStart(2, '0');

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "<h3>O grande dia chegou!</h3>";
            }
        }, 1000);

        // Phone Mask
        const phoneInput = document.getElementById('phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function (e) {
                let x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
                e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
            });
        }

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