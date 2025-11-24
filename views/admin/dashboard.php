<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
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
        }

        .tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid #ddd;
        }

        .tab {
            padding: 1rem;
            cursor: pointer;
            border-bottom: 2px solid transparent;
        }

        .tab.active {
            border-bottom-color: #d4af37;
            font-weight: bold;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        input[type="text"],
        input[type="datetime-local"] {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
        }

        .photo-item {
            position: relative;
        }

        .photo-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
        }

        .photo-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
        }

        .delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 0, 0, 0.8);
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
            font-weight: bold;
            transition: background 0.2s;
        }

        .delete-btn:hover {
            background: red;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Dashboard</h1>
            <a href="/admin/logout" class="btn">Logout</a>
        </div>

        <?php if (isset($success)): ?>
            <div style="background: #d4edda; color: #155724; padding: 1rem; margin-bottom: 1rem; border-radius: 4px;">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <div class="tabs">
            <div class="tab active" onclick="switchTab('settings')">Settings</div>
            <div class="tab" onclick="switchTab('gallery')">Gallery</div>
            <div class="tab" onclick="switchTab('rsvps')">RSVPs</div>
        </div>

        <!-- Settings Tab -->
        <div id="settings" class="tab-content active">
            <div class="card">
                <form method="POST">
                    <input type="hidden" name="update_settings" value="1">
                    <div class="form-group">
                        <label>Couple Names</label>
                        <input type="text" name="couple_names"
                            value="<?= htmlspecialchars($settings['couple_names'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Couple Names Color</label>
                        <input type="color" name="couple_names_color"
                            value="<?= htmlspecialchars($settings['couple_names_color'] ?? '#000000') ?>"
                            style="height: 40px; padding: 2px;">
                    </div>
                    <div class="form-group">
                        <label>Wedding Date</label>
                        <input type="text" name="wedding_date"
                            value="<?= htmlspecialchars($settings['wedding_date'] ?? '') ?>"
                            placeholder="YYYY-MM-DD HH:MM:SS">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="wedding_address"
                            value="<?= htmlspecialchars($settings['wedding_address'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>PIX Key</label>
                        <input type="text" name="pix_key" value="<?= htmlspecialchars($settings['pix_key'] ?? '') ?>">
                    </div>
                    <button type="submit" class="btn-primary">Save Settings</button>
                </form>
            </div>
        </div>

        <!-- Gallery Tab -->
        <div id="gallery" class="tab-content">
            <div class="card">
                <h3>Upload Photo</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="file" name="photo" accept="image/*" required>
                    <button type="submit" class="btn-primary">Upload</button>
                </form>
            </div>
            <div class="photo-grid">
                <?php foreach ($photos as $photo): ?>
                    <div class="photo-item">
                        <img src="/uploads/<?= htmlspecialchars($photo['filename']) ?>" alt="Gallery Photo">
                        <a href="?delete_photo=<?= $photo['id'] ?>" class="delete-btn"
                            onclick="return confirm('Are you sure?')">X</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- RSVPs Tab -->
        <div id="rsvps" class="tab-content">
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Guests</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rsvps as $rsvp): ?>
                            <tr>
                                <td><?= htmlspecialchars($rsvp['name']) ?></td>
                                <td><?= htmlspecialchars($rsvp['phone'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($rsvp['guests_count']) ?></td>
                                <td><?= htmlspecialchars($rsvp['message']) ?></td>
                                <td><?= htmlspecialchars($rsvp['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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