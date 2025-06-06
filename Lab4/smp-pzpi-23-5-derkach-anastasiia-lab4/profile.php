<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$errors = [];
$data = [
    'first_name' => '',
    'last_name' => '',
    'birth_date' => '',
    'bio' => '',
    'profile_picture' => ''
];

$profile = [];

if (file_exists('profile_data.php')) {
    include 'profile_data.php';
    if (isset($profile)) {
        $data = array_merge($data, $profile);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['first_name'] = trim($_POST['first_name'] ?? '');
    $data['last_name'] = trim($_POST['last_name'] ?? '');
    $data['birth_date'] = $_POST['birth_date'] ?? '';
    $data['bio'] = trim($_POST['bio'] ?? '');

    if (strlen($data['first_name']) < 2) $errors[] = 'Ім’я має містити щонайменше 2 символи.';
    if (strlen($data['last_name']) < 2) $errors[] = 'Прізвище має містити щонайменше 2 символи.';

    $birthTimestamp = strtotime($data['birth_date']);
    if (!$birthTimestamp || (time() - $birthTimestamp) / (365.25 * 24 * 60 * 60) < 16) {
        $errors[] = 'Користувачу має бути не менше 16 років.';
    }

    if (strlen($data['bio']) < 50) {
        $errors[] = 'Опис повинен містити щонайменше 50 символів.';
    }

    if (!empty($_FILES['profile_picture']['name'])) {
        $ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $newName = 'photo_' . time() . '.' . $ext;
        $targetPath = __DIR__ . '/uploads/' . $newName;

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetPath)) {
            $data['profile_picture'] = 'uploads/' . $newName;
        } else {
            $errors[] = 'Помилка завантаження фото.';
        }
    }

    if (empty($errors)) {
        $_SESSION['profile'] = $data;

        $phpArrayContent = "<?php\n\$profile = " . var_export($data, true) . ";\n?>";
        file_put_contents('profile_data.php', $phpArrayContent);

        $profile = $data;
    }
}
?>

<style>
    .profile-container {
        max-width: 600px;
        margin: 40px auto;
        background-color: #f9f9f9;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        font-family: sans-serif;
    }

    .profile-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .profile-container label {
        display: block;
        margin-bottom: 12px;
        font-weight: bold;
    }

    .profile-container input,
    .profile-container textarea {
        width: 100%;
        padding: 8px;
        margin-top: 4px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    .profile-container textarea {
        resize: vertical;
    }

    .profile-container button {
        width: 100%;
        margin-top: 20px;
        background-color: #007BFF;
        color: white;
        padding: 10px;
        font-weight: bold;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .profile-container button:hover {
        background-color: #0056b3;
    }

    .error {
        color: red;
        margin-bottom: 10px;
        text-align: center;
    }

    .profile-image-preview {
        margin-top: 12px;
        text-align: center;
    }

    .profile-image-preview img {
        max-width: 200px;
        border-radius: 4px;
    }
</style>

<div class="profile-container">
    <h2>Профіль користувача</h2>

    <?php if (!empty($errors)): ?>
        <ul class="error">
            <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <label>Ім’я:
            <input type="text" name="first_name" value="<?= htmlspecialchars($data['first_name']) ?>" required>
        </label>
        <label>Прізвище:
            <input type="text" name="last_name" value="<?= htmlspecialchars($data['last_name']) ?>" required>
        </label>
        <label>Дата народження:
            <input type="date" name="birth_date" value="<?= htmlspecialchars($data['birth_date']) ?>" required>
        </label>
        <label>Опис:
            <textarea name="bio" rows="5" required><?= htmlspecialchars($data['bio']) ?></textarea>
        </label>
        <label>Фото:
            <input type="file" name="profile_picture" accept="image/*">
        </label>

        <?php if (!empty($data['profile_picture'])): ?>
            <div class="profile-image-preview">
                <img src="<?= htmlspecialchars($data['profile_picture']) ?>" alt="Фото">
            </div>
        <?php endif; ?>

        <button type="submit">Зберегти</button>
    </form>
</div>