<?php
require_once 'auth.php';

$dataFile  = dirname(__DIR__) . '/data/portfolio.json';
$uploadDir = dirname(__DIR__) . '/assets/portfolio/';

// ── Helpers ────────────────────────────────────────────────────────────────
function loadPortfolio($file) {
    if (!file_exists($file)) return array();
    $data = json_decode(file_get_contents($file), true);
    return is_array($data) ? $data : array();
}

function savePortfolio($file, $items) {
    return file_put_contents($file, json_encode(array_values($items), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function nextPortfolioId($items) {
    $max = 0;
    foreach ($items as $i) {
        if (!empty($i['id']) && (int)$i['id'] > $max) $max = (int)$i['id'];
    }
    return $max + 1;
}

function handlePortfolioUpload($uploadDir, &$error) {
    if (empty($_FILES['image']['name'])) { $error = 'An image is required.'; return false; }

    $allowed  = array('image/jpeg', 'image/png');
    $maxSize  = 6 * 1024 * 1024; // 6 MB
    $tmpPath  = $_FILES['image']['tmp_name'];
    $origName = $_FILES['image']['name'];
    $fileSize = $_FILES['image']['size'];
    $fileErr  = $_FILES['image']['error'];

    if ($fileErr !== UPLOAD_ERR_OK)          { $error = 'Upload error (code ' . $fileErr . ').'; return false; }
    if ($fileSize > $maxSize)                { $error = 'Image must be under 6 MB.'; return false; }

    $realMime = mime_content_type($tmpPath);
    if (!in_array($realMime, $allowed))      { $error = 'Only JPG and PNG images are allowed.'; return false; }

    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $ext      = ($realMime === 'image/png') ? 'png' : 'jpg';
    $base     = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', pathinfo($origName, PATHINFO_FILENAME)), '-'));
    $filename = $base . '-' . time() . '.' . $ext;
    $dest     = $uploadDir . $filename;

    if (!move_uploaded_file($tmpPath, $dest)) { $error = 'Could not save file. Check assets/portfolio/ permissions.'; return false; }
    return 'assets/portfolio/' . $filename;
}

$action       = $_GET['action'] ?? 'list';
$editId       = isset($_GET['id']) ? (int)$_GET['id'] : null;
$feedback     = '';
$feedbackType = 'success';

// ── Handle POST ────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $items   = loadPortfolio($dataFile);
    $pAction = $_POST['_action'] ?? '';

    // Save (add or update)
    if ($pAction === 'save') {
        $id       = !empty($_POST['id']) ? (int)$_POST['id'] : null;
        $title    = trim($_POST['title']       ?? '');
        $desc     = trim($_POST['description'] ?? '');
        $category = trim($_POST['category']    ?? '');
        $featured = isset($_POST['featured'])  && $_POST['featured'] === '1';

        if (empty($title)) {
            $feedback = 'Title is required.'; $feedbackType = 'error';
            $action = $id ? 'edit' : 'new'; $editId = $id;
        } else {
            $uploadError = '';
            $newImage    = handlePortfolioUpload($uploadDir, $uploadError);

            if ($newImage === false && !$id) {
                // New item — image is required
                $feedback = $uploadError; $feedbackType = 'error'; $action = 'new';
            } elseif ($newImage === false && !empty($uploadError)) {
                // Edit — upload was attempted but failed
                $feedback = $uploadError; $feedbackType = 'error'; $action = 'edit'; $editId = $id;
            } else {
                if ($id) {
                    // Update existing
                    foreach ($items as &$item) {
                        if ((int)$item['id'] === $id) {
                            $item['title']       = $title;
                            $item['description'] = $desc;
                            $item['category']    = $category;
                            $item['featured']    = $featured;
                            if ($newImage !== null && $newImage !== false) {
                                // Delete old image file
                                if (!empty($item['image'])) {
                                    $old = dirname(__DIR__) . '/' . $item['image'];
                                    if (file_exists($old)) @unlink($old);
                                }
                                $item['image'] = $newImage;
                            }
                            break;
                        }
                    }
                    unset($item);
                    $feedback = 'Portfolio item updated.';
                } else {
                    // Add new
                    $items[] = array(
                        'id'          => nextPortfolioId($items),
                        'title'       => $title,
                        'description' => $desc,
                        'category'    => $category,
                        'featured'    => $featured,
                        'image'       => $newImage,
                        'date_added'  => date('Y-m-d'),
                    );
                    $feedback = 'Portfolio item added!';
                }
                savePortfolio($dataFile, $items);
                $action = 'list';
            }
        }
    }

    // Delete
    if ($pAction === 'delete') {
        $deleteId = (int)($_POST['id'] ?? 0);
        foreach ($items as $item) {
            if ((int)$item['id'] === $deleteId && !empty($item['image'])) {
                $imgFile = dirname(__DIR__) . '/' . $item['image'];
                if (file_exists($imgFile)) @unlink($imgFile);
            }
        }
        $items    = array_filter($items, fn($i) => (int)$i['id'] !== $deleteId);
        savePortfolio($dataFile, $items);
        $feedback = 'Item deleted.';
        $action   = 'list';
    }
}

// Load for display
$items = loadPortfolio($dataFile);

// Sort: featured first, then newest
usort($items, function($a, $b) {
    if (!empty($a['featured']) && empty($b['featured'])) return -1;
    if (empty($a['featured']) && !empty($b['featured'])) return 1;
    return strcmp($b['date_added'] ?? '', $a['date_added'] ?? '');
});

$editItem = null;
if ($action === 'edit' && $editId) {
    foreach ($items as $i) {
        if ((int)$i['id'] === $editId) { $editItem = $i; break; }
    }
    if (!$editItem) $action = 'list';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Portfolio — Miracale Design Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Nunito:wght@300;400;500;600&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../styles.css" />
  <link rel="stylesheet" href="admin.css" />
  <style>
    /* Thumbnail grid in list view */
    .portfolio-thumb-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 1.2rem;
      margin-top: 1rem;
    }
    .portfolio-thumb-card {
      background: var(--white);
      border: 1px solid rgba(28,26,23,0.08);
      border-radius: 14px;
      overflow: hidden;
      transition: box-shadow 0.2s;
    }
    .portfolio-thumb-card:hover { box-shadow: 0 8px 28px rgba(28,26,23,0.1); }
    .portfolio-thumb-img {
      aspect-ratio: 4/3;
      overflow: hidden;
      background: var(--parchment);
    }
    .portfolio-thumb-img img {
      width: 100%; height: 100%; object-fit: cover; display: block;
      transition: transform 0.3s;
    }
    .portfolio-thumb-card:hover .portfolio-thumb-img img { transform: scale(1.04); }
    .portfolio-thumb-body {
      padding: 0.8rem 1rem 1rem;
    }
    .portfolio-thumb-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1rem; font-weight: 500; color: var(--ink);
      margin-bottom: 0.2rem; white-space: nowrap;
      overflow: hidden; text-overflow: ellipsis;
    }
    .portfolio-thumb-cat {
      font-size: 0.7rem; font-weight: 600; letter-spacing: 0.1em;
      text-transform: uppercase; color: var(--terra); margin-bottom: 0.6rem;
    }
    .portfolio-thumb-actions {
      display: flex; gap: 0.5rem;
    }

    /* Upload area */
    .img-upload-area {
      border: 2px dashed rgba(28,26,23,0.15); border-radius: 12px;
      padding: 1.8rem; text-align: center;
      transition: border-color 0.2s, background 0.2s;
      cursor: pointer; position: relative;
    }
    .img-upload-area:hover { border-color: var(--green); background: rgba(45,74,62,0.03); }
    .img-upload-area input[type="file"] {
      position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .img-upload-icon  { font-size: 2.2rem; margin-bottom: 0.4rem; }
    .img-upload-label { font-size: 0.85rem; font-weight: 600; color: var(--ink-soft); }
    .img-upload-hint  { font-size: 0.74rem; color: var(--ink-soft); opacity: 0.6; margin-top: 0.2rem; }
    .img-preview-wrap { margin-top: 1rem; }
    .img-preview-wrap img {
      max-height: 200px; border-radius: 10px; object-fit: cover;
      box-shadow: 0 4px 16px rgba(28,26,23,0.12);
    }
    .img-preview-name { font-size: 0.75rem; color: var(--ink-soft); margin-top: 0.4rem; font-style: italic; }

    .featured-pill {
      display: inline-block; font-size: 0.65rem; font-weight: 700;
      letter-spacing: 0.1em; text-transform: uppercase;
      background: rgba(212,168,67,0.15); color: #8a6c1c;
      padding: 0.18rem 0.5rem; border-radius: 5px; margin-left: 0.4rem;
    }
  </style>
</head>
<body class="admin-body">

<?php include 'admin-nav.php'; ?>

<main class="admin-main">
  <div class="admin-container">

    <?php if ($feedback): ?>
      <div class="admin-feedback show <?= $feedbackType ?>">
        <?= htmlspecialchars($feedback) ?>
      </div>
    <?php endif; ?>

    <?php if ($action === 'list'): ?>
    <!-- ══ LIST VIEW ══ -->
    <div class="admin-page-header">
      <div>
        <h1 class="admin-page-title">Portfolio</h1>
        <p class="admin-page-sub"><?= count($items) ?> piece<?= count($items) !== 1 ? 's' : '' ?> in the gallery</p>
      </div>
      <a href="?action=new" class="admin-btn admin-btn-primary">+ Add Piece</a>
    </div>

    <?php if (empty($items)): ?>
      <div class="admin-empty">
        <div class="admin-empty-icon">🖼️</div>
        <p>No portfolio pieces yet. <a href="?action=new">Add your first piece →</a></p>
      </div>
    <?php else: ?>
      <div class="portfolio-thumb-grid">
        <?php foreach ($items as $item): ?>
        <div class="portfolio-thumb-card">
          <div class="portfolio-thumb-img">
            <img src="../<?= htmlspecialchars($item['image']) ?>"
                 alt="<?= htmlspecialchars($item['title']) ?>" />
          </div>
          <div class="portfolio-thumb-body">
            <div class="portfolio-thumb-title">
              <?= htmlspecialchars($item['title']) ?>
              <?php if (!empty($item['featured'])): ?>
                <span class="featured-pill">Featured</span>
              <?php endif; ?>
            </div>
            <div class="portfolio-thumb-cat"><?= htmlspecialchars($item['category'] ?? '—') ?></div>
            <div class="portfolio-thumb-actions">
              <a href="?action=edit&id=<?= (int)$item['id'] ?>" class="admin-table-link">Edit</a>
              <form method="POST" style="display:inline"
                    onsubmit="return confirm('Delete this piece? The image file will also be removed.')">
                <input type="hidden" name="_action" value="delete" />
                <input type="hidden" name="id" value="<?= (int)$item['id'] ?>" />
                <button type="submit" class="admin-table-link danger"
                        style="background:none;border:none;cursor:pointer;padding:0;font-size:inherit;font-family:inherit">
                  Delete
                </button>
              </form>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php else: ?>
    <!-- ══ ADD / EDIT FORM ══ -->
    <div class="admin-page-header">
      <div>
        <h1 class="admin-page-title">
          <?= $action === 'edit' ? 'Edit Piece' : 'Add Portfolio Piece' ?>
        </h1>
      </div>
      <a href="?action=list" class="admin-btn admin-btn-ghost">← Back to Portfolio</a>
    </div>

    <form method="POST" action="portfolio.php" enctype="multipart/form-data">
      <input type="hidden" name="_action" value="save" />
      <?php if ($editItem): ?>
        <input type="hidden" name="id" value="<?= (int)$editItem['id'] ?>" />
      <?php endif; ?>

      <div class="admin-form-card">
        <h3>Image <?php if (!$editItem): ?><span style="font-size:0.8rem;font-weight:400;color:var(--ink-soft);opacity:0.7;">*required</span><?php endif; ?></h3>

        <?php if ($editItem && !empty($editItem['image'])): ?>
          <div style="margin-bottom:1rem;">
            <div class="admin-label" style="margin-bottom:0.5rem;">Current image</div>
            <img src="../<?= htmlspecialchars($editItem['image']) ?>"
                 alt="current"
                 style="max-height:180px; border-radius:10px; object-fit:cover;
                        box-shadow:0 4px 16px rgba(28,26,23,0.12);" />
            <div style="font-size:0.78rem;color:var(--ink-soft);margin-top:0.4rem;opacity:0.7;">
              Upload a new image below to replace it.
            </div>
          </div>
          <div class="admin-label" style="margin-bottom:0.5rem;">Replace image (optional)</div>
        <?php endif; ?>

        <div class="img-upload-area" id="uploadArea">
          <input type="file" name="image" id="imageInput" accept="image/jpeg,image/png" />
          <div class="img-upload-icon">🖼️</div>
          <div class="img-upload-label">
            <?= $editItem ? 'Click to choose a replacement' : 'Click to choose an image' ?>
          </div>
          <div class="img-upload-hint">JPG or PNG · max 6 MB</div>
          <div id="newPreview" style="display:none;" class="img-preview-wrap">
            <img id="newPreviewImg" src="" alt="preview" />
            <div class="img-preview-name" id="newPreviewName"></div>
          </div>
        </div>
      </div>

      <div class="admin-form-card">
        <h3>Details</h3>

        <div class="admin-form-row full">
          <div class="admin-form-group">
            <label class="admin-label" for="title">Title *</label>
            <input class="admin-input" type="text" id="title" name="title"
                   placeholder="e.g. Clay Fox, Blue Mountains Watercolor..."
                   value="<?= htmlspecialchars($editItem['title'] ?? '') ?>" required />
          </div>
        </div>

        <div class="admin-form-row full">
          <div class="admin-form-group">
            <label class="admin-label" for="description">Description</label>
            <input class="admin-input" type="text" id="description" name="description"
                   placeholder="e.g. Hand-sculpted polymer clay · 2024"
                   value="<?= htmlspecialchars($editItem['description'] ?? '') ?>" />
            <div class="admin-hint">Shown in the lightbox caption on the portfolio page. Keep it short.</div>
          </div>
        </div>

        <div class="admin-form-row">
          <div class="admin-form-group">
            <label class="admin-label" for="category">Category</label>
            <select class="admin-select" id="category" name="category">
              <?php
                $cats = array('Clay Animals', 'Watercolors', 'Wood Art', 'Keychains', 'Digital Art', 'Other');
                $currentCat = $editItem['category'] ?? '';
                foreach ($cats as $cat):
              ?>
                <option value="<?= htmlspecialchars($cat) ?>"
                  <?= $currentCat === $cat ? 'selected' : '' ?>>
                  <?= htmlspecialchars($cat) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <div class="admin-hint">Used for the filter buttons on the portfolio page.</div>
          </div>
          <div class="admin-form-group" style="display:flex; align-items:flex-end; padding-bottom:0.2rem;">
            <label class="toggle-wrap" style="gap:1rem;">
              <span class="toggle-label" style="font-size:0.82rem; font-weight:600; color:var(--ink-soft);">
                Mark as featured
              </span>
              <label class="toggle-switch">
                <input type="checkbox" name="featured" value="1" id="featuredToggle"
                       <?= !empty($editItem['featured']) ? 'checked' : '' ?> />
                <span class="toggle-slider"></span>
              </label>
            </label>
          </div>
        </div>

        <div style="display:flex; justify-content:flex-end; margin-top:1rem;">
          <button type="submit" class="admin-btn admin-btn-primary">
            <?= $action === 'edit' ? 'Save Changes' : 'Add to Portfolio' ?>
          </button>
        </div>
      </div>

    </form>
    <?php endif; ?>

  </div>
</main>

<script>
  var imageInput  = document.getElementById('imageInput');
  var newPreview  = document.getElementById('newPreview');
  var previewImg  = document.getElementById('newPreviewImg');
  var previewName = document.getElementById('newPreviewName');

  if (imageInput) {
    imageInput.addEventListener('change', function() {
      var file = imageInput.files[0];
      if (!file) { newPreview.style.display = 'none'; return; }
      var reader = new FileReader();
      reader.onload = function(e) {
        previewImg.src = e.target.result;
        previewName.textContent = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
        newPreview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    });
  }
</script>
</body>
</html>