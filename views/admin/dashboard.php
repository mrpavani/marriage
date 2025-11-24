<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #d4af37;
            --primary-dark: #b39020;
            --bg: #f8f9fa;
            --text: #333;
            --border: #e9ecef;
        }

        * {
            box-sizing: border-sizing;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            margin: 0;
            padding: 0;
        }

        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .admin-header h1 {
            margin: 0;
            font-size: 1.5rem;
            color: var(--primary);
        }

        .btn {
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-logout {
            color: #dc3545;
            background: #fff;
            border: 1px solid #dc3545;
        }

        .btn-logout:hover {
            background: #dc3545;
            color: white;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            cursor: pointer;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--border);
            padding-bottom: 1px;
        }

        .tab {
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            color: #6c757d;
            font-weight: 500;
        }

        .tab:hover {
            color: var(--primary);
        }

        .tab.active {
            border-bottom-color: var(--primary);
            color: var(--primary);
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .card h3 {
            margin-top: 0;
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
            border-bottom: 1px solid var(--border);
            padding-bottom: 1rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: #495057;
        }

        input[type="text"],
        input[type="datetime-local"],
        input[type="color"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-family: inherit;
            transition: border-color 0.2s;
        }

        input[type="text"]:focus {
            border-color: var(--primary);
            outline: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        th {
            font-weight: 600;
            color: #495057;
            background: #f8f9fa;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .photo-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .photo-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .delete-btn:hover {
            background: #dc3545;
            transform: scale(1.1);
        }

        .poll-results {
            margin-top: 2rem;
        }

        .poll-bar {
            background: #e9ecef;
            height: 24px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 0.5rem;
            position: relative;
        }

        .poll-fill {
            background: var(--primary);
            height: 100%;
            display: flex;
            align-items: center;
            padding-left: 10px;
            color: white;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .poll-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Painel Administrativo</h1>
            <a href="/admin/logout" class="btn btn-logout">Sair</a>
        </div>

        <?php if (isset($success)): ?>
            <div
                style="background: #d1e7dd; color: #0f5132; padding: 1rem; margin-bottom: 1.5rem; border-radius: 8px; border: 1px solid #badbcc;">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <div class="tabs">
            <div class="tab active" onclick="switchTab('settings')">Configurações</div>
            <div class="tab" onclick="switchTab('gallery')">Galeria</div>
            <div class="tab" onclick="switchTab('rsvps')">Confirmados</div>
            <div class="tab" onclick="switchTab('poll')">Enquete</div>
        </div>

        <!-- Settings Tab -->
        <div id="settings" class="tab-content active">
            <div class="card">
                <h3>Geral</h3>
                <form method="POST">
                    <input type="hidden" name="update_settings" value="1">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nome dos Noivos</label>
                            <input type="text" name="couple_names"
                                value="<?= htmlspecialchars($settings['couple_names'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Cor do Nome</label>
                            <input type="color" name="couple_names_color"
                                value="<?= htmlspecialchars($settings['couple_names_color'] ?? '#000000') ?>"
                                style="height: 48px; padding: 4px;">
                        </div>
                        <div class="form-group">
                            <label>Data do Casamento</label>
                            <input type="text" name="wedding_date"
                                value="<?= htmlspecialchars($settings['wedding_date'] ?? '') ?>"
                                placeholder="YYYY-MM-DD HH:MM:SS">
                        </div>
                        <div class="form-group">
                            <label>Endereço</label>
                            <input type="text" name="wedding_address"
                                value="<?= htmlspecialchars($settings['wedding_address'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Chave PIX</label>
                            <input type="text" name="pix_key"
                                value="<?= htmlspecialchars($settings['pix_key'] ?? '') ?>">
                        </div>
                    </div>

                    <h3>Destinos Lua de Mel</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Opção 1</label>
                            <input type="text" name="honeymoon_dest_1"
                                value="<?= htmlspecialchars($settings['honeymoon_dest_1'] ?? '') ?>"
                                placeholder="Ex: Paris">
                        </div>
                        <div class="form-group">
                            <label>Opção 2</label>
                            <input type="text" name="honeymoon_dest_2"
                                value="<?= htmlspecialchars($settings['honeymoon_dest_2'] ?? '') ?>"
                                placeholder="Ex: Maldivas">
                        </div>
                        <div class="form-group">
                            <label>Opção 3</label>
                            <input type="text" name="honeymoon_dest_3"
                                value="<?= htmlspecialchars($settings['honeymoon_dest_3'] ?? '') ?>"
                                placeholder="Ex: Cancún">
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">Salvar Configurações</button>
                </form>
            </div>
        </div>

        <!-- Gallery Tab -->
        <div id="gallery" class="tab-content">
            <div class="card">
                <h3>Adicionar Foto</h3>
                <form method="POST" enctype="multipart/form-data"
                    style="display: flex; gap: 1rem; align-items: center;">
                    <input type="file" name="photo" accept="image/*" required
                        style="border: 1px solid var(--border); padding: 0.5rem; border-radius: 6px;">
                    <button type="submit" class="btn-primary">Enviar</button>
                </form>
            </div>
            <div class="photo-grid">
                <?php foreach ($photos as $photo): ?>
                    <div class="photo-item">
                        <img src="/uploads/<?= htmlspecialchars($photo['filename']) ?>" alt="Gallery Photo">
                        <a href="?delete_photo=<?= $photo['id'] ?>" class="delete-btn"
                            onclick="return confirm('Tem certeza que deseja excluir esta foto?')" title="Excluir">✕</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- RSVPs Tab -->
        <div id="rsvps" class="tab-content">
            <div class="card">
                <h3>Lista de Presença</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Convidados</th>
                            <th>Mensagem</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rsvps as $rsvp):
                            $phone = $rsvp['phone'] ?? '';
                            // Simple mask formatter
                            $phone = preg_replace('/[^0-9]/', '', $phone);
                            if (strlen($phone) === 11) {
                                $phone = sprintf('(%s) %s-%s', substr($phone, 0, 2), substr($phone, 2, 5), substr($phone, 7));
                            }
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($rsvp['name']) ?></td>
                                <td><?= htmlspecialchars($phone ?: '-') ?></td>
                                <td><?= htmlspecialchars($rsvp['guests_count']) ?></td>
                                <td><?= htmlspecialchars($rsvp['message']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($rsvp['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Poll Tab -->
        <div id="poll" class="tab-content">
            <div class="card">
                <h3>Resultados da Enquete: Lua de Mel</h3>
                <?php
                $options = [
                    1 => $settings['honeymoon_dest_1'] ?? 'Opção 1',
                    2 => $settings['honeymoon_dest_2'] ?? 'Opção 2',
                    3 => $settings['honeymoon_dest_3'] ?? 'Opção 3',
                    4 => 'Lua de mel mais caseira'
                ];
                $total_votes = array_sum($poll_results ?? []);
                ?>

                <?php foreach ($options as $key => $label):
                    $votes = $poll_results[$key] ?? 0;
                    $percent = $total_votes > 0 ? round(($votes / $total_votes) * 100) : 0;
                    ?>
                    <div class="poll-item">
                        <div class="poll-label">
                            <span><?= htmlspecialchars($label) ?></span>
                            <strong><?= $votes ?> votos (<?= $percent ?>%)</strong>
                        </div>
                        <div class="poll-bar">
                            <div class="poll-fill" style="width: <?= $percent ?>%"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabId) {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

            event.target.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        }
    </script>
</body>

</html>